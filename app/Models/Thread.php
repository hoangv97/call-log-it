<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected $table = 'ticket_thread';

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

}
