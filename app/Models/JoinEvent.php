<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinEvent extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','user_id','status'
    ];
}