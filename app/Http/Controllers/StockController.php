<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Entities\Item;
use App\Entities\StockInvoice;
use App\Entities\StockInvoiceDetail;
use App\Entities\StockInvoiceImage;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends BaseController
{
    /**
     * Funtion to return the view for invoice generation page
     */
    public function addStockView(Request $request)
    {
        try {
            if (view()->exists('add-stock-invoice')) {
                if (!empty($request->id)) {
                    $invoice = StockInvoice::whereId($request->id)->first();
                    $invoiceItems = StockInvoiceDetail::where('stock_invoice_id', $request->id)->get();
                    $invoiceImages = StockInvoiceImage::where('stock_invoice_id', $request->id)->get();
                } else {
                    $invoice = null;
                    $invoiceItems = [];
                    $invoiceImages = [];
                }

                $customers = Customer::all();
                $items = Item::whereType('material')->get();

                return view('add-stock-invoice', [
                    'items' => $items,
                    'customers' => $customers,
                    'invoice' => $invoice,
                    'invoiceItems' => $invoiceItems,
                    'invoiceImages' => $invoiceImages,
                ]);
            } else {
                return view('view-not-found', ['viewName' => 'Add Stock Invoice page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function addStockInvoice(Request $request)
    {
        \DB::beginTransaction();
        try {
            $total = 0;
            $totalTax = 0;
            $totalWithoutTax = 0;

            $sellerDetails = Customer::whereId($request->customer)->first();

            $data = [
                'seller_id' => $request->customer,
                'total_items' => count($request->data),
                'created_by' => \Auth::id(),
                'invoice_date' => $request->invoice_date,

                'customer_name' => config('app_config.SELLER_NAME'),
                'customer_mobile' => config('app_config.SELLER_PHONE1'),
                'customer_email' => '',
                'customer_address' => config('app_config.SELLER_ADDRESS_LINE1') . config('app_config.SELLER_ADDRESS_LINE2') . config('app_config.SELLER_ADDRESS_LINE3'),
                'customer_state' => config('app_config.SELLER_STATE'),
                'buyer_gstin' => config('app_config.SELLER_GSTIN'),

                'seller_name' => $sellerDetails->name,
                'seller_phone1' => $sellerDetails->mobile,
                'seller_address_line1' => $sellerDetails->address,
                'seller_gstin' => $sellerDetails->gst_number,
                'seller_state' => $sellerDetails->state,

                'total_without_tax' => '0',
                'total_tax' => '0',
                'total_discount' => '0',
                'total' => '0',
                'type' => $request->type,
            ];

            if ($request->type == "challan") {
                $data['challan_number'] = $request->invoice_number;
            } else {
                $data['invoice_number'] = $request->invoice_number;
            }

            $invoice = StockInvoice::Create($data);

            if ($invoice) {

                $request->data = json_decode($request->data);
                foreach ($request->data as $row) {
                    $itemDetails = Item::whereId($row[0])->first();
                    $total += ($row[2] * $row[4]);
                    $totalTax += 0 * $row[4];
                    $totalWithoutTax += $row[2] * $row[4];

                    StockInvoiceDetail::create([
                        'stock_invoice_id' => $invoice->id,
                        'seller_id' => $request->customer,
                        'item_id' => $itemDetails->id,
                        'item_cost' => $row[2],
                        'item_cost_without_tax' => $row[2],
                        'quantity' => $row[4],
                        'created_by' => \Auth::id(),
                        'item_name' => $itemDetails->name,
                        'tax_percent' => 0,
                        'tax_value' => 0,
                    ]);

                    $itemDetails->update([
                        'stock' => $itemDetails->stock + $row[4],
                    ]);
                }

                StockInvoice::whereId($invoice->id)->update([
                    'total_without_tax' => $totalWithoutTax,
                    'total_tax' => $totalTax,
                    'total' => $total,
                ]);

                if ($files = $request->file('images')) {
                    foreach ($files as $file) {
                        $name = $file->getClientOriginalName();
                        $name = str_slug(pathinfo($name, PATHINFO_FILENAME));
                        $name = $name . '.' . $file->getClientOriginalExtension();

                        $pathToMove = (config('app.app_public_path_absolute') !== "")
                        ? (config('app.app_public_path_absolute') . config('app.user_doc_image_path'))
                        : public_path(config('app.user_doc_image_path'));

                        $file->move($pathToMove, $name);

                        StockInvoiceImage::insert([
                            'stock_invoice_id' => $invoice->id,
                            'image' => $name,
                            'description' => 'uploaded from web with invoice number ' . $invoice->id,
                            'created_by' => \Auth::id(),
                        ]);
                    }
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
    public function editStockInvoice(Request $request)
    {
        \DB::beginTransaction();
        try {
            $total = 0;
            $totalTax = 0;
            $totalWithoutTax = 0;

            $sellerDetails = Customer::whereId($request->customer)->first();

            $data = [
                'seller_id' => $request->customer,
                'total_items' => count($request->data),
                'created_by' => \Auth::id(),
                'invoice_date' => $request->invoice_date,

                'customer_name' => config('app_config.SELLER_NAME'),
                'customer_mobile' => config('app_config.SELLER_PHONE1'),
                'customer_email' => '',
                'customer_address' => config('app_config.SELLER_ADDRESS_LINE1') . config('app_config.SELLER_ADDRESS_LINE2') . config('app_config.SELLER_ADDRESS_LINE3'),
                'invoice_number' => $request->invoice_number,
                'customer_state' => config('app_config.SELLER_STATE'),
                'buyer_gstin' => config('app_config.SELLER_GSTIN'),

                'seller_name' => $sellerDetails->name,
                'seller_phone1' => $sellerDetails->mobile,
                'seller_address_line1' => $sellerDetails->address,
                'seller_gstin' => $sellerDetails->gst_number,
                'seller_state' => $sellerDetails->state,

                'total_without_tax' => '0',
                'total_tax' => '0',
                'total_discount' => '0',
                'total' => '0',
                'type' => $request->type,
            ];

            if ($request->type == "challan") {
                $data['challan_number'] = $request->invoice_number;
            } else {
                $data['invoice_number'] = $request->invoice_number;
            }

            StockInvoice::whereId($request->id)->update($data);

            $oldInvoiceDetails = StockInvoiceDetail::where('stock_invoice_id', $request->id)->get();

            foreach ($oldInvoiceDetails as $details) {
                $details->delete();
                $itemDetails = Item::whereId($details->item_id)->first();

                if ($request->force == "false" && $itemDetails->type == "material" && $itemDetails->stock - $details->quantity < 0) {
                    \DB::rollback();
                    return response()->json(['status' => '-1', 'data' => null, 'msg' => 'Not enough stock for material: ' . $itemDetails->name .
                        ', only ' . $itemDetails->stock . ' left in inventory. Are you sure you want to update this invoice?']);
                } else if ($itemDetails->type == "material") {
                    $itemDetails->update([
                        'stock' => $itemDetails->stock - $details->quantity,
                    ]);
                }
            }

            $request->data = json_decode($request->data);
            foreach ($request->data as $row) {
                $itemDetails = Item::whereId($row[0])->first();
                $total += ($row[2] * $row[4]);
                $totalTax += 0 * $row[4];
                $totalWithoutTax += $row[2] * $row[4];

                StockInvoiceDetail::create([
                    'stock_invoice_id' => $request->id,
                    'seller_id' => $request->customer,
                    'item_id' => $itemDetails->id,
                    'item_cost' => $row[2],
                    'item_cost_without_tax' => $row[2],
                    'quantity' => $row[4],
                    'created_by' => \Auth::id(),
                    'item_name' => $itemDetails->name,
                    'tax_percent' => 0,
                    'tax_value' => 0,
                ]);

                $itemDetails->update([
                    'stock' => $itemDetails->stock + $row[4],
                ]);
            }

            StockInvoice::whereId($request->id)->update([
                'total_without_tax' => $totalWithoutTax,
                'total_tax' => $totalTax,
                'total' => $total,
            ]);

            if ($files = $request->file('images')) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $name = str_slug(pathinfo($name, PATHINFO_FILENAME));
                    $name = $name . '.' . $file->getClientOriginalExtension();

                    $pathToMove = (config('app.app_public_path_absolute') !== "")
                    ? (config('app.app_public_path_absolute') . config('app.user_doc_image_path'))
                    : public_path(config('app.user_doc_image_path'));

                    $file->move($pathToMove, $name);

                    StockInvoiceImage::insert([
                        'stock_invoice_id' => $request->id,
                        'image' => $name,
                        'description' => 'uploaded from web with invoice number ' . $request->id,
                        'created_by' => \Auth::id(),
                    ]);
                }
            }

            \DB::commit();
            return response()->json(['status' => '1', 'data' => $request->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function stockInvoiceList(Request $request)
    {
        try {
            if (view()->exists('stock-invoice-list')) {
                $invoices = \DB::table('stock_invoices as i')
                    ->join('customers as c', 'c.id', '=', 'i.seller_id')
                    ->select([
                        'i.id as id',
                        'i.type as type',
                        'i.challan_number as challan_number',
                        'i.invoice_number as invoice_number',
                        'i.total as total',
                        'c.name as seller_name',
                        'c.mobile as seller_mobile',
                        'i.invoice_date as invoice_date',
                    ])
                    ->get();

                return view('stock-invoice-list', ['invoices' => $invoices]);
            } else {
                return view('view-not-found', ['viewName' => 'Stock Invoice List Page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function deleteStockInvoice(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric|exists:customers,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 0, 'data' => $validator->errors()]);
            }

            $customer = Customer::whereId($request->id)->delete();
            if ($customer) {
                return response()->json(['status' => '1', 'data' => (string) $customer]);
            } else {
                return response()->json(['status' => '0', 'data' => null]);
            }
        } catch (\Exception $e) {
            return $this->returnExceptionResponse($e);
        }
    }

    /**
     * Function to delete an image from system
     */
    public function deleteUserDocumentImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 0, 'data' => $validator->errors()]);
            }

            $stockInvoiceImage = StockInvoiceImage::whereId($request->id)->first();

            $imageFolderPath = (config('app.app_public_path_absolute') !== "")
            ? (config('app.app_public_path_absolute') . config('app.user_doc_image_path'))
            : public_path(config('app.user_doc_image_path'));

            $fileToDelete = $imageFolderPath . '/' . $stockInvoiceImage->image;

            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }

            $stockInvoiceImage->delete();
            if ($stockInvoiceImage) {
                return response()->json(['status' => '1', 'data' => (string) $stockInvoiceImage]);
            } else {
                return response()->json(['status' => '0', 'data' => null]);
            }
        } catch (\Exception $e) {
            return $this->returnExceptionResponse($e);
        }
    }
}
