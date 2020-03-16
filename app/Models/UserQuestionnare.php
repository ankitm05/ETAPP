<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuestionnare extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','user_id', 'question_id','selected'
    ];
}