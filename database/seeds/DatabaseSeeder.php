<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Type;
use App\Block;
use App\Network;
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
        $this->call(UsersTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(BlocksTableSeeder::class);
        $this->call(NetworksTableSeeder::class);
    }
}
