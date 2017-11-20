<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_url', 'team_id', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function team() {
        return $this->belongsTo('App\Models\Team');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function createdTickets() {
        return $this->hasMany('App\Models\Ticket', 'created_by');
    }

    public function assignedTickets() {
        return $this->hasMany('App\Models\Ticket', 'assigned_to');
    }

    public function relatedTickets() {
        return $this->belongsToMany('App\Models\Ticket', 'ticket_relaters');
    }

    public function unreadTickets() {
        return $this->belongsToMany('App\Models\Ticket', 'ticket_reads')->wherePivot('status', 0);
    }
}
