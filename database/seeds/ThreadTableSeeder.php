<?php

use App\Facade\Constant;
use App\Facade\TicketParser;
use App\Models\Ticket;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class ThreadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $tickets = Ticket::where('status', Constant::STATUS_CLOSED)->orWhere('status', Constant::STATUS_CANCELLED)->get();
        foreach ($tickets as $ticket) {
            $thread = new Thread;

            $thread->type = Constant::COMMENT_RATING;
            $thread->ticket_id = $ticket->id;
            $thread->employee_id = $ticket->creator->id;

            $content = $faker->realText(500);

            $thread->content = $content;
            $thread->note = TicketParser::getThreadNote($ticket->status, rand(0, 1), $content);

            $thread->save();
        }
    }
}
