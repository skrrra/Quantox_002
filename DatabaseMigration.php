<?php

require_once 'vendor/autoload.php';

use App\Database\Connection;
use App\Database\DatabaseSeeder;

$databaseConnection = new Connection();
$databaseSeeder = new DatabaseSeeder();
$db = $databaseConnection->connect();

$config = parse_ini_file("config.ini");

$prompt = readline('Do you wish to migrate and seed database? No will only make migrations. (y/n): ');

try{
    $db->exec("CREATE TABLE IF NOT EXISTS `groups` (
                        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        `name` varchar(50) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

    echo 'Table groups has been created..'.PHP_EOL;

    $db->exec("CREATE TABLE IF NOT EXISTS `mentors` (
                        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        `group_id` int(11),
                        `full_name` varchar(80) NOT NULL,
                        FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE SET NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

    echo 'Table mentors has been created..'.PHP_EOL;

    $db->exec("CREATE TABLE IF NOT EXISTS `interns` (
                        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        `group_id` int(11),
                        `full_name` varchar(80) NOT NULL,
                        `city` varchar(30) NOT NULL,
                        FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE SET NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

    echo 'Table interns has been created..'.PHP_EOL;

    $db->exec("CREATE TABLE IF NOT EXISTS `interns_comments` (
                        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        `intern_id` int(11) NOT NULL,
                        `mentor_id` int(11) NOT NULL,
                        `comment` text NOT NULL,
                        `created_at` datetime DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

    echo 'Table interns_comments has been created..'.PHP_EOL;
    echo 'Database migrating has been successfully completed..'.PHP_EOL;

    if($prompt == "y"){
        $databaseSeeder->Seed();
    }

} catch (PDOException $e){
    die("Error while migrating database, message: " .$e->getMessage());
}