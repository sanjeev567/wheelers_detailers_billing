<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class PackageController extends BaseController
{
    /**
     * Funtion to return the view for add pacakge page
     */
    public function addPackage(Request $request)
    {
        try {
            if (view()->exists('add-package')) {
                return view('add-package', ['items' => '']);
            } else {
                return view('view-not-found', ['viewName' => 'Add Package page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Funtion to return the view for package listing page
     */
    public function packageList(Request $request)
    {
        try {
            if (view()->exists('package-list')) {
                return view('package-list', ['items' => '']);
            } else {
                return view('view-not-found', ['viewName' => 'Package List page']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
