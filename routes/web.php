<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/', 'InvoiceController@invoiceView');
    Route::get('/home', 'InvoiceController@invoiceView');
    Route::get('/invoice-list', 'InvoiceController@invoiceList');
    Route::get('/invoice/{id}', 'InvoiceController@viewInvoiceById');
    Route::get('/invoice-edit/{id}', 'InvoiceController@invoiceView');
    Route::post('/invoice-edit', 'InvoiceController@editInvoice');

    Route::post('/upload-invoice-image', 'InvoiceController@uploadInvoiceImage');
    Route::post('/delete-invoice-image', 'InvoiceController@deleteInvoiceImage');
    Route::post('/get-invoice-images', 'InvoiceController@getInvoiceImages');


    Route::get('/add-customer/{id?}', 'CustomerController@addCustomerView');
    Route::post('/add-customer', 'CustomerController@addCustomer');
    Route::get('/customer-list', 'CustomerController@customerList');
    Route::post('/delete-customer', 'CustomerController@deleteCustomer');

    Route::get('/add-item/{id?}', 'ItemController@addItemView');
    Route::post('/delete-item', 'ItemController@deleteItem');

    Route::post('/add-item', 'ItemController@addItem');
    Route::get('/item-list', 'ItemController@itemList');

    Route::get('/add-package', 'PackageController@addPackage');
    Route::get('/package-list', 'PackageController@packageList');

    Route::post('/generate-invoice', 'InvoiceController@generateInvoice');
    Route::post('/cancel-invoice', 'InvoiceController@cancelInvoice');

    Route::get('/add-stock/{id?}', 'StockController@addStockView');
    Route::post('/add-stock-invoice', 'StockController@addStockInvoice');
    Route::post('/edit-stock-invoice', 'StockController@editStockInvoice');
    Route::get('/stock-invoice-list', 'StockController@stockInvoiceList');
    Route::post('/delete-user-doc-image', 'StockController@deleteUserDocumentImage');
    Route::get('/view-stock', 'StockController@viewStock');

    Route::post('/invoice-list-dump', 'InvoiceListDumpController@invoiceListDumpDownload');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});
