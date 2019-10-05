<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = "customers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gst_number',
        'address',
        'email',
        'mobile',
        'joined_on',
        'created_by',
        'state'
    ];

}
