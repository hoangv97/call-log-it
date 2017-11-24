<?php

namespace App\Http\Controllers;

use App\Facade\TicketParser;
use App\Http\Requests\TicketRequest;
use App\Models\Employee;
use App\Models\Ticket;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * route: home
     * set type and status to return correct data table
     */
    public function index(Request $request)
    {
        if(isset($request->t) && isset($request->s)) {
            $type = $request->t;
            $status = $request->s;
        } else {
            $type = 1;
            $status = 0;
        }
        return view('request.index', compact('type', 'status'));
    }

    /*
     * Get tickets by status
     * type :
     * 1: cong viec toi yeu cau
     * 2: cong viec lien quan
     * 3: cong viec duoc giao
     * 4: cong viec cua team
     * 5: cong viec cua bo phan it
     */
    public function getTickets(Request $request) {
        $type = $request->type;
        $status = $request->status;

        return $this->getDatatablesData($this->filterTickets($type, $status));
    }

    /*
     * get unread number of tickets by type and status
     * loc tickets theo type, status
     * -> voi moi ticket, tim nhung nguoi chua doc de kiem tra id voi nguoi dung
     */
    public function countUnreadTickets(Request $request) {
        $type = $request->type;
        $status = $request->status;

        $tickets = $this->filterTickets($type, $status);
        $count = 0;
        foreach ($tickets as $ticket) {
            $count += $ticket->unreaders->contains('id', Auth::id()) ? 1 : 0;
        }
        return $count;
    }

    /*
     * update read ticket for current user
     */
    public function updateReadTicket(Request $request) {
        $ticketId = $request->t;
        $ticket = Ticket::findOrFail($ticketId);

        $ticket->unreaders()->updateExistingPivot(Auth::id(), ['status' => 1]);

        return 1;
    }

    /*
     * filter tickets by type and status
     */
    public function filterTickets($type, $status) {
        $employee = Auth::user();
        switch ($type) {
            case 1:
                $tickets = $employee->getCreatedTicketsByStatus($status);
                break;
            case 2:
                $tickets = $employee->getRelatedTicketsByStatus($status);
                break;
            case 3:
                $tickets = $employee->getAssignedTicketsByStatus($status);
                break;
            case 4:
                $tickets = $employee->team->getTicketsByStatus($status);
                break;
            case 5:
                $tickets = TicketParser::getTicketsByStatus(Ticket::all(), $status);
                break;
            default:
                $tickets = null;
                break;
        }
        return $tickets;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
//        dd($request);
        $ticket = new Ticket;

        $ticket->subject = $request->subject;
        $ticket->priority = $request->priority;
        $ticket->deadline = $request->deadline;
        $ticket->content = $request->input('content');

        $ticket->team()->associate($request->team);
        $ticket->creator()->associate(Auth::id());

        //Tu dong cap nhat nguoi thuc hien la leader cua team do
        $ticket->assignee()->associate($ticket->team->leader()->id);

        //Tai anh len server
        if(!is_null($request->image)) {
            $image = $request->image;
            $imgType = str_replace('image/', '', $image->getMimeType());
            $imgName = str_random(15) . '.' . $imgType;
            $imgPath = 'upload/';
            $image->move($imgPath, $imgName);
            $ticket->image_url = $imgPath . $imgName;
        }

        $ticket->save();

        //update relaters
        if(!is_null($request->relaters)) {
            $relaters = explode(',', $request->relaters);
            foreach ($relaters as $relater) {
                $employee = Employee::where('name', '=', $relater)->firstOrFail();

                $ticket->relaters()->attach($employee->id);
            }
            // update read table for all related employees
            foreach ($ticket->relaters as $relater) {
                $ticket->unreaders()->attach($relater);
            }
        }
        $ticket->unreaders()->attach($ticket->assignee);
        $ticket->unreaders()->attach($ticket->creator);

        return redirect()->route('request.edit', ['id' => $ticket->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('request.edit', compact('ticket'));
    }

    /*
     * Return tickets datatables API
     */
    private function getDatatablesData($tickets) {
        return DataTables::of($tickets)
            ->addIndexColumn()
            ->editColumn('subject', function ($ticket) {
                return "<a href='" . route('request.edit', ['id' => $ticket->id]) . "' data-type='subject' data-id='$ticket->id'>$ticket->subject</a>";
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
            ->setRowClass(function ($ticket) {
                return $ticket->unreaders->contains('id', Auth::id()) ? 'bold' : '';
            })
            ->escapeColumns([])
            ->make(true);
    }

}
