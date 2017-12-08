<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use App\Facade\TicketParser;

class Ticket extends Model
{
    use Sluggable, SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'subject'
            ]
        ];
    }


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
