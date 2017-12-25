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
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('test'),
        'remember_token' => str_random(10),

        //is user is in a team, they can only be member or sub-lead
        'role_team_id' => $hasTeam ? (rand(1, 2) == 1 ? rand(1, 2) : rand(4, 5)) : null,
    ];
});

