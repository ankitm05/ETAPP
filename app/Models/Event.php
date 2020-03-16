<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'userid','name', 'about','venu','email','phone','logo','banner','datefrom','dateto','event_code','status'
    ];
}