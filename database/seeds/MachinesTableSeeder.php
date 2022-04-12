<?php

use Illuminate\Database\Seeder;

class MachinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('machines')->insert([
            'name' => "001",
            'location_id' => 1,
        ]);
        DB::table('machines')->insert([
            'name' => "002",
            'location_id' => 1,
        ]);
        DB::table('machines')->insert([
            'name' => "003",
            'location_id' => 1,
        ]);
        DB::table('machines')->insert([
            'name' => "004",
            'location_id' => 1,
        ]);
        DB::table('machines')->insert([
            'name' => "005",
            'location_id' => 1,
        ]);
        DB::table('machines')->insert([
            'name' => "006",
            'location_id' => 1,
        ]);
    }
}
