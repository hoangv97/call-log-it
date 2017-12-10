<?php

namespace App\Http\Controllers;

use App\Facade\TicketParser;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Facade\Constant;
use Illuminate\Support\Facades\DB;

class TicketApiController extends Controller
{

    /*
     * update in edit view
     * update each field per request
     */
    public function update(Request $request) {
        $id = $request->id;
        $ticket = Ticket::findOrFail($id);

        $field = $request->field;
        $value = $request->value;
        if($ticket[$field] == $value) //Khong cap nhat neu van la gia tri cu
            return;

        //if change its team, change assignee to the new team's leader
        if($field == 'team_id') {
            $ticket->assignee()->associate(Team::find($value)->leader()->id);
        }
        //update time stamps if column is status
        else if($field == 'status') {
            switch ($value) {
                case Constant::STATUS_RESOLVED:
                    $ticket->resolved_at = now();
                    break;
                case Constant::STATUS_CLOSED:
                    $ticket->closed_at = now();
                    break;
                case Constant::STATUS_CANCELLED:
                    $ticket->deleted_at = now();
                    break;
                default:
                    $ticket->updated_at = now();
                    break;
            }
        }
        //update thread (comments) if field is priority or deadline
        else if($field == 'priority' || $field == 'deadline') {
            $thread = new Thread;

            $thread->content = $request->reason;
            if($field == 'priority') {
                $thread->type = Constant::COMMENT_PRIORITY;
                $field_name = "mức độ ưu tiên";
                $oldValue = TicketParser::getPriority($ticket[$field], false);
                $newValue = TicketParser::getPriority($value, false);
            } else {
                $thread->type = Constant::COMMENT_DEADLINE;
                $field_name = "deadline";
                $oldValue = $ticket[$field];
                $newValue = $value;
            }
            $thread->ticket_id = $ticket->id;
            $thread->employee_id = $request->creator_id;

            $thread->note = "Thay đổi $field_name: $oldValue => $newValue<br/>Lý do: $request->reason";

            $thread->save();
        }

        //update ticket info
        //change related employees
        //update unread for all users in each ticket
        switch ($field) {
            case 'relaters':
                //Remove all relation of old relaters to update again
                $ticket->relaters()->detach();
                //Remove all read of the ticket
                DB::table('ticket_reads')->where('ticket_id', $ticket->id)->delete();

                $ticket->unreaders()->attach([
                    $ticket->creator->id => ['status' => 1],
                    $ticket->assignee->id => ['status' => 0]
                ]);
                $relaters = explode(',', $value);
                foreach ($relaters as $relater) {
                    $employee = Employee::where('name', '=', $relater)->firstOrFail();
                    $ticket->relaters()->attach($employee->id);
                    $ticket->unreaders()->attach($employee->id);
                }
                break;
            case 'assignee':
                $ticket->unreaders()->detach($ticket->assignee); //Remove unread of old assignee

                $employee = Employee::where('name', '=', $value)->firstOrFail();
                $ticket->assignee()->associate($employee->id);

                if($ticket->unreaders->contains('id', $employee->id)) {
                    $ticket->unreaders()->updateExistingPivot($employee->id, ['status' => 0]);
                } else {
                    $ticket->unreaders()->attach($employee->id); //update new unread ticket
                }
                break;
            default:
                $ticket[$field] = $value; //Set all field to new value
                break;
        }
        $ticket->save();
    }

    /*
     * API: json
     * return info of each ticket to update in edit view
     */
    public function getInfo(Request $request) {
        $id = $request->input('id');
        $ticket = Ticket::findOrFail($id);

        return response()->json([
            'info' => [
                'team' => TicketParser::getTeamName($ticket->team),
                'priority' => TicketParser::getPriority($ticket->priority),
                'deadline' => $ticket->deadline->format(Constant::DATETIME_FORMAT),
                'assignee' => is_null($ticket->assignee) ? null : TicketParser::getEmployeeHtml($ticket->assignee->name),
                'status' => TicketParser::getStatus($ticket->status),
                'relaters' => implode('', collect($ticket->relaters)->map(function ($relater) {
                    return TicketParser::getEmployeeHtml($relater->name);
                })->all()),
            ],
            'relaters' => collect($ticket->relaters)->map(function ($relater) {
                return $relater->name;
            })->all()
        ]);
    }
    
}
