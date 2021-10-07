<?php

namespace App\Models;

use App\Models\BaseModel;

class InternsModel extends BaseModel
{
    /**
     * @return array
     */
    public function getAllInterns() : array
    {
        return $this->get('SELECT i.id, i.full_name, i.city, g.id AS group_id, g.name AS group_name 
                           FROM interns AS i 
                           LEFT OUTER JOIN groups AS g ON i.group_id = g.id 
                           ORDER BY i.id ASC');
    }

    /**
     * @return array
     */
    public function getIntern(int $id) : array
    {
        return $this->get('SELECT i.id, i.full_name, i.city, g.id AS group_id, g.name AS group_name 
                           FROM interns AS i 
                           LEFT OUTER JOIN groups AS g ON i.group_id = g.id 
                           WHERE i.id = ' . $id);
    }

    /**
     * @return array
     */
    public function createIntern(array $data) : array
    {
        $queryParams = [$data['group_id'], $data['full_name'], $data['city']];

        $this->post("`interns` (`group_id`, `full_name`, `city`)", $queryParams);

        return ['groupId' => $data['group_id'],
                'name'    => $data['full_name'],
                'city'    => $data['city']];
    }

    /**
     * @return array
     */
    public function updateIntern(int $id, array $queryParams) : array
    {
        return $this->patch($queryParams, $id, 'interns');
    }

    /**
     * @return array
     */
    public function deleteIntern(int $id) : array
    {
        return $this->delete($id, 'interns');
    }
}
