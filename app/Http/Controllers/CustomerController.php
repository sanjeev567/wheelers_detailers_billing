<?php

namespace App\Http\Controllers;

use App\Entities\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class CustomerController extends BaseController
{
    /**
     * Funtion to return the view for invoice generation page
     */
    public function addCustomer(Request $request)
    {
        try {
            if (view()->exists('add-customer')) {
                return view('add-customer', ['items' => '']);
            } else {
                return view('view-not-found', ['viewName' => 'Add Customer page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
