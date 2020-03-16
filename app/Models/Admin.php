<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guarded = [];
    protected $guard = 'admin';
    protected $fillable = [
        'username', 'type', 'email', 'password','remember_token','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}