<?php

namespace App\Facade;

use App\Mail\NotifyNewTicket;
use App\Mail\NotifyUpdatedTicket;
use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Support\Facades\Facade;

class SendEmail extends Facade {

    /*
     * send emails to ticket's relaters
     */
    public static function sendMailsForTicket($type, Ticket $ticket, $changerId) {
        $changer = Employee::findOrFail($changerId);
        $receiverIds = $ticket->getMailReceiverIds($changerId);

        foreach ($receiverIds as $receiverId) {
            $receiver = Employee::find($receiverId);
            if(! is_null($receiver)) {
                switch ($type) {
                    case Constant::MAIL_NEW_TICKET:
                        \Mail::to($receiver)->send(new NotifyNewTicket($ticket, $receiver));
                        break;

                    case Constant::MAIL_UPDATED_TICKET:
                        \Mail::to($receiver)->send(new NotifyUpdatedTicket($ticket, $changer, $receiver));
                        break;
                }
            }
        }
    }

}