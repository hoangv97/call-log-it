<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Employee;

class TicketRelatersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            if(rand(0, 2) > 0) {
                $employees = collect(Employee::all())->random(rand(1, 4));
                foreach ($employees as $employee) {
                    $ticket->relaters()->attach($employee);
                }
            }
        }
    }
}
