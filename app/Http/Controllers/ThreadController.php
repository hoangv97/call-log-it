<?php

namespace App\Http\Controllers;

use App\Facade\Constant;
use App\Facade\TicketParser;
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
     */
    public function store(Request $request) {
        $thread = new Thread;

        $thread->content = $request->input('content');
        $thread->type = $request->type;
        $thread->ticket_id = $request->ticket_id;
        $thread->employee_id = Auth::id();

        $ticket = Ticket::findOrFail($request->ticket_id);

        //unread all except the employee commented
        foreach ($ticket->unreaders as $unreader) {
            $ticket->unreaders()->updateExistingPivot($unreader->id, ['status' => 0]);
        }
        $ticket->unreaders()->updateExistingPivot(Auth::id(), ['status' => 1]);

        //rating + close ticket
        if($request->type == Constant::COMMENT_RATING) {
            $ticket->status = $request->status; //closed or cancelled
            $ticket->closed_at = now();
            $ticket->rating = $request->rating;
            $ticket->save();

            $rating = ($request->rating == 1 ? 'Hài lòng' : 'Không hài lòng');
            $comment = $request->input('content');

            $thread->note = TicketParser::getStatus($ticket->status, 0)." request IT:<br/>Đánh giá: $rating.<br/>Bình luận: $comment";
        }

        $thread->save();
    }

    /*
     * API: json
     * Cap nhat thread o phan comment
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
