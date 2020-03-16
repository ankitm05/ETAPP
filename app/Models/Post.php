<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','user_id','post_content', 'post_image'
    ];

    public function user() {
        return  $this->belongsTo(\App\User::class,'user_id');
    }
}