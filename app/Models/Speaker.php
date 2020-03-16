<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','userid','detailsid','name','cname','image', 'position','email','phone','description','toprated'
    ];
}