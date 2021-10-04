<?php

require_once 'vendor/autoload.php';

use App\Http\HttpMethods;

$httpMethod = new HttpMethods();

$faker = Faker\Factory::create();

// Populating groups rows
$groups = ['Cacak BE', 'Nis BE', 'Beograd BE', 'Kragujevac BE'];

for($i=0;$i < 4;$i++){
    $httpMethod->post("`groups` ( `name` )", [$groups[$i]]);
}

// Populating mentors rows
for($i=0;$i < 4;$i++){
    $httpMethod->post("`mentors` (`group_id`, `full_name`)", [1, $faker->name()]);
    $httpMethod->post("`mentors` (`group_id`, `full_name`)", [2, $faker->name()]);
    $httpMethod->post("`mentors` (`group_id`, `full_name`)", [3, $faker->name()]);
    $httpMethod->post("`mentors` (`group_id`, `full_name`)", [4, $faker->name()]);
}

// Populating interns rows
for($i=0;$i < 10; $i++){
    $httpMethod->post("`interns` (`group_id`, `full_name`, `city`)", [1, $faker->name(), $faker->city()]);
    $httpMethod->post("`interns` (`group_id`, `full_name`, `city`)", [2, $faker->name(), $faker->city()]);
    $httpMethod->post("`interns` (`group_id`, `full_name`, `city`)", [3, $faker->name(), $faker->city()]);
    $httpMethod->post("`interns` (`group_id`, `full_name`, `city`)", [4, $faker->name(), $faker->city()]);
}

echo 'Seeding Database is finished..';

