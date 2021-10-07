<?php

namespace App\Models;

class GroupsModel extends BaseModel
{
    /**
     * @return array
     */
    public function getGroupList(array $queryParams) : array
    {
        // check if per_page (how many results you want to be shown pre page) and page
        // parameters are set if so set variables $rowCount and $page, if not set them as null
        if (isset($queryParams['per_page']) && isset($queryParams['page'])) {
            $rowCount = $queryParams['per_page'];
            $page     = ($queryParams['page'] - 1) * $rowCount;
        } else {
            $rowCount = null;
            $page     = null;
        }

        if ($rowCount != null) {
            $groups = $this->get("SELECT id AS group_id, name AS group_name 
                                  FROM groups 
                                  LIMIT " . $rowCount . " OFFSET " . $page);
        } else {
            $groups = $this->get("SELECT id AS group_id, name AS group_name 
                                  FROM groups");
        }

        // getting all group ids and converting them into string for sql query
        $groupIds = array_map(function ($group) {
            return $group['group_id'];
        }, $groups);

        $groupIds = implode(',', $groupIds);

        $mentors = $this->get("SELECT id AS mentor_id, group_id, full_name AS mentor_name 
                               FROM mentors 
                               WHERE group_id in (" . $groupIds . ")");

        $interns = $this->get("SELECT id AS intern_id, group_id, full_name AS intern_name, city AS intern_city 
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

    /**
     * @return array
     */
    public function getGroup(int $id) : array
    {
        $array = array();

        $group  = $this->get("SELECT g.id AS group_id, g.name AS group_name, m.full_name AS mentor_name, m.id AS mentor_id, i.id AS intern_id, i.full_name AS intern_name
                              FROM groups AS g 
                              LEFT OUTER JOIN mentors AS m ON m.group_id = g.id
                              LEFT OUTER JOIN interns AS i ON i.group_id = g.id
                              WHERE g.id = ".$id);

        if(empty($group)){
            return [];
        }

        foreach ($group as $value) {
            $groupId[]    = $value['group_id'];
            $groupName[]  = $value['group_name'];
            $mentorId[]   = $value['mentor_id'];
            $mentorName[] = $value['mentor_name'];
            $internId[]   = $value['intern_id'];
            $internName[] = $value['intern_name'];
        }

        if(!empty($groupId)){
            $array = ['group' => ['group_id'   => implode(array_unique($groupId)),
                                  'group_name' => implode(array_unique($groupName))]];
        }

        if(isset($mentorId)){
            foreach (array_unique($mentorId) as $key => $id) {
                $array['mentor'][] = ['mentor_id'   => $mentorId[$key],
                                      'mentor_name' => $mentorName[$key]];
            }
        }

        if(isset($internId)){
            foreach (array_unique($internId) as $key => $id) {
                $array['intern'][] = ['intern_id'   => $internId[$key],
                                      'intern_name' => $internName[$key]];
            }
        }

        return $array;
    }

    /**
     * @return array
     */
    public function createGroup(string $groupName) : array
    {
        $queryParams = [$groupName];
        $queryData   = $this->post("`groups` ( `name` )", $queryParams);

        if (empty($queryData)) {
            return [];
        }

        return $queryData;
    }

    /**
     * @return void
     */
    public function updateGroup(int $id, array $queryParams) : void
    {
        $this->patch($queryParams, $id, 'groups');
    }

    /**
     * @return array
     */
    public function deleteGroup(int $id) : array
    {
        return $this->delete($id, 'groups');
    }
}