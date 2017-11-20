<?php

namespace App\Http\Controllers;

use App\Facade\TicketParser;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Team;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketApiController extends Controller
{

    public function update(Request $request) {
        dd($request);

        $id = $request->input('id');
        $ticket = Ticket::findOrFail($id);
    }

    public function getInfoTicket(Request $request) {
        $id = $request->input('id');
        $ticket = Ticket::findOrFail($id);

        return response()->json([
            'team' => $ticket->team->name,
            'priority' => TicketParser::getPriority($ticket->priority),
            'deadline' => $ticket->deadline,
            'relaters' => implode('', collect($ticket->relaters)->map(function ($relater) {
                return "<div>$relater->name</div>";
            })->all()),
            'assignee' => $ticket->assignee->name,
            'status' => TicketParser::getStatus($ticket->status)
        ]);
    }
    
    public function getTickets(Request $request) {
        $tickets = Ticket::all();
        return $this->getDatatablesData($tickets);
    }
    
    /*
     * Return tickets datatable API
     */
    private function getDatatablesData($tickets) {
        return DataTables::of($tickets)
            ->editColumn('id', function ($ticket) {
                return $ticket->id;
            })
            ->editColumn('subject', function ($ticket) {
                return "<a href='" . route('request.edit', ['id' => $ticket->id]) . "'>$ticket->subject</a>";
            })
            ->editColumn('priority', function ($ticket) {
                return TicketParser::getPriority($ticket->priority);
            })
            ->editColumn('created_by', function ($ticket) {
                $employee = Employee::findOrFail($ticket->created_by);
                return $employee->name;
            })
            ->editColumn('assigned_to', function ($ticket) {
                $employee = Employee::find($ticket->assigned_to);
                return isset($employee) ? $employee->name : '';
            })
            ->editColumn('team', function ($ticket) {
                $team = Team::findOrFail($ticket->team_id);
                return $team->name;
            })
            ->editColumn('deadline', function ($ticket) {
                return $ticket->deadline;
            })
            ->editColumn('status', function ($ticket) {
                return TicketParser::getStatus($ticket->status);
            })
            ->escapeColumns([])
            ->make(true);
    }
    
}
