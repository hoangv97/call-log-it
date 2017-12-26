<?php

namespace App\Http\Controllers;

use App\Facade\TicketParser;
use App\Facade\SendEmail;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Thread;
use App\Models\TicketRead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Facade\Constant;

class TicketApiController extends Controller
{

    /*
     * update in edit view
     * update each field per request
     *
     * query keys: field, value, t_id, c_id, reason
     */
    public function update(Request $request) {
        $ticket = Ticket::findOrFail($request->t_id);

        $field = $request->field;
        $value = $request->value;
        if(!is_null($ticket[$field]) && $ticket[$field] == $value) //Khong cap nhat neu van la gia tri cu
            return $this->getErrors('Chưa thực hiện thay đổi nào.');

        //if change its team, change assignee to the new team's leader
        if($field == 'team_id') {
            $ticket->assignee()->associate(Team::find($value)->leader()->id);
        }
        //column is status
        else if($field == 'status') {
            if($value == Constant::STATUS_RESOLVED) {
                $ticket->resolved_at = now();
            } else if($value == Constant::STATUS_CLOSED || $value == Constant::STATUS_CANCELLED) {
                return $this->getErrors('Không thể thay đổi trạng thái của yêu cầu');
            }
        }
        //update thread (comments) if field is priority or deadline
        else if($field == 'priority' || $field == 'deadline') {
            if($field == 'deadline') {
                if(is_null($value)) //truong deadline trong
                    return $this->getErrors('Vui lòng nhập deadline.');
                if(Carbon::parse($value) < now()) //deadline < gio hien tai
                    return $this->getErrors('Deadline phải là một ngày sau ' . now() . '.');
            }
            if(is_null($request->reason)) {
                return $this->getErrors('Chưa điền lý do thay đổi.');
            }
            $thread = new Thread;

            $thread->content = $request->reason;
            if($field == 'priority') {
                $thread->type = Constant::COMMENT_PRIORITY;
                $field_name = "mức độ ưu tiên";
                $oldValue = TicketParser::getPriority($ticket[$field], false);
                $newValue = TicketParser::getPriority($value, false);
            } else { //deadline
                $thread->type = Constant::COMMENT_DEADLINE;
                $field_name = $field;
                $oldValue = $ticket[$field]->format(Constant::DATETIME_FORMAT);
                $newValue = Carbon::parse($value)->format(Constant::DATETIME_FORMAT);
            }
            $thread->ticket_id = $ticket->id;
            $thread->employee_id = $request->c_id;

            $thread->note = "Thay đổi $field_name: $oldValue => $newValue<br/>Lý do: $request->reason";

            $thread->save();
        }

        //update ticket info
        //change related employees
        //update unread for all users in each ticket
        switch ($field) {
            case 'relaters[]':
                //Remove all relation of old relaters to update again
                $ticket->relaters()->detach();
                //Remove all read of the ticket
                TicketRead::where('ticket_id', $ticket->id)->delete();

                $ticket->unreaders()->attach([
                    $ticket->creator->id => ['status' => 1],
                    $ticket->assignee->id => ['status' => 0]
                ]);
                $relaters = $value;
                if(is_null($relaters)) { //remove all relaters
                    break;
                }
                foreach ($relaters as $relater) {
                    $employee = Employee::findOrFail($relater);

                    $ticket->relaters()->attach($employee->id);

                    //prevent duplicate in ticket_read table
                    if($employee->id != $ticket->creator->id && $employee->id != $ticket->assignee->id)
                        $ticket->unreaders()->attach($employee->id);
                }
                break;
            case 'assignee':
                if(is_null($value))
                    return $this->getErrors('Chưa chọn nhân viên');

                //Remove unread of old assignee
                TicketRead::where('ticket_id', $ticket->id)->where('employee_id', $ticket->assignee->id)->delete();

                $employee = Employee::findOrFail($value);
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

        //Send email to notify update for the assignee of the ticket
        $ticket = Ticket::findOrFail($request->t_id);
        SendEmail::sendMailsForTicket(Constant::MAIL_UPDATED_TICKET, $ticket, $request->c_id);

        return response()->json([
            'success' => true,
            'detail' => 'Thay đổi thành công'
        ]);
    }

    /*
     * API: json
     * return info of each ticket to update in edit view
     *
     * query keys: id
     */
    public function getInfo(Request $request) {
        $id = $request->id;
        $ticket = Ticket::findOrFail($id);

        return response()->json([
            'info' => [
                'team' => TicketParser::getTeamName($ticket->team),
                'priority' => TicketParser::getPriority($ticket->priority),
                'deadline' => $ticket->deadline->format(Constant::DATETIME_FORMAT),
                'assignee' => is_null($ticket->assignee) ? null : TicketParser::getEmployeeLabel($ticket->assignee),
                'status' => TicketParser::getStatus($ticket->status),
                'relaters' => implode('<div style="height: 10px;"></div>', collect($ticket->relaters)->map(function ($relater) {
                    return TicketParser::getEmployeeLabel($relater);
                })->all()),
            ],
            'relaters' => collect($ticket->relaters)->map(function ($relater) {
                return [
                    'id' => $relater->id,
                    'name' => $relater->name
                ];
            })->all()
        ]);
    }

    /*
     * Return error response
     */
    protected function getErrors($detail) {
        return response()->json([
            'success' => false,
            'detail' => $detail
        ]);
    }
}
