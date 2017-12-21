<?php

namespace App\Facade;

use App\Models\Employee;
use Illuminate\Support\Facades\Facade;

class TicketParser extends Facade {

    /*
     * get team name with html
     */
    public static function getTeamName($team) {
        $badges = ['', 'success', 'info'];
        return '<span data-team-id="'.$team->id.'" class="label label-'.$badges[$team->id].'">'
                    .$team->name.
                '</span>';
    }

    /*
     * get employee name with label html
     */
    public static function getEmployeeLabel(Employee $employee) {
        return '<span 
                    data-name="'.$employee->name.'" class="label" 
                    title="'.(is_null($employee->roleInTeam) ? '' : ($employee->roleInTeam->name.'  |  ')).$employee->email.'" 
                    style="color: #111; background-color: #E1E5EC; cursor: pointer"
                >'
                    .$employee->name.
                '</span>';
    }

    /*
     * filter tickets by status
     * used in sidebar & index view
     */
    public static function getTicketsByStatus($tickets, $status = null) {
        if(is_null($status) || $status == Constant::STATUS_ALL)
            return $tickets;
        if($status == Constant::STATUS_OUT_OF_DATE)
            //out of date: cong viec qua deadline nhung chua duoc closed
            return $tickets->where('status', '!=', Constant::STATUS_CLOSED)->where('deadline', '<', now())->all();
        return $tickets->where('status', $status)->all();
    }

    /*
     * Parse priority and status from number to text or HTML
     * priority: 1-5
     * status: 1-6
     */
    public static function getPriority($priority, $withHtml = true) {
        $priorities = ["", "thấp", "bình thường", "cao", "khẩn cấp"];
        $badges = ['', 'info', 'primary', 'warning', 'danger'];
        if(!$withHtml)
            return ucfirst($priorities[$priority]);
        return '<span class="label label-'.$priority.' label-'.$badges[$priority].'">'
                    .ucfirst($priorities[$priority]).
                '</span>';
    }

    /*
     * null: return label html
     * 0: name only
     * 1: a tag html with icon (for edit view)
     */
    public static function getStatus($status, $type = null)
    {
        if (is_null($type)) { //Label
            $badges = ['', 'warning', 'primary', 'success', 'info', 'danger', 'danger'];
            return '<span class="label label-'.$status.' label-'.$badges[$status].'">'
                        .Constant::STATUSES[$status].
                    '</span>';
        } else if($type == 0) {
            return Constant::STATUSES[$status];
        } else { //icons
            //if closed or cancelled, open modal, not update to server
            if($status == Constant::STATUS_CLOSED || $status == Constant::STATUS_CANCELLED)
                $closeModal = 'data-toggle="modal" data-target="#closed-modal"';

            $icons = ['', 'envelope-o', 'hourglass-half', 'registered', 'reply-all', 'minus-circle', 'ban'];
            $fonts = ['', 'yellow', 'blue', 'green', 'blue', 'red', 'red'];

            return '<li><a href="javascript:" class="btn-update-status" '.(isset($closeModal) ? $closeModal : '').' data-value="'.($status).'">
                        <i class="fa fa-'.$icons[$status].' font-'.$fonts[$status].'"></i> '.Constant::STATUSES[$status].
                    '</a></li>';
        }
    }

    /*
     * check if user can edit ticket by checking status
     * default: if status is resolved, closed or cancelled, user can not edit
     */
    public static function canEditTicket($status, $closedStatuses = Constant::STATUSES_CLOSED) {
        return !in_array($status, $closedStatuses);
    }

    /*
     * return thread note with rating, status and comment
     * when a ticket is closed or cancelled
     */
    public static function getThreadNote($status, $ratingNumber, $comment) {
        $ratings = ['Không hài lòng', 'Hài lòng'];
        $ratingIcons = ['times-circle-o', 'check-circle-o'];
        $ratingColors = ['red', 'yellow-crusta'];

        return
            "<b>".self::getStatus($status, 0)." request IT:</b><br/>
            <br/>
            <b>Đánh giá: <span class='font-$ratingColors[$ratingNumber]'><i class='fa fa-$ratingIcons[$ratingNumber]' aria-hidden='true'></i> $ratings[$ratingNumber]</span></b><br/>
            <br/>
            <b>Bình luận:</b><br/>
            $comment";
    }

    /*
     * return breadcrumb item name by type
     */
    public static function getBreadcrumb($type, $nameOnly = false) {
        if($type == Constant::MENU_CREATED_TICKETS)
            return null;
        $names = [null, null, 'Related', 'Assigned', 'Team IT', 'Department IT'];

        if($nameOnly)
            return $names[$type];

        return [
            'name' => $names[$type],
            'href' => route('request.index', [ 't' => $type, 's' => Constant::STATUS_ALL ])
        ];
    }

}