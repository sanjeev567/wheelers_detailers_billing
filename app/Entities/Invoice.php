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
        'seller_name',
        'web_link',
        'seller_phone1',
        'seller_phone2',
        'seller_address_line1',
        'seller_address_line2',
        'seller_address_line3',
        'gs_tin',
        'total_without_tax',
        'total_tax',
        'total_discount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
