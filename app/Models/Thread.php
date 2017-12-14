<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected $table = 'ticket_thread';

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

}
