<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = "invoices";

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'total',
        'total_items',
        'created_by',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'customer_address',
        'seller_name',
        'web_link',
        'seller_phone1',
        'seller_phone2',
        'seller_address_line1',
        'seller_address_line2',
        'seller_address_line3',
        'total_without_tax',
        'total_tax',
        'total_discount',
        'seller_gstin',
        'seller_pan',
        'buyer_gstin',
        'seller_bank',
        'seller_branch',
        'seller_ifsc',
        'seller_account_number',
        'seller_cin',
        'invoice_number',
        'customer_state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
