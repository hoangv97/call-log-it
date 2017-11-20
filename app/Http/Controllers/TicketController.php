<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
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
    public function store(TicketRequest $request)
    {
//        dd($request);
        $ticket = new Ticket;

        $ticket->subject = $request->subject;
        $ticket->priority = $request->priority;
        $ticket->deadline = $request->deadline.':00';
        $ticket->team_id = $request->team;
        $ticket->content = $request->input('content');

        $image = $request->image;
        $imgType = str_replace('image/', '', $image->getMimeType());
        $imgName = str_random(15).'.'.$imgType;
        $imgPath = 'upload/';
        $image->move($imgPath, $imgName);
        $ticket->image_url = $imgPath.$imgName;

        $ticket->created_by = Auth::user()->id;

        $ticket->save();

        $relaters = explode(',', $request->relaters);
        foreach ($relaters as $relater) {
            $info = explode(' (', $relater);
            $name = $info[0];
            $email = str_replace(')', '', $info[1]);
            $employee = Employee::where('name', '=', $name)->where('email', '=', $email)->firstOrFail();

            $ticket->relaters()->attach($employee->id);
        }

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

}
