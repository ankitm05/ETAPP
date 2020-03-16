<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','userid','detailsid','title','content',
    ];
}