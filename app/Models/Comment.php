<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'post_id','user_id','content'
    ];

    public function user() {
        return  $this->belongsTo(\App\User::class,'user_id');
    }
}