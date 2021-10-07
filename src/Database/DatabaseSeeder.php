<?php

namespace App\Database;

use App\Models\GroupsModel;
use App\Models\InternsModel;
use App\Models\MentorsModel;
use Faker\Factory;

class DatabaseSeeder
{
    private $db;
    private $faker;
    private $groups;
    private $mentors;
    private $interns;

    /**
     * DatabaseSeeder constructor
     */
    public function __construct()
    {
        $this->groups = new GroupsModel();
        $this->mentors = new MentorsModel();
        $this->interns = new InternsModel();

        $this->db = new Connection();
        $this->db = $this->db->connect();

        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    public function Seed() : void
    {
        $this->TruncateBeforeSeeding();
        $this->GroupsSeed();
        $this->MentorsSeed();
        $this->InternsSeed();

        echo 'Database seeding successfully finished..';
    }

    /**
     * @return void
     */
    private function TruncateBeforeSeeding() : void
    {
        // Truncate database table before seeding
        $tables = ['groups', 'mentors', 'interns'];
        echo 'Truncating tables before seeding..'.PHP_EOL;

        foreach($tables as $table){
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE `'.$table.'`; SET FOREIGN_KEY_CHECKS = 1;');
        }

        echo 'Truncating done..'.PHP_EOL;
    }

    /**
     * @return void
     */
    private function GroupsSeed() : void
    {
        // Populating groups rows
        echo 'Seeding groups..'.PHP_EOL;
        $groups = ['Cacak BE', 'Nis BE', 'Beograd BE', 'Kragujevac BE'];
        for($i=0;$i < 4;$i++){
            $this->groups->createGroup($groups[$i]);
        }
    }

    /**
     * @return void
     */
    private function MentorsSeed() : void
    {
        // Populating mentors rows
        echo 'Seeding mentors..'.PHP_EOL;
        for($i=0;$i < 4;$i++){
            $this->mentors->createMentor($this->faker->name(), 1);
            $this->mentors->createMentor($this->faker->name(), 2);
            $this->mentors->createMentor($this->faker->name(), 3);
            $this->mentors->createMentor($this->faker->name(), 4);
        }
    }

    private function InternsSeed() : void
    {
        // Populating interns rows
        echo 'Seeding interns..'.PHP_EOL;
        for($i=0;$i < 10; $i++){
            $this->interns->createIntern(['group_id' => 1, 'full_name' => $this->faker->name(), 'city' => $this->faker->city()]);
            $this->interns->createIntern(['group_id' => 2, 'full_name' => $this->faker->name(), 'city' => $this->faker->city()]);
            $this->interns->createIntern(['group_id' => 3, 'full_name' => $this->faker->name(), 'city' => $this->faker->city()]);
            $this->interns->createIntern(['group_id' => 4, 'full_name' => $this->faker->name(), 'city' => $this->faker->city()]);
        }
    }
}

