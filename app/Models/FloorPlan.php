<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloorPlan extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','detailsid','name','floor_image'
    ];
}