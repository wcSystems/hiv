<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\URL;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MachinesTableSeeder::class);
    }
}
