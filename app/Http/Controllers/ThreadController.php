<?php

namespace App\Http\Controllers;

use App\Facade\Constant;
use App\Facade\TicketParser;
use App\Facade\SendEmail;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{

    /*
     * update /create new thread
     * rating ticket
     * set unread ticket for all users
     *
     * query keys: type, t_id, content, rating, status, _token
     */
    public function store(Request $request) {
        $thread = new Thread;

        $thread->content = $request->input('content');
        $thread->type = $request->type;
        $thread->ticket_id = $request->t_id;
        $thread->employee_id = Auth::id();

        $ticket = Ticket::findOrFail($request->t_id);

        //unread all except the employee commented
        foreach ($ticket->unreaders as $unreader) {
            $ticket->unreaders()->updateExistingPivot($unreader->id, ['status' => 0]);
        }
        $ticket->unreaders()->updateExistingPivot(Auth::id(), ['status' => 1]);

        //rating + close ticket
        if($request->type == Constant::COMMENT_RATING) {
            $comment = $request->input('content');

            if(is_null($comment)) {
                return response()->json([
                    'success' => false,
                    'detail' => 'Chưa điền bình luận.'
                ]);
            }

            $ticket->status = $request->status; //closed or cancelled
            $ticket->closed_at = now();
            $ticket->rating = $request->rating;
            $ticket->save();

            $thread->note = TicketParser::getThreadNote($ticket->status, $request->rating, $comment);

            $thread->save();

            //Send email to notify update for the assignee of the ticket
            $ticket = Ticket::findOrFail($request->t_id);
            SendEmail::sendMailsForTicket(Constant::MAIL_UPDATED_TICKET, $ticket, Auth::id());

            return response()->json([
                'success' => true,
                'detail' => 'Thay đổi thành công'
            ]);
        }

        $thread->save();

        return '';
    }

    /*
     * API: json
     * Cap nhat thread o phan comment
     * query keys: id
     */
    public function getComments(Request $request) {
        $ticket = Ticket::findOrFail($request->id);
        $comments = $ticket->comments;

        $html = '';
        foreach ($comments as $comment) {
            $html .= view('partials.edit-comment', compact('comment'))->render();
        }
        return response()->json([
            'html' => $html
        ]);
    }

}
