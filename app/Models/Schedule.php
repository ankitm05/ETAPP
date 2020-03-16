<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','userid','detailsid','name','event_date', 'event_from','event_to','location','speaker','description'
    ];
}