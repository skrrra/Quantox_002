<?php

namespace App\Http;

use App\Database\Connection;
use PDO;

class HttpMethods
{
    private $database;

    public function __construct()
    {
        $this->database = new Connection();
    }

    public function get($query)
    {
        $data = $this->database->connect()->query($query)->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return false;
        }
        return $data;
    }

    public function post($query, $params)
    {
        $place_holders = implode(',', array_fill(0, count($params), '?'));

        $data = $this->database->connect()->prepare("INSERT INTO ".$query." VALUES ( ".$place_holders." )");
        $data->execute($params);

        return $data;
    }

    public function patch($params, $id, $table)
    {
        foreach ($params as $key => $param) {
            $values[] = $key . '=:' . $key;
        }
        $values = implode(',', $values);

        $data = $this->database->connect()->prepare("UPDATE ".$table." SET " . $values . " WHERE ".$table.".`id` = ".$id);
        $data->execute($params);
    }

    public function delete($id, $table)
    {
        $data = $this->database->connect()->prepare("DELETE FROM `".$table."` WHERE id = ?");
        $data->execute([$id]);

        if ($data->rowCount() < 1) {
            return false;
        }
        return true;
    }
}
