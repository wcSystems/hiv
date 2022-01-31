<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name' => "Router",
        ]);
        DB::table('types')->insert([
            'name' => "Smart TV",
        ]);
        DB::table('types')->insert([
            'name' => "Unifi",
        ]);
        DB::table('types')->insert([
            'name' => "Server",
        ]);
        DB::table('types')->insert([
            'name' => "Wifi",
        ]);
        DB::table('types')->insert([
            'name' => "Estacion de trabajo",
        ]);
    }
}
