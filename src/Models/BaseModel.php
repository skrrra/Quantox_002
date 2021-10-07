<?php

namespace App\Models;

use App\Database\Connection;
use PDO;

class BaseModel
{
    private $database;

    /**
     * BaseModel constructor
     */
    public function __construct()
    {
        $this->database = new Connection();
        $this->database = $this->database->connect();
    }

    /**
     * @return array
     */
    protected function get(string $query) : array
    {
        $data = $this->database->query($query);

        if($data == false){
            return [];
        }

        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    protected function post(string $query, array $params)
    {
        $place_holders = implode(',', array_fill(0, count($params), '?'));

        $data = $this->database->prepare("INSERT INTO ".$query." VALUES ( ".$place_holders." )");
        $data->execute($params);

        if($data == false){
            return [];
        }
        return $params;
    }

    /**
     * @return array
     */
    protected function patch(array $params, int $id, string $table) : array
    {
        foreach ($params as $key => $param) {
            $values[] = $key . '=:' . $key;
        }
        $values = implode(',', $values);

        $data = $this->database->prepare("UPDATE ".$table." SET " . $values . " WHERE ".$table.".id = ".$id);
        $data->execute($params);

        if($data == false){
            return [];
        }
        return $params;
    }

    /**
     * @return array
     */
    protected function delete(int $id, string $table) : array
    {
        $data = $this->database->prepare("DELETE FROM `".$table."` WHERE id = ?");
        $data->execute([$id]);

        if ($data->rowCount() < 1) {
            return [];
        }
        return ['group_id' => $id];
    }
}
