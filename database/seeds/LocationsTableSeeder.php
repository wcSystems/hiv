<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'name' => "Valencia",
        ]);
        DB::table('locations')->insert([
            'name' => "Margarita",
        ]);
        DB::table('locations')->insert([
            'name' => "Puerto La Cruz",
        ]);
        DB::table('locations')->insert([
            'name' => "Caracas",
        ]);
    }
}
