<?php

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

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(RainCheck\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
    ];
});

$factory->state(RainCheck\Models\User::class, 'user', function () {
    return []; // No override
});

$factory->state(RainCheck\Models\User::class, 'admin', function () {
    return ['is_admin' => true];
});

