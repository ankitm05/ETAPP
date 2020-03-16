<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','feature_id','type','form_name'
    ];
}