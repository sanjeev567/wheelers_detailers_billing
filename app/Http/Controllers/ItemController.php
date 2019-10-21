<?php

namespace App\Http\Controllers;

use App\Entities\Item;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseController
{
    /**
     * Funtion to return the view for invoice generation page
     */
    public function addItemView(Request $request)
    {
        try {
            if (view()->exists('add-item')) {
                if (!empty($request->id)) {
                    $item = Item::whereId($request->id)->first();
                } else {
                    $item = null;
                }
                return view('add-item', ['item' => $item]);
            } else {
                if (!empty($request->id)) {
                    return view('view-not-found', ['viewName' => 'Update Item page']);
                }
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
            $data = [
                'name' => $request->name,
                'size' => $request->size,
                'tax_percent' => $request->tax,
                'tax_value' => ($request->price * $request->tax / 100),
                'price_without_tax' => $request->price,
                'price' => ($request->price + $request->price * $request->tax / 100),
                'type' => $request->type,
                'stock' => $request->stock,
                'hsn_number' => $request->hsn_number,
            ];

            if (!empty($request->id)) {
                $item = Item::whereId($request->id)->update($data);
            } else {
                $item = Item::create($data);
            }

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

    /**
     * Funtion to return the view for invoice generation page
     */
    public function deleteItem(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 0, 'data' => $validator->errors()]);
            }

            $item = Item::whereId($request->id)->delete();
            if ($item) {
                return response()->json(['status' => '1', 'data' => (string) $item]);
            } else {
                return response()->json(['status' => '0', 'data' => null]);
            }
        } catch (\Exception $e) {
            return $this->returnExceptionResponse($e);
        }
    }
}
