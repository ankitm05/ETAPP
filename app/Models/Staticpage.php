<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staticpage extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'page_id','title','content'
    ];
}