<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class Constant extends Facade {

    const DATETIME_FORMAT = 'H:i:s d/m/Y';

    const STATUSES = ['All', "New", "Inprogress", "Resolved", "Feedback", "Closed", "Cancelled", "Out Of Date"];

    const STATUS_ALL        = 0;
    const STATUS_NEW        = 1;
    const STATUS_INPROGRESS = 2;
    const STATUS_RESOLVED   = 3;
    const STATUS_FEEDBACK   = 4;
    const STATUS_CLOSED     = 5;
    const STATUS_CANCELLED  = 6;

    const STATUS_OUT_OF_DATE  = 7;

    const STATUSES_CLOSED = [
        self::STATUS_RESOLVED,
        self::STATUS_CLOSED,
        self::STATUS_CANCELLED
    ];

    const PERMISSION_MANAGE_TICKET_PERSON  = 1;
    const PERMISSION_MANAGE_TICKET_TEAM    = 2;
    const PERMISSION_MANAGE_TICKET_COMPANY = 3;
    const PERMISSION_VIEW_TICKET_TEAM      = 4;
    const PERMISSION_VIEW_TICKET_COMPANY   = 5;

    const PERMISSIONS_MANAGE_TICKET = [
        self::PERMISSION_MANAGE_TICKET_PERSON,
        self::PERMISSION_MANAGE_TICKET_TEAM,
        self::PERMISSION_MANAGE_TICKET_COMPANY
    ];

    const PERMISSIONS_TEAM = [
        self::PERMISSION_MANAGE_TICKET_TEAM,
        self::PERMISSION_VIEW_TICKET_TEAM
    ];

    const PERMISSIONS_COMPANY = [
        self::PERMISSION_MANAGE_TICKET_COMPANY,
        self::PERMISSION_VIEW_TICKET_COMPANY
    ];

    const PERMISSIONS_TEAM_COMPANY = [
        self::PERMISSION_MANAGE_TICKET_TEAM,
        self::PERMISSION_MANAGE_TICKET_COMPANY,
        self::PERMISSION_VIEW_TICKET_TEAM,
        self::PERMISSION_VIEW_TICKET_COMPANY
    ];

    /*
     * comment types
     */
    const COMMENT_NORMAL   = 0;
    const COMMENT_RATING   = 1;
    const COMMENT_PRIORITY = 2;
    const COMMENT_DEADLINE = 3;

    /*
     * side bar menu
     */
    const MENU_CREATED_TICKETS = 1;
    const MENU_RELATED_TICKETS = 2;
    const MENU_ASSIGNED_TICKETS = 3;
    const MENU_TEAM_TICKETS = 4;
    const MENU_COMPANY_TICKETS = 5;

}