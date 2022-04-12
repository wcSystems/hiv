<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            'name' => "Administrador",
        ]);
        DB::table('levels')->insert([
            'name' => "Supervisor",
        ]);
        DB::table('levels')->insert([
            'name' => "Diler",
        ]);
    }
}
