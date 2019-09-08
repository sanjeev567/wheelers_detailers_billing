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
Route::group(['middleware' => 'auth', 'prefix' => config('app.APP_URL_PREFIX')], function () {
    Route::get('/', 'InvoiceController@invoiceView');
    Route::get('/home', 'InvoiceController@invoiceView');
    Route::get('/invoice-list', 'InvoiceController@invoiceList');
    Route::get('/invoice/{id}', 'InvoiceController@viewInvoiceById');

    Route::get('/add-customer', 'CustomerController@addCustomerView');
    Route::post('/add-customer', 'CustomerController@addCustomer');
    Route::get('/customer-list', 'CustomerController@customerList');

    Route::get('/add-package', 'PackageController@addPackage');
    Route::get('/package-list', 'PackageController@packageList');

    Route::post('/generate-invoice', 'InvoiceController@generateInvoice');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});
