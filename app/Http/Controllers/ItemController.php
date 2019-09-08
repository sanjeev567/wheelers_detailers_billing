<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Entities\Item;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class ItemController extends BaseController
{
    /**
     * Funtion to return the view for invoice generation page
     */
    public function addItemView(Request $request)
    {
        try {
            if (view()->exists('add-item')) {
                return view('add-item');
            } else {
                return view('view-not-found', ['viewName' => 'Add Item page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function addItem(Request $request)
    {
        try {
            $item = Item::create([
                'name' => $request->name,
                'price' => $request->price,
                'item_code' => $request->code
            ]);

            if ($item) {
                return response()->json(['status' => '1', 'data' => $item]);
            }
            return response()->json(['status' => '0', 'data' => null]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for invoice generation page
     */
    public function itemList(Request $request)
    {
        try {
            if (view()->exists('item-list')) {
                $items = Item::all();
                return view('item-list', ['items' => $items]);
            } else {
                return view('view-not-found', ['viewName' => 'Item List page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
