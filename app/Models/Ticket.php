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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deadline', 'resolved_at', 'closed_at', 'deleted_at', 'created_at', 'updated_at'];


    public function getPriority() {
        return TicketParser::getPriority($this->priority);
    }

    public function getStatus() {
        return TicketParser::getStatus($this->status);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function creator() {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function assignee() {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function relaters() {
        return $this->belongsToMany(Employee::class, 'ticket_relaters');
    }


    public function unreaders() {
        return $this->belongsToMany(Employee::class, 'ticket_reads')->wherePivot('status', 0);
    }

    public function comments() {
        return $this->hasMany(Thread::class);
    }

}
