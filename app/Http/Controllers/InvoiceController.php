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
                if (!empty($request->id)) {
                    $invoice = Invoice::whereId($request->id)->first();
                    $invoiceDetails = InvoiceDetail::where('invoice_id', $request->id)->get();
                } else {
                    $invoice = null;
                    $invoiceDetails = [];
                }

                $items = Item::all();
                $customers = Customer::all();

                $selectedCustomer = $request->cust;

                return view('invoice-view', [
                    'items' => $items,
                    'customers' => $customers,
                    'selectedCustomer' => $selectedCustomer,
                    'invoice' => $invoice,
                    'invoiceDetails' => $invoiceDetails
                ]);
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
                'invoice_number' => $this->getInvoiceNumber(),
                'customer_state' => $customerDetails->state,
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
                'seller_cin' => config('app_config.SELLER_CIN'),
                'seller_state' => config('app_config.SELLER_STATE'),
                'total_without_tax' => '0',
                'total_tax' => '0',
                'total_discount' => '0',
                'total' => '0',
                'type' => (!empty($request->invoice_type)) ? $request->invoice_type : 'treatment',
            ]);

            if ($invoice) {
                foreach ($request->data as $row) {
                    $dis = $row[4];
                    $qty = $row[3];

                    $itemDetails = Item::whereId($row[0])->first();

                    $subTotalWithoutTax = $itemDetails->price_without_tax * $qty;
                    $subTotalDiscount = ($itemDetails->price_without_tax * $qty * $dis / 100);
                    $subTotalTax = (($subTotalWithoutTax - $subTotalDiscount) * $itemDetails->tax_percent / 100);
                    $subTotal = $subTotalWithoutTax - $subTotalDiscount + $subTotalTax;

                    $totalWithoutTax += $subTotalWithoutTax;
                    $totalDiscount += $subTotalDiscount;
                    $totalTax += $subTotalTax;
                    $total += $subTotal;

                    if ($request->force == "false" && $itemDetails->type == "material" && $itemDetails->stock - $qty < 0) {
                        \DB::rollback();
                        return response()->json(['status' => '-1', 'data' => null, 'msg' => 'Not enough stock for material: ' . $itemDetails->name .
                            ', only ' . $itemDetails->stock . ' left in inventory. Are you sure you want to make this invoice?']);
                    } else if ($itemDetails->type == "material") {
                        $itemDetails->update([
                            'stock' => $itemDetails->stock - $qty,
                        ]);
                    }

                    InvoiceDetail::create([
                        'invoice_id' => $invoice->id,
                        'customer_id' => $request->customer,
                        'item_id' => $itemDetails->id,
                        'item_cost' => $itemDetails->price,
                        'item_cost_without_tax' => $itemDetails->price_without_tax,
                        'quantity' => $qty,
                        'discount' => $dis,
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
                    ->select([
                        'i.id as id',
                        'i.invoice_number as invoice_number',
                        'i.total as total',
                        'i.customer_name as customer_name',
                        'i.customer_address as customer_address',
                        'i.created_at as created_at',
                        'i.deleted_at as deleted_at',
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
                        'i.type as type',
                        'i.hsn_number',
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

    /**
     * Function to cancel invoice
     *
     * @param Requst $request
     *
     */
    public function cancelInvoice(Request $request)
    {
        \DB::beginTransaction();
        try {
            $invoice = Invoice::whereId($request->id)->first();

            if (!$invoice) {
                return response()->json(['status' => '0', 'msg' => 'Invoice already cancelled']);
            }

            $invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();

            foreach ($invoiceDetails as $item) {
                $itemDetails = Item::whereId($item->item_id)->first();

                if ($itemDetails->type == "material") {
                    $itemDetails->update([
                        'stock' => $itemDetails->stock + $item->quantity,
                    ]);
                }

                $item->delete();
            }

            $invoice->delete();

            \DB::commit();
            return response()->json(['status' => '1', 'data' => $invoice->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    /**
     * Function to get new invoice number
     */
    public function getInvoiceNumber()
    {
        try {
            $date = date_create();
            if (date_format($date, "m") >= 4) { //On or After April (FY is current year - next year)
                $financial_year = (date_format($date, "y")) . '/' . (date_format($date, "y") + 1);

                $currentInvoiceNumber = Invoice::withTrashed()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('first day of april this year')))->get()->count();

            } else { //On or Before March (FY is previous year - current year)
                $financial_year = (date_format($date, "y") - 1) . '/' . date_format($date, "y");

                $currentInvoiceNumber = Invoice::withTrashed()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('first day of april last year')))->get()->count();
            }

            return 'TW-' . $financial_year . '-' . ((int) $currentInvoiceNumber + 1);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Function to edit the invoice
     *
     * @param Request $request
     *
     * @return JSON
     */
    public function editInvoice(Request $request)
    {
        try {
            \DB::beginTransaction();
            $total = 0;
            $totalTax = 0;
            $totalWithoutTax = 0;
            $totalDiscount = 0;
            $customerDetails = Customer::whereId($request->customer)->first();

            $data = [
                'customer_id' => $request->customer,
                'total_items' => count($request->data),
                'created_by' => \Auth::id(),
                'customer_name' => $customerDetails->name,
                'customer_mobile' => $customerDetails->mobile,
                'customer_email' => $customerDetails->email,
                'customer_address' => $customerDetails->address,
                'customer_state' => $customerDetails->state,
                'buyer_gstin' => $customerDetails->gst_number,
                'total_without_tax' => '0',
                'total_tax' => '0',
                'total_discount' => '0',
                'total' => '0',
                'type' => (!empty($request->invoice_type)) ? $request->invoice_type : 'treatment',
            ];

            $invoice = Invoice::whereId($request->id)->update($data);

            if ($invoice) {
                $oldInvoiceDetails = InvoiceDetail::where('invoice_id', $request->id)->get();

                foreach ($oldInvoiceDetails as $details) {
                    $itemDetails = Item::whereId($details->item_id)->first();

                    $itemDetails->update([
                        'stock' => $itemDetails->stock - $details->quantity,
                    ]);

                    $details->forceDelete();
                }

                foreach ($request->data as $row) {
                    $dis = $row[4];
                    $qty = $row[3];

                    $itemDetails = Item::whereId($row[0])->first();

                    $subTotalWithoutTax = $itemDetails->price_without_tax * $qty;
                    $subTotalDiscount = ($itemDetails->price_without_tax * $qty * $dis / 100);
                    $subTotalTax = (($subTotalWithoutTax - $subTotalDiscount) * $itemDetails->tax_percent / 100);
                    $subTotal = $subTotalWithoutTax - $subTotalDiscount + $subTotalTax;

                    $totalWithoutTax += $subTotalWithoutTax;
                    $totalDiscount += $subTotalDiscount;
                    $totalTax += $subTotalTax;
                    $total += $subTotal;

                    if ($request->force == "false" && $itemDetails->type == "material" && $itemDetails->stock - $qty < 0) {
                        \DB::rollback();
                        return response()->json(['status' => '-1', 'data' => null, 'msg' => 'Not enough stock for material: ' . $itemDetails->name .
                            ', only ' . $itemDetails->stock . ' left in inventory. Are you sure you want to make this invoice?']);
                    } else if ($itemDetails->type == "material") {
                        $itemDetails->update([
                            'stock' => $itemDetails->stock - $qty,
                        ]);
                    }

                    InvoiceDetail::create([
                        'invoice_id' => $request->id,
                        'customer_id' => $request->customer,
                        'item_id' => $itemDetails->id,
                        'item_cost' => $itemDetails->price,
                        'item_cost_without_tax' => $itemDetails->price_without_tax,
                        'quantity' => $qty,
                        'discount' => $dis,
                        'created_by' => \Auth::id(),
                        'item_name' => $itemDetails->name,
                        'tax_percent' => $itemDetails->tax_percent,
                        'tax_value' => $itemDetails->tax_value,
                    ]);
                }

                Invoice::whereId($request->id)->update([
                    'total_without_tax' => $totalWithoutTax,
                    'total_tax' => $totalTax,
                    'total_discount' => $totalDiscount,
                    'total' => $total,
                ]);

                \DB::commit();
                return response()->json(['status' => '1', 'data' => $request->id]);
            }

            \DB::rollback();
            return response()->json(['status' => '0', 'data' => null]);
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }
}
