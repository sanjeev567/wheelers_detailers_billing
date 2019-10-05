<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Entities\State;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    /**
     * Funtion to return the view for invoice generation page
     */
    public function addCustomerView(Request $request)
    {
        try {
            if (view()->exists('add-customer')) {
                $states = State::all();
                return view('add-customer', ['states' => $states]);
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
    public function addCustomer(Request $request)
    {
        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'gst_number' => $request->gst_number,
                'mobile' => $request->mobile,
                'joined_on' => date('Y-m-d'),
                'created_by' => \Auth::id(),
                'state' => $request->state
            ]);

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
    public function customerList(Request $request)
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
}
