<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $table = "access_logs";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_ip',
        'request_url',
        'request_headers',
        'request',
        'response_status',
        'response_headers',
        'response',
        'extra'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
