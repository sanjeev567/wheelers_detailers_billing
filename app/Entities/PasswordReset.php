<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class PasswordReset extends Authenticatable
{
    protected $table="password_resets";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'mobile', 'token', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
