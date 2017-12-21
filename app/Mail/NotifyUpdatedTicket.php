<?php

namespace App\Mail;

use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUpdatedTicket extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $ticket, $changer, $receiver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, Employee $changer, Employee $receiver)
    {
        $this->ticket= $ticket;
        $this->changer = $changer;
        $this->receiver = $receiver;
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
                'ticket' => $this->ticket,
                'changer' => $this->changer,
                'receiver' => $this->receiver,
                'signature' => config('mail.signature')
            ]);
    }
}
