<?php

namespace App\Database;

use App\Database\Connection;
use PDO;

class DatabaseQueries extends Connection
{

    public function processQuery($query){
        $result = parent::connect()->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}