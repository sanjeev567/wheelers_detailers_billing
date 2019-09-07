<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'item_code', 'batch_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
