<?php

namespace App\Models;

use App\Models\BaseModel;

class MentorsModel extends BaseModel
{
    /**
     * @return array
     */
    public function getMentorList() : array
    {
        return $this->get("SELECT m.id mentor_id, m.full_name mentor_name, g.id group_id, g.name group_name 
                           FROM mentors m 
                           LEFT OUTER JOIN groups g ON m.group_id = g.id
                           ORDER BY m.id ASC");
    }

    /**
     * @return array
     */
    public function getMentor(int $id) : array
    {
        return $this->get("SELECT m.id mentor_id, m.full_name mentor_name, g.id group_id, g.name group_name 
                           FROM mentors m 
                           LEFT OUTER JOIN groups g ON m.group_id = g.id 
                           WHERE m.id = " . $id);
    }

    /**
     * @return array
     */
    public function createMentor(string $fullName, int $groupId) : array
    {
        $queryParams = [$groupId, $fullName];

        $queryData = $this->post("`mentors` (`group_id`, `full_name`)", $queryParams);

        if (!$queryData) {
            return false;
        }

        return ['groupId' => $groupId, 'name' => $fullName];
    }

    /**
     * @return void
     */
    public function updateMentor(array $queryParams, int $id) : void
    {
        $this->patch($queryParams, $id, 'mentors');
    }

    /**
     * @return array
     */
    public function deleteMentor(int $id) : array
    {
        return $this->delete($id, 'mentors');
    }
}
