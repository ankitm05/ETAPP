<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnare extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'event_id','question','optiona', 'optionb','optionc','optiond'
    ];
}