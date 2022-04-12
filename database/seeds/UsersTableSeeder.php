<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Aca creamos el usuario principal */

        DB::table('users')->insert([
            'name' => "Willinthon Carriedo",
            'email' => 'willinthon',
            'level_id' => 1,
            'department_id' => 1,
            'password' => bcrypt('12345678'),
        ]);
    }
}
