<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = "customers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'dob',
        'mobile',
        'joined_on',
        'created_by',
        'gender',
    ];

}
