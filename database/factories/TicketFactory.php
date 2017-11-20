<?php

use Faker\Generator as Faker;
use App\Models\Employee;

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

$factory->define(App\Models\Ticket::class, function (Faker $faker) {

    return [
        'subject' => $faker->text(40),
        'content' => $faker->text(200),
        'created_by' => function() {
            return collect(Employee::all())->random();
        },
        'status' => rand(1, 6),
        'priority' => rand(1, 4),
        'deadline' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'assigned_to' => function() {
            return collect(Employee::whereNotNull('team_id')->get())->random();
        },
        'rating' => rand(0, 1),
        'team_id' => rand(1, 2),
        'resolved-at' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'closed-at' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'deleted-at' => $faker->dateTimeThisYear('now', date_default_timezone_get())
    ];
});
