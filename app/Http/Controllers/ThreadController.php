<?php

namespace App\Http\Controllers;

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

//        //unread all
        $ticket->unreaders()->updateExistingPivot(Auth::id(), ['status' => 0]);

        //rating + close ticket
        if($request->type == 1) {
            $ticket->status = 5;
            $ticket->closed_at = now();
            $ticket->rating = $request->rating;
            $ticket->save();

            $rating = ($request->rating == 1 ? 'Hài lòng' : 'Không hài lòng');
            $comment = $request->input('content');

            $thread->note = "Close request IT:<br/>Đánh giá: $rating.<br/>Bình luận: $comment";
        }

        $thread->save();
    }

    /*
     * API: json
     * Cap nhat thread o phan comment
     */
    public function getThreads(Request $request) {
        $threads = Thread::where('ticket_id', '=', $request->id)->get();

//        dd($threads);
        $result = [];

        foreach ($threads as $thread) {
            $employee = Employee::find($thread->employee_id);
            $result[] = [
                'id' => $request->id,
                'creator' => [
                    'name' => $employee->name,
                    'avatar_url' => route('home').'/'.(!is_null($employee->avatar_url) ? $employee->avatar_url : 'img/default_user.png')
                ],
                'content' => is_null($thread->note) ? $thread->content : $thread->note,
                'created_at' => $thread->created_at->format('Y-m-d H:i:s')
            ];
        }
//        dd($result);
        return response()->json($result);
    }

}
