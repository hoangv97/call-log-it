<?php

namespace App\Models;

use App\Facade\TicketParser;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    public function employees() {
        return $this->hasManyThrough(
            'App\Models\Employee',
            'App\Models\RoleTeam',
            'team_id',
            'role_team_id');
    }

    public function leader() {
        return $this->employees->filter(function ($employee) {
            return $employee->role->id == 3;
        })->first();
    }

    public function members() {
        return $this->employees->filter(function ($employee) {
            return $employee->role->id == 1;
        })->all();
    }

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }

    public function getTicketsByStatus($status = null) {
        return TicketParser::getTicketsByStatus($this->tickets, $status);
    }

}
