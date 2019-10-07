<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

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
                    $customer = Customer::whereId($request->id)->first();
                } else {
                    $customer = null;
                }
                $states = State::all();
                return view('add-stock-invoice', ['materials' => $states, 'customer' => $customer]);
            } else {
                return view('view-not-found', ['viewName' => 'Add Customer page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function addStock(Request $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'gst_number' => $request->gst_number,
                'mobile' => $request->mobile,
                'joined_on' => date('Y-m-d'),
                'created_by' => \Auth::id(),
                'state' => $request->state,
            ];

            if (!empty($request->id)) {
                $customer = Customer::whereId($request->id)->update($data);
            } else {
                $customer = Customer::create($data);
            }

            if ($customer) {
                return response()->json(['status' => '1', 'data' => $customer]);
            }
            return response()->json(['status' => '0', 'data' => null]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function stockInvoiceList(Request $request)
    {
        try {
            if (view()->exists('customer-list')) {
                $customers = Customer::all();
                return view('customer-list', ['customers' => $customers]);
            } else {
                return view('view-not-found', ['viewName' => 'Customer List page']);
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
}
