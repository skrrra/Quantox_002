<?php

namespace App\Database;

use App\Http\HttpMethods;

class DatabaseQueries
{
    private $httpMethods;

    public function __construct()
    {
        $this->httpMethods = new HttpMethods();
    }

    public function getAllInterns()
    {
        return $this->httpMethods->get('SELECT i.id, i.full_name, i.city, i.group_id, g.name AS group_name 
                                        FROM interns AS i 
                                        INNER JOIN groups AS g ON i.group_id = g.id');
    }

    public function getIntern($id)
    {
        return $this->httpMethods->get('SELECT i.id, i.full_name, i.city, i.group_id, g.name AS group_name 
                                        FROM interns AS i 
                                        INNER JOIN groups AS g ON i.group_id = g.id 
                                        WHERE i.id = '.$id);
    }

    public function createIntern($data)
    {
        $queryParams = [ $data['group_id'], $data['full_name'], $data['city']];
        $this->httpMethods->post("`interns` (`group_id`, `full_name`, `city`)", $queryParams);

        return ['groupId'  => $data['group_id'], 
                'name'     => $data['full_name'], 
                'city'     => $data['city']];
    }

    public function updateIntern($id, $queryParams)
    {
        return $this->httpMethods->patch($queryParams, $id, 'interns');
    }

    public function deleteIntern($id)
    {
        return $this->httpMethods->delete($id, 'interns');
    }

    //
    // Mentor Api endpoint
    //

    public function getMentorList()
    {
        return $this->httpMethods->get("SELECT m.id mentor_id, m.full_name mentor_name, g.id group_id, g.name group_name 
                                        FROM groups g 
                                        INNER JOIN mentors m ON g.id = m.group_id");
    }

    public function getMentor($id)
    {
        return $this->httpMethods->get("SELECT m.id mentor_id, m.full_name mentor_name, m.group_id, g.name group_name 
                                        FROM mentors m 
                                        INNER JOIN groups g ON m.group_id = g.id 
                                        WHERE m.id = ".$id);
    }

    public function createMentor($fullName, $groupId)
    {
        if (!is_numeric($groupId)) {
            return false;
        }

        $queryParams = [(int) $groupId, $fullName];

        $queryData = $this->httpMethods->post("`mentors` (`group_id`, `full_name`)", $queryParams);

        if (!$queryData) {
            return false;
        }

        return ['groupId' => $groupId, 'name' => $fullName];
    }

    public function updateMentor($queryParams, $id)
    {
        return $this->httpMethods->patch($queryParams, $id, 'mentors');
    }

    public function deleteMentor($id)
    {
        return $this->httpMethods->delete($id, 'mentors');
    }

    //
    // Group Api endpoint
    //

    public function getGroupList($queryParams)
    {
        // check if per_page (how many results you want to be shown pre page) and page 
        // parameters are set if so set variables $rowCount and $page, if not set them as null
        if (isset($queryParams['per_page']) && isset($queryParams['page'])) {
            $rowCount = $queryParams['per_page'];
            $page = ($queryParams['page'] - 1) * $rowCount;
        } else {
            $rowCount = null;
            $page = null;
        }

        if ($rowCount != null) {
            $groups = $this->httpMethods->get("SELECT id AS group_id, name AS group_name 
                                               FROM groups 
                                               LIMIT ".$rowCount." OFFSET ".$page);
        } else {
            $groups = $this->httpMethods->get("SELECT id AS group_id, name AS group_name 
                                               FROM groups");
        }
        
        // getting all group ids and converting them into string for sql query
        $groupIds = array_map(function ($group) {
            return $group['group_id'];
        }, $groups);
        
        $groupIds = implode(',', $groupIds);

        $mentors = $this->httpMethods->get("SELECT id AS mentor_id, group_id, full_name AS mentor_name 
                                            FROM mentors 
                                            WHERE group_id in (" . $groupIds . ")");

        $interns = $this->httpMethods->get("SELECT id AS intern_id, group_id, full_name AS intern_name, city AS intern_city 
                                            FROM interns 
                                            WHERE group_id in (" . $groupIds . ")");
       
        $array = [];

        // formating json response
        foreach ($groups as $group) {
            $tmpMentors = [];
            $tmpInterns = [];
            foreach ($mentors as $mentor) {
                if ($mentor['group_id'] == $group['group_id'] && !in_array($mentor['mentor_id'], $tmpMentors)) {
                    unset($mentor['group_id']);
                    $tmpMentors[] = $mentor;
                }
            }
            foreach ($interns as $intern) {
                if ($intern['group_id'] == $group['group_id'] && !in_array($intern['intern_id'], $tmpInterns)) {
                    unset($intern['group_id']);
                    $tmpInterns[] = $intern;
                }
            }
            $group['mentors'] = $tmpMentors;
            $group['interns'] = $tmpInterns;

            $array[] = $group;
        }

        return $array;
    }

    public function getGroup($id)
    {
        $data = $this->httpMethods->get("SELECT g.id AS group_id, g.name AS group_name, m.full_name AS mentor_name, m.id AS mentor_id, i.id AS intern_id, i.full_name AS intern_name 
                                         FROM groups AS g 
                                         INNER JOIN mentors AS m ON m.group_id = g.id 
                                         INNER JOIN interns AS i ON i.group_id = g.id 
                                         WHERE g.id = ".$id);
    
        foreach ($data as $key => $value) {
            $groupId[]    = $value['group_id'];
            $groupName[]  = $value['group_name'];
            $mentorId[]   = $value['mentor_id'];
            $mentorName[] = $value['mentor_name'];
            $internId[]   = $value['intern_id'];
            $internName[] = $value['intern_name'];
        }

        $array = ['group' => ['group_id' => implode(array_unique($groupId)),
        'group_name' => implode(array_unique($groupName))]];

        foreach (array_unique($mentorId) as $key => $id) {
            $array['mentor'][] = array( 'mentor_id'   => $mentorId[$key], 
                                        'mentor_name' => $mentorName[$key]);
        }
        foreach (array_unique($internId) as $key => $id) {
            $array['intern'][] = array( 'intern_id'   => $internId[$key], 
                                        'intern_name' => $internName[$key]);
        }

        return $array;
    }

    public function createGroup($groupName)
    {
        $queryParams = [$groupName];
        $queryData = $this->httpMethods->post("`groups` ( `name` )", $queryParams);

        if (!$queryData) {
            return false;
        }

        return ['group_name' => $groupName];
    }

    public function updateGroup($id, $queryParams)
    {
        return $this->httpMethods->patch($queryParams, $id, 'groups');
    }

    public function deleteGroup($id)
    {
        return $this->httpMethods->delete($id, 'groups');
    }

    public function getInternComments($id)
    {
        $queryData = $this->httpMethods->get('SELECT i.full_name AS intern_name, m.full_name AS mentor_name, ic.mentor_id, ic.id AS comment_id, ic.comment
                                              FROM interns_comments AS ic 
                                              INNER JOIN mentors AS m ON m.id = ic.mentor_id
                                              INNER JOIN interns AS i ON i.id = ic.intern_id
                                              WHERE ic.intern_id = ' . $id . ' 
                                              ORDER BY ic.created_at DESC');
        return $queryData;
    }

    public function createInternComment($queryParams)
    {
        $mentorGroup = $this->httpMethods->get('SELECT group_id 
                                                FROM mentors 
                                                WHERE id = ' . $queryParams['mentor_id']);
        $internGroup = $this->httpMethods->get('SELECT group_id 
                                                FROM interns 
                                                WHERE id = ' . $queryParams['intern_id']);

        //Comparing if Mentor (who is making comment) is in the group with Intern (who Mentor is writting comment to)
        //If yes then query will be executed, if not return false which means "Http Code: 403, Forbidden"
        if($mentorGroup[0]['group_id'] === $internGroup[0]['group_id']){
            $queryParams = [$queryParams['intern_id'], $queryParams['mentor_id'], $queryParams['comment']];
            $queryData = $this->httpMethods->post("`interns_comments` ( `intern_id`, `mentor_id`, `comment` )", $queryParams);
        }else{
            return false;
        }
        return ['intern_id' => $queryParams[0], 'mentor_id' => $queryParams[1], 'comment' => $queryParams[2]];
    }

    public function updateInternComment($queryParams, $id)
    {
        return $this->httpMethods->patch($queryParams, $id, 'interns_comments');
    }

    public function deleteInternComment($id)
    {
        return $this->httpMethods->delete($id, 'interns_comments');
    }

}
