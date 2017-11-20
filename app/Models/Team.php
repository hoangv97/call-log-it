<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    public function employees() {
        return $this->hasMany('App\Models\Employee');
    }

}
