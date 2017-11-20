<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class TicketParser extends Facade {

    public static function getPriority($priority) {
        $priority--;
        $priorities = ["thấp", "bình thường", "cao", "khẩn cấp"];
        $badges = ['info', 'primary', 'warning', 'danger'];
        return '<span class="badge badge-roundless badge-'.$priority.' badge-'.$badges[$priority].'">'.ucfirst($priorities[$priority]).'</span>';
    }

    public static function getStatus($status) {
        $status--;
        $statuses = ["new", "inprogress", "resolved", "feedback", "closed", "cancelled"];
        $badges = ['warning', 'primary', 'success', 'info', 'danger', 'danger'];
        return '<span class="badge badge-roundless badge-'.$status.' badge-'.$badges[$status].'">'.ucfirst($statuses[$status]).'</span>';
    }

}