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

$factory->define(App\Models\Employee::class, function (Faker $faker) {
    static $password;

    $hasTeam = rand(0, 5) > 0;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'team_id' => $hasTeam ? rand(1, 2) : null,
        'role_id' => $hasTeam ? rand(1, 3) : null
    ];
});
