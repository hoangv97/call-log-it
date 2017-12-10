<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class TicketParser extends Facade {

    /*
     * get team name with html
     */
    public static function getTeamName($team) {
        $badges = ['', 'danger', 'info'];
        return '<span class="badge badge-roundless badge-'.$team->id.' badge-'.$badges[$team->id].'">'
                    .$team->name.
                '</span>';
    }

    /*
     * get employee name with badge html
     */
    public static function getEmployeeHtml($name) {
        return '<span class="badge badge-roundless employee-badge" style="color: #111;background-color: #E1E5EC">'
                    .$name.
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
        return '<span class="badge badge-roundless badge-'.$priority.' badge-'.$badges[$priority].'">'
                    .ucfirst($priorities[$priority]).
                '</span>';
    }

    /*
     * null: return badge html
     * 0: name only
     * 1: a tag html with icon (for edit view)
     */
    public static function getStatus($status, $type = null)
    {
        if (is_null($type)) { //Badge
            $badges = ['', 'warning', 'primary', 'success', 'info', 'danger', 'danger'];
            return '<span class="badge badge-roundless badge-' . $status . ' badge-'.$badges[$status].'">'
                        .Constant::STATUSES[$status].
                    '</span>';
        } else if($type == 0) {
            return Constant::STATUSES[$status];
        } else { //icons
            //if closed or cancelled, open modal, not update to server
            if($status == Constant::STATUS_CLOSED || $status == Constant::STATUS_CANCELLED)
                $closeModal = 'data-toggle="modal" data-target="#closed-modal"';
            $icons = ['', 'envelope-o', 'hourglass-half', 'registered', 'reply-all', 'minus-circle', 'ban'];
            return '<li><a href="javascript:" class="btn-update-status" '.(isset($closeModal) ? $closeModal : '').' data-value="'.($status).'">
                        <i class="fa fa-'.$icons[$status].'"></i> '.Constant::STATUSES[$status].
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



}