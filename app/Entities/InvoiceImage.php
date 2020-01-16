<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class InvoiceImage extends Model
{
    protected $table = "invoice_images";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'image', 'description', 'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
