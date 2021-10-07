<?php

namespace App\Database;

use PDO;

class Connection
{
    private $config;

    /**
     * Database connection file
     */
    public function __construct()
    {
        $config = parse_ini_file("config.ini");
        $this->config = $config;
        $this->createDatabase();
    }

    /**
     * @return PDO
     */
    public function connect()
    {
        return new PDO("mysql:host=".$this->config['servername'].";dbname=".$this->config['database'], $this->config['username'], $this->config['password']);
    }

    private function createDatabase()
    {
        $db = new PDO("mysql:host=".$this->config['servername'],$this->config['username'], $this->config['password']);
        $db->exec("CREATE DATABASE IF NOT EXISTS ".$this->config['database']);
    }
}