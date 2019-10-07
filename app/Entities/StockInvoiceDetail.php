<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockInvoiceDetail extends Model
{
    use SoftDeletes;

    protected $table = "stock_invoice_details";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock_invoice_id',
        'seller_id',
        'item_id',
        'quantity',
        'item_cost',
        'discount',
        'created_by',
        'item_name',
        'item_description',
        'tax_percent',
        'tax_value',
        'item_cost_without_tax',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
