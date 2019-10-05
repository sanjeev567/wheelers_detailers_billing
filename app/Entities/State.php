<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "states";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state',
        'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
