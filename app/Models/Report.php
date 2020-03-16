<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','post_id','user_id','reason','description'
    ];

    public function user() {
        return  $this->belongsTo(\App\User::class,'user_id');
    }

}