<?php

namespace App\Mail;

use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyNewTicket extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $ticket, $receiver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, Employee $receiver)
    {
        $this->ticket= $ticket;
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        return $this->view('mail.new-ticket')
            ->subject(config('mail.subject'))
            ->with([
                'ticket' => $this->ticket,
                'receiver' => $this->receiver,
                'signature' => config('mail.signature')
            ]);
    }
}
