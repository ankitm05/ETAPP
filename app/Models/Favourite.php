<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','post_id','user_id','fav'
    ];
}