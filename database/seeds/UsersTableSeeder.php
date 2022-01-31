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
            'password' => bcrypt('12345678'),
            'celular' => '4121482348',
            'cedula' => '25047058',
            'nacimiento' => '1996-09-13',
        ]);
    }
}
