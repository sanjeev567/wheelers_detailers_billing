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
    public function invoiceView(Request $request)
    {
        try {
            if (view()->exists('invoice-view')) {
                $items = Item::all();

                return view('invoice-view', ['items' => $items]);
            } else {
                return view('view-not-found', ['viewName' => 'Invoice page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for generate invoice
     */
    public function generateInvoice(Request $request)
    {
        try {
            if (view()->exists('generate-invoice-view')) {

            } else {
                return view('view-not-found', ['viewName' => 'Generated Invoice page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
