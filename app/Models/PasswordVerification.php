<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordVerification extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'email', 'verify_code'
    ];
}