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

    public function getInternList()
    {
        return $this->httpMethods->get('SELECT i.*, g.name group_name FROM interns i INNER JOIN groups g ON i.group_id = g.id');
    }

    public function getIntern($id)
    {
        return $this->httpMethods->get('SELECT i.*, g.name group_name FROM interns i INNER JOIN groups g ON i.group_id = g.id WHERE i.id = '.$id.";");
    }

    public function createIntern($data)
    {
        $params = [$data['mentor_id'], $data['group_id'], $data['full_name'], $data['city']];
        $this->httpMethods->post("`interns` (`mentor_id`, `group_id`, `full_name`, `city`)", $params);

        return ['mentorId' => $data['mentor_id'], 'groupId' => $data['group_id'], 'name' => $data['full_name'], 'city' => $data['city']];
    }

    public function updateIntern($id, $data)
    {
        return $this->httpMethods->patch($data, $id, 'interns');
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
        return $this->httpMethods->get("SELECT m.*, g.name group_name FROM mentors m INNER JOIN groups g ON m.group_id = g.id");
    }

    public function getMentor($id)
    {
        return $this->httpMethods->get("SELECT m.*, g.name group_name FROM mentors m INNER JOIN groups g ON m.group_id = g.id WHERE m.id = ".$id);
    }

    public function createMentor($fullName, $groupId)
    {
        if(!is_numeric($groupId)){
            return false;
        }

        $params = [(int) $groupId, $fullName];

        $request = $this->httpMethods->post("`mentors` (`group_id`, `full_name`)", $params);

        if(!$request){
            return false;
        }

        return ['groupId' => $groupId, 'name' => $fullName];
    }

    public function updateMentor($data, $id)
    {
        return $this->httpMethods->patch($data, $id, 'mentors');
    }

    public function deleteMentor($id)
    {
        return $this->httpMethods->delete($id, 'mentors');
    }
}