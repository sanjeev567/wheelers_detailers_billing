<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Entities\Invoice;
use App\Entities\InvoiceDetail;
use App\Entities\Item;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class InvoiceController extends BaseController
{
    /**
     * Funtion to return the view for invoice generation page
     */
    public function invoiceView(Request $request)
    {
        try {
            if (view()->exists('invoice-view')) {
                $items = Item::all();
                $customers = Customer::all();

                return view('invoice-view', ['items' => $items, 'customers' => $customers]);
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
        \DB::beginTransaction();
        try {
            $total = 0;

            foreach ($request->data as $item) {
                $total += $item[2];
            }

            $invoice = Invoice::Create([
                'customer_id' => $request->customer,
                'total' => $total,
                'total_items' => count($request->data),
                'created_by' => \Auth::id(),
            ]);

            if ($invoice) {
                foreach ($request->data as $row) {
                    InvoiceDetail::create([
                        'invoice_id' => $invoice->id,
                        'customer_id' => $request->customer,
                        'item_id' => $row[0],
                        'item_cost' => $row[2],
                        'quantity' => $row[3],
                        'discount' => $row[4],
                        'created_by' => \Auth::id(),
                    ]);
                }
                \DB::commit();
                return response()->json(['status' => '1', 'data' => $invoice->id]);
            }

            \DB::rollback();
            return response()->json(['status' => '0', 'data' => null]);
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function invoiceList(Request $request)
    {
        try {
            if (view()->exists('invoice-list')) {
                $invoices = \DB::table('invoices as i')
                ->join('customers as c', 'c.id', '=', 'i.customer_id')
                ->select([
                    'i.id as id',
                    'i.total as total',
                    'c.name as customer_name',
                    'c.mobile as customer_mobile',
                    'i.created_at as created_at'
                ])
                ->get();

                return view('invoice-list', ['invoices' => $invoices]);
            } else {
                return view('view-not-found', ['viewName' => 'Invoice List page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function viewInvoiceById(Request $request)
    {
        try {
            if (view()->exists('invoice-view')) {
                $items = Item::all();
                $customers = Customer::all();

                return view('invoice-view', ['items' => $items, 'customers' => $customers]);
            } else {
                return view('view-not-found', ['viewName' => 'Invoice page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
