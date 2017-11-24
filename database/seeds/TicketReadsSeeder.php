<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketReadsSeeder extends Seeder
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
            foreach ($ticket->relaters as $relater) {
                $ticket->unreaders()->attach($relater);
            }
            $ticket->unreaders()->attach($ticket->assignee);
            $ticket->unreaders()->attach($ticket->creator);
        }
    }
}
