<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StockInvoiceImage extends Model
{
    protected $table = "stock_invoice_images";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock_invoice_id', 'image', 'description', 'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
