<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
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
                return view('add-customer');
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
                'gender' => $request->gender,
                'dob' => $request->dob,
                'mobile' => $request->mobile,
                'joined_on' => date('Y-m-d'),
                'created_by' => \Auth::id(),
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
