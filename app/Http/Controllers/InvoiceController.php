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

                $selectedCustomer = $request->cust;

                return view('invoice-view', ['items' => $items, 'customers' => $customers, 'selectedCustomer' => $selectedCustomer]);
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
            $totalTax = 0;
            $totalWithoutTax = 0;
            $totalDiscount = 0;

            $customerDetails = Customer::whereId($request->customer)->first();
            $invoice = Invoice::Create([
                'customer_id' => $request->customer,
                'total_items' => count($request->data),
                'created_by' => \Auth::id(),

                'customer_name' => $customerDetails->name,
                'customer_mobile' => $customerDetails->mobile,
                'customer_email' => $customerDetails->email,
                'customer_address' => $customerDetails->address,
                'buyer_gstin' => $customerDetails->gst_number,
                'seller_name' => config('app_config.SELLER_NAME'),
                'web_link' => config('app_config.SELLER_WEB_LINKS'),
                'seller_phone1' => config('app_config.SELLER_PHONE1'),
                'seller_phone2' => config('app_config.SELLER_PHONE2'),
                'seller_address_line1' => config('app_config.SELLER_ADDRESS_LINE1'),
                'seller_address_line2' => config('app_config.SELLER_ADDRESS_LINE2'),
                'seller_address_line3' => config('app_config.SELLER_ADDRESS_LINE3'),
                'seller_gstin' => config('app_config.SELLER_GSTIN'),
                'seller_pan' => config('app_config.SELLER_PAN'),
                'seller_bank' => config('app_config.SELLER_BANK_NAME'),
                'seller_branch' => config('app_config.SELLER_BANK_BRANCH_NAME'),
                'seller_ifsc' => config('app_config.SELLER_BANK_IFSC'),
                'seller_account_number' => config('app_config.SELLER_BANK_ACCOUNT_NUMBER'),
                'total_without_tax' => '0',
                'total_tax' => '0',
                'total_discount' => '0',
                'total' => '0',
            ]);

            if ($invoice) {
                foreach ($request->data as $row) {
                    $itemDetails = Item::whereId($row[0])->first();
                    $total += ($itemDetails->price * $row[3]) - ($itemDetails->price * $row[3] * $row[4] / 100);
                    $totalTax += $itemDetails->tax_value * $row[3];
                    $totalWithoutTax += $itemDetails->price_without_tax * $row[3];
                    $totalDiscount += $itemDetails->price * $row[3] * $row[4] / 100;

                    InvoiceDetail::create([
                        'invoice_id' => $invoice->id,
                        'customer_id' => $request->customer,
                        'item_id' => $itemDetails->id,
                        'item_cost' => $itemDetails->price,
                        'item_cost_without_tax' => $itemDetails->price_without_tax,
                        'quantity' => $row[3],
                        'discount' => $row[4],
                        'created_by' => \Auth::id(),
                        'item_name' => $itemDetails->name,
                        'tax_percent' => $itemDetails->tax_percent,
                        'tax_value' => $itemDetails->tax_value,
                    ]);
                }

                Invoice::whereId($invoice->id)->update([
                    'total_without_tax' => $totalWithoutTax,
                    'total_tax' => $totalTax,
                    'total_discount' => $totalDiscount,
                    'total' => $total,
                ]);

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
                        'i.created_at as created_at',
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
            if (view()->exists('generate-invoice-view')) {
                $invoice = \DB::table('invoices as i')
                    ->join('customers as c', 'c.id', '=', 'i.customer_id')
                    ->select([
                        'i.*',
                        'c.name as customer_name',
                        'c.mobile as customer_mobile',
                        'c.email as customer_email',
                        'c.email as customer_email',
                    ])
                    ->where('i.id', $request->id)
                    ->first();

                $invoiceDetails = \DB::table('invoice_details as id')
                    ->join('items as i', 'i.id', '=', 'id.item_id')
                    ->select([
                        'id.*',
                        \DB::raw('(id.item_cost * id.quantity) - (id.item_cost * id.quantity * id.discount/100) as sub_total'),
                    ])
                    ->where('id.invoice_id', $request->id)
                    ->get();

                return view('generate-invoice-view', ['invoice' => $invoice, 'invoiceDetails' => $invoiceDetails]);
            } else {
                return view('view-not-found', ['viewName' => 'Invoice page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
