<?php

namespace App\Mail;

use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUpdatedTicket extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket= $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.updated-ticket')
            ->subject(config('mail.subject'))
            ->with([
                'ticket' => $this->ticket
            ]);
    }
}
