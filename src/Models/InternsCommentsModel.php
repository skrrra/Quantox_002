<?php

namespace App\Models;

use App\Models\BaseModel;

class InternsCommentsModel extends BaseModel
{
    /**
     * @return array
     */
    public function getInternComments(int $id) : array
    {
        $queryData = $this->get('SELECT i.full_name AS intern_name, m.full_name AS mentor_name, ic.mentor_id, ic.id AS comment_id, ic.comment
                                 FROM interns_comments AS ic 
                                 INNER JOIN mentors AS m ON m.id = ic.mentor_id
                                 INNER JOIN interns AS i ON i.id = ic.intern_id
                                 WHERE ic.intern_id = ' . $id . ' 
                                 ORDER BY ic.created_at DESC');
        return $queryData;
    }

    /**
     * @return array
     */
    public function createInternComment(array $queryParams) : array
    {
        $mentorGroup = $this->get('SELECT group_id 
                                   FROM mentors 
                                   WHERE id = ' . $queryParams['mentor_id']);
        $internGroup = $this->get('SELECT group_id 
                                   FROM interns 
                                   WHERE id = ' . $queryParams['intern_id']);

        //Comparing if Mentor (who is making comment) is in the group with Intern (who Mentor is writting comment to)
        //If yes then query will be executed, if not return false which means "Http Code: 403, Forbidden"
        if ($mentorGroup[0]['group_id'] === $internGroup[0]['group_id']) {
            $queryParams = [$queryParams['intern_id'], $queryParams['mentor_id'], $queryParams['comment']];
            $this->post("`interns_comments` ( `intern_id`, `mentor_id`, `comment` )", $queryParams);
        } else {
            return false;
        }
        return $queryParams;
    }

    /**
     * @return array
     */
    public function updateInternComment(array $queryParams, int $id) : array
    {
        return $this->patch($queryParams, $id, 'interns_comments');
    }

    /**
     * @return array
     */
    public function deleteInternComment(int $id) : array
    {
        return $this->delete($id, 'interns_comments');
    }
}