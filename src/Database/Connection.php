<?php

namespace App\Database;

use PDO;

class Connection
{
    private $config;
    private $status_code;

    public function __construct()
    {
        $config = parse_ini_file("config.ini");
        $this->config = $config;
    }

    public function connect(){
        return new PDO("mysql:host=".$this->config['servername'].";dbname=".$this->config['database'], $this->config['username'], $this->config['password']);
    }

}