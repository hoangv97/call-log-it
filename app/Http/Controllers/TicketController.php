<?php

namespace App\Http\Controllers;

use App\Facade\TicketParser;
use App\Facade\Constant;
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
            $type = Constant::MENU_CREATED_TICKETS;
            $status = Constant::STATUS_ALL;
        }
        $sidebar = $this->renderSidebarMenu();
        return view('request.index', compact('sidebar', 'type', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebar = $this->renderSidebarMenu();

        return view('request.create', compact('sidebar'));
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
                // update read table for all related employees
                $ticket->unreaders()->attach($employee->id);
            }
        }
        $ticket->unreaders()->syncWithoutDetaching([
            Auth::id() => ['status' => 1], //creator
            $ticket->assignee->id
        ]);

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
        $slug = $ticket->slug;

        return redirect()->route('request.edit_with_slug', $slug);
    }

    public function editWithSlug($slug) {
        $ticket = Ticket::findBySlugOrFail($slug);

        $sidebar = $this->renderSidebarMenu();
        return view('request.edit', compact('sidebar', 'ticket'));
    }

    /*
     * get unread number of tickets by type and status
     * loc tickets theo type, status
     * -> voi moi ticket, tim nhung nguoi chua doc de kiem tra id voi nguoi dung
     */
    public function countUnreadTickets(Request $request) {
        $items = $request->items;
        $result = [];
        foreach ($items as $item) {
            $type = $item['type'];
            $status = $item['status'];

            $tickets = $this->filterTickets($type, $status);
            $count = 0;
            foreach ($tickets as $ticket) {
                $count += $ticket->unreaders->contains('id', Auth::id()) ? 1 : 0;
            }
            $item['count'] = $count;
            $result[] = $item;
        }
        return response()->json($result);
    }

    /*
     * update read ticket for current user
     */
    public function updateReadTicket(Request $request) {
        $ticketId = $request->t;
        $ticket = Ticket::findOrFail($ticketId);

        $ticket->unreaders()->updateExistingPivot(Auth::id(), ['status' => 1]);
    }

    /*
     * filter tickets by type and status
     */
    public function filterTickets($type, $status) {
        $employee = Auth::user();
        switch ($type) {
            case Constant::MENU_CREATED_TICKETS:
                $tickets = $employee->getCreatedTicketsByStatus($status);
                break;
            case Constant::MENU_RELATED_TICKETS:
                $tickets = $employee->getRelatedTicketsByStatus($status);
                break;
            case Constant::MENU_ASSIGNED_TICKETS:
                $tickets = $employee->getAssignedTicketsByStatus($status);
                break;
            case Constant::MENU_TEAM_TICKETS:
                $tickets = $employee->team->getTicketsByStatus($status);
                break;
            case Constant::MENU_COMPANY_TICKETS:
                $tickets = TicketParser::getTicketsByStatus(Ticket::all(), $status);
                break;
            default:
                $tickets = null;
                break;
        }
        return $tickets;
    }

    /*
     * get buttons in edit view
     */
    public function getEditButtons($id) {
        $ticket = Ticket::findOrFail($id);

        //Cac trang thai tuong ung co the thuc hien
        $buttons = [];
        if($ticket->creator->id == Auth::id()) { //Nguoi tao
            $buttons = [
                Constant::STATUS_NEW => [Constant::STATUS_CANCELLED],
                Constant::STATUS_INPROGRESS => [Constant::STATUS_CANCELLED],
                Constant::STATUS_RESOLVED => [
                    Constant::STATUS_FEEDBACK,
                    Constant::STATUS_CLOSED,
                    Constant::STATUS_CANCELLED
                ],
                Constant::STATUS_FEEDBACK => [
                    Constant::STATUS_CLOSED,
                    Constant::STATUS_CANCELLED
                ]
            ];
        } else if($ticket->assignee->id == Auth::id()) { //Nguoi thuc hien
            $buttons = [
                Constant::STATUS_NEW => [Constant::STATUS_INPROGRESS],
                Constant::STATUS_INPROGRESS => [Constant::STATUS_RESOLVED],
                Constant::STATUS_FEEDBACK => [Constant::STATUS_INPROGRESS]
            ];
        } else if(Auth::user()->hasPermissions(Constant::PERMISSIONS_COMPANY)) { //Nguoi co quyen toan cong ty
            $buttons = [
                Constant::STATUS_NEW => [
                    Constant::STATUS_INPROGRESS,
                    Constant::STATUS_CANCELLED
                ],
                Constant::STATUS_INPROGRESS => [
                    Constant::STATUS_RESOLVED,
                    Constant::STATUS_CANCELLED
                ],
                Constant::STATUS_RESOLVED => [
                    Constant::STATUS_FEEDBACK,
                    Constant::STATUS_CLOSED,
                    Constant::STATUS_CANCELLED
                ],
                Constant::STATUS_FEEDBACK => [
                    Constant::STATUS_INPROGRESS,
                    Constant::STATUS_CLOSED,
                    Constant::STATUS_CANCELLED
                ]
            ];
        } else if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM)) { //Nguoi co quyen team
            $buttons = [
                Constant::STATUS_NEW => [Constant::STATUS_INPROGRESS],
                Constant::STATUS_INPROGRESS => [Constant::STATUS_RESOLVED],
                Constant::STATUS_RESOLVED => [Constant::STATUS_FEEDBACK],
                Constant::STATUS_FEEDBACK => [Constant::STATUS_INPROGRESS]
            ];
        }

        $html = view('partials.edit-buttons', compact('ticket', 'buttons'))->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
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
     * Return tickets datatables API
     */
    private function getDatatablesData($tickets) {
        return DataTables::of($tickets)
            ->addIndexColumn()
            ->editColumn('subject', function ($ticket) {
                return "<a href='" . route('request.edit_with_slug', ['slug' => $ticket->slug]) . "' data-type='subject' data-id='$ticket->id'>$ticket->subject</a>";
            })
            ->editColumn('priority', function ($ticket) {
                return TicketParser::getPriority($ticket->priority);
            })
            ->editColumn('created_by', function ($ticket) {
                return $ticket->creator->name;
            })
            ->editColumn('assigned_to', function ($ticket) {
                return $ticket->assignee->name;
            })
            ->editColumn('team', function ($ticket) {
                return TicketParser::getTeamName($ticket->team);
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

    /*
     * render sidebar by permissions
     */
    public function renderSidebarMenu() {
        $subMenus = [
            [
                'title' => 'All',
                'status' => Constant::STATUS_ALL,
                'badge' => 'success',
                'icon' => 'inbox'
            ],
            [
                'title' => 'New',
                'status' => Constant::STATUS_NEW,
                'badge' => 'warning',
                'icon' => 'envelope-o'
            ],
            [
                'title' => 'Inprogress',
                'status' => Constant::STATUS_INPROGRESS,
                'badge' => 'success',
                'icon' => 'hourglass-half'
            ],
            [
                'title' => 'Resolved',
                'status' => Constant::STATUS_RESOLVED,
                'badge' => 'success',
                'icon' => 'registered'
            ],
            [
                'title' => 'Feedback',
                'status' => Constant::STATUS_FEEDBACK,
                'badge' => 'success',
                'icon' => 'reply-all'
            ],
            [
                'title' => 'Closed',
                'status' => Constant::STATUS_CLOSED,
                'badge' => 'danger',
                'icon' => 'minus-circle'
            ],
            [
                'title' => 'Out Of Date',
                'status' => Constant::STATUS_OUT_OF_DATE,
                'badge' => 'danger',
                'icon' => 'calendar-times-o'
            ],
        ];

        $menus = [
            [
                'title' => 'Việc tôi yêu cầu',
                'subMenuIndices' => [0, 1, 2, 3, 6],
                'icon' => 'user',
                'caption' => 'Danh sách công việc yêu cầu',
                'type' => Constant::MENU_CREATED_TICKETS
            ],
            [
                'title' => 'Công việc liên quan',
                'subMenuIndices' => [0, 1, 2, 3, 6],
                'icon' => 'list',
                'caption' => 'Danh sách công việc liên quan',
                'type' => Constant::MENU_RELATED_TICKETS
            ],
            [
                'title' => 'Việc tôi được giao',
                'subMenuIndices' => [0, 1, 2, 4, 6],
                'icon' => 'th-list',
                'caption' => 'Danh sách công việc được giao',
                'type' => Constant::MENU_ASSIGNED_TICKETS
            ],
            [
                'title' => 'Công việc của team',
                'subMenuIndices' => [0, 1, 2, 4, 5, 6],
                'icon' => 'users',
                'caption' => 'Danh sách công việc của team',
                'type' => Constant::MENU_TEAM_TICKETS
            ],
            [
                'title' => 'Công việc của bộ phận IT',
                'subMenuIndices' => [0, 1, 2, 4, 5, 6],
                'icon' => 'users',
                'caption' => 'Danh sách công việc của bộ phận IT',
                'type' => Constant::MENU_COMPANY_TICKETS
            ]
        ];

        $userMenus = [ 0, 1 ]; //cong viec yeu cau + cong viec lien quan
        if(Auth::user()->hasPermissions(Constant::PERMISSIONS_MANAGE_TICKET)) //cong viec duoc giao
            $userMenus[] = 2;
        if(Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM)) //cong viec cua team
            $userMenus[] = 3;
        if(Auth::user()->hasPermissions(Constant::PERMISSIONS_COMPANY)) //cong viec cua bo phan it
            $userMenus[] = 4;

        $sidebar = '';
        foreach ($userMenus as $menuIndex) {
            $sidebar .= view('partials.sidebar-menu', ['menu' => $menus[$menuIndex], 'subMenus' => $subMenus])->render();
        }
        return $sidebar;
    }

}
