<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => "Sistema",
        ]);
        DB::table('departments')->insert([
            'name' => "Operaciones",
        ]);
        DB::table('departments')->insert([
            'name' => "Caja",
        ]);
        DB::table('departments')->insert([
            'name' => "Boveda",
        ]);
        DB::table('departments')->insert([
            'name' => "Diler",
        ]);
        DB::table('departments')->insert([
            'name' => "Monitores",
        ]);
    }
}
