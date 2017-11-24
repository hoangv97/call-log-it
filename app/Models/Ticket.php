<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facade\TicketParser;

class Ticket extends Model
{

    public function getPriority() {
        return TicketParser::getPriority($this->priority);
    }

    public function getStatus() {
        return TicketParser::getStatus($this->status);
    }

    public function team() {
        return $this->belongsTo('App\Models\Team');
    }

    public function creator() {
        return $this->belongsTo('App\Models\Employee', 'created_by');
    }

    public function assignee() {
        return $this->belongsTo('App\Models\Employee', 'assigned_to');
    }

    public function relaters() {
        return $this->belongsToMany('App\Models\Employee', 'ticket_relaters');
    }


    public function unreaders() {
        return $this->belongsToMany('App\Models\Employee', 'ticket_reads')->wherePivot('status', 0);
    }

}
