<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'email', 'verify_code'
    ];
}