<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponser extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','userid','detailsid','name','level','image', 'website','email','phone','description','toprated'
    ];
}