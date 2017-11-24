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

    $status = rand(1, 6);
    $creator = collect(Employee::all())->random();
    do {
        $assignee = collect(Employee::whereNotNull('role_team_id')->get())->random();
    }while($assignee == $creator); //prevent duplicate

    return [
        'subject' => $faker->text(80),
        'content' => $faker->text(500),
        'created_by' => $creator,
        'status' => $status,
        'priority' => rand(1, 4),
        'deadline' => $faker->dateTimeBetween('-1 year', '+4 months'), //test out of date deadline
        'assigned_to' => $assignee,
        'rating' => $status == 5 ? rand(0, 1) : null, //if closed, there must be rating from creator
        'team_id' => rand(1, 2),
        'resolved_at' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'closed_at' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'deleted_at' => $faker->dateTimeThisYear('now', date_default_timezone_get())
    ];
});
