<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','user_id','bookmark_id','type'
    ];

}