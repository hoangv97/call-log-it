<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('request.index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return view('request.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    /*
     * Return requests datatable API
     * todo requests keys: request_id, read, id, subject, ...
     */
    private function getDatatablesData($requests) {
        return DataTables::of($requests)
            ->editColumn('id', function ($request) {
                return $request->id;
            })
            ->editColumn('subject', function ($request) {
                return "<a href='" . route('request.edit') . "' target='_blank'>$request->subject</a>";
            })
            ->editColumn('priority', function ($request) {
                return $request->priority;
            })
            ->editColumn('created_by', function ($request) {
                return $request->created_by;
            })
            ->editColumn('assigned_to', function ($request) {
                return $request->assigned_to;
            })
            ->editColumn('team', function ($request) {
                return $request->team;
            })
            ->editColumn('deadline', function ($request) {
                return $request->deadline;
            })
            ->editColumn('status', function ($request) {
                return $request->status;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function test()
    {
        $requests = json_decode(file_get_contents(public_path('test/requests.json')));
//        $requests = array_slice($requests, 0, 10);
        return $this->getDatatablesData($requests);
    }
}
