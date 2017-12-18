<?php

use App\Facade\Constant;
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

    $status = rand(Constant::STATUS_NEW, Constant::STATUS_CANCELLED);
    $creator = collect(Employee::all())->random();
    do {
        $assignee = collect(Employee::whereNotNull('role_team_id')->get())->random();
    } while($assignee->id == $creator->id); //prevent duplicate

    return [
        'subject' => $faker->realText(75),
        'content' => $faker->realText(500),
        'created_by' => $creator->id,
        'status' => $status,
        'priority' => rand(1, 4),
        'deadline' => $faker->dateTimeBetween('-1 year', '+4 months'), //test out of date deadline
        'assigned_to' => $assignee->id,
        'rating' => $status == Constant::STATUS_CLOSED ? rand(0, 1) : null, //if closed, there must be rating from creator
        'team_id' => $assignee->team->id,
        'resolved_at' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'closed_at' => $faker->dateTimeThisYear('now', date_default_timezone_get()),
        'deleted_at' => $faker->dateTimeThisYear('now', date_default_timezone_get())
    ];
});
