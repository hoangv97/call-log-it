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
                $employees = collect(Employee::all())->random(rand(1, 5));
                foreach ($employees as $employee) {
                    //prevent duplicate
                    if($ticket->assignee->id != $employee->id && $ticket->creator->id != $employee->id)
                        $ticket->relaters()->attach($employee);
                }
            }
        }
    }
}
