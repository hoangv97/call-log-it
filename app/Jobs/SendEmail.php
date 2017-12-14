<?php

namespace App\Jobs;

use App\Mail\NotifyNewTicket;
use App\Mail\NotifyUpdatedTicket;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $id)
    {
        if($type == 1) //new ticket
            $result = $this->sendNotifyMailForNewTicket($id);
        else if($type == 2) //update ticket
            $result = $this->sendNotifyMailForUpdatedTicket($id);

        if($result)
            \Log::debug("sent email for ticket $id");
        else
            \Log::debug("error when sending email for ticket $id");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }

    //Send mail by id of the new ticket
    protected function sendNotifyMailForNewTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        \Mail::to($ticket->assignee)
            ->send(new NotifyNewTicket($ticket));

        return true;
    }

    //Send email by id of updated ticket
    protected function sendNotifyMailForUpdatedTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        \Mail::to($ticket->assignee)
            ->send(new NotifyUpdatedTicket($ticket));

        return true;
    }
}
