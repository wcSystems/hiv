<?php

use Illuminate\Database\Seeder;

class BlocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blocks')->insert([
            'name' => "Sistemas",
        ]);
        DB::table('blocks')->insert([
            'name' => "Recursos Humanos",
        ]);
        DB::table('blocks')->insert([
            'name' => "Administracion",
        ]);
        DB::table('blocks')->insert([
            'name' => "Servidores",
        ]);
        DB::table('blocks')->insert([
            'name' => "Seguridad",
        ]);
        DB::table('blocks')->insert([
            'name' => "Mantenimiento",
        ]);
        DB::table('blocks')->insert([
            'name' => "Alimentos y Bebidas",
        ]);
    }
}
