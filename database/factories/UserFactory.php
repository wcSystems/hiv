<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/* Aca creamos unos usuarios aleatorios con factory */

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('12345678'),
        'remember_token' => Str::random(10),
        'celular' => $faker->numberBetween($min = 1000000000, $max = 9999999999),
        'cedula' => $faker->unique()->numberBetween($min = 1000000, $max = 99999999999),
        'nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
