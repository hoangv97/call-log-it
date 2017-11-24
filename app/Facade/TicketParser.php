<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class TicketParser extends Facade {

    /*
     * filter tickets by status
     * used in sidebar & index view
     */
    public static function getTicketsByStatus($tickets, $status = null) {
        if(is_null($status) || $status == 0)
            return $tickets;
        if($status == 7)
            //out of date: cong viec qua deadline nhung chua duoc closed
            return $tickets->where('status', '!=', 5)->where('deadline', '<', now())->all();
        return $tickets->where('status', $status)->all();
    }

    /*
     * Parse priority and status from number to text or HTML
     * priority: 1-5
     * status: 1-6
     */
    public static function getPriority($priority, $withHtml = true) {
        $priority--;
        $priorities = ["thấp", "bình thường", "cao", "khẩn cấp"];
        $badges = ['info', 'primary', 'warning', 'danger'];
        if(!$withHtml)
            return ucfirst($priorities[$priority]);
        return '<span class="badge badge-roundless badge-'.$priority.' badge-'.$badges[$priority].'">'.ucfirst($priorities[$priority]).'</span>';
    }

    /*
     * null: return badge html
     * 0: name only
     * 1: a tag html with icon (for edit view)
     */
    public static function getStatus($status, $type = null)
    {
        $status--;
        $statuses = ["new", "inprogress", "resolved", "feedback", "closed", "cancelled"];
        if (is_null($type)) { //Badge
            $badges = ['warning', 'primary', 'success', 'info', 'danger', 'danger'];
            return '<span class="badge badge-roundless badge-' . $status . ' badge-' . $badges[$status] . '">' . ucfirst($statuses[$status]) . '</span>';
        } else if($type == 0) {
            return ucfirst($statuses[$status]);
        } else { //icons
            if($status == 4) //if closed, open modal, not update to server
                $closeModal = 'data-toggle="modal" data-target="#closed-modal"';
            $icons = ['envelope-o', 'hourglass-half', 'registered', 'reply-all', 'minus-circle', 'ban'];
            return '<li><a href="javascript:" class="btn-update-status" '.(isset($closeModal) ? $closeModal : '').' data-value="'.($status+1).'"><i class="fa fa-'.$icons[$status].'"></i> '.ucfirst($statuses[$status]).'</a></li>';
        }
    }

    /*
     * check if user can edit ticket by checking status
     * default: if status is resolved, closed or cancelled, user can not edit
     */
    public static function canEditTicket($status, $closedStatuses = [3, 5, 6]) {
        return !in_array($status, $closedStatuses);
    }



}