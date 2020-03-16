<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibitor extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','userid','detailsid','name','booth','image', 'website','email','phone','description','toprated'
    ];
}