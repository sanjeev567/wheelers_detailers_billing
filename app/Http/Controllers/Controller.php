<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Function to return exception response
     */
    public function returnExceptionResponse(\Exception $e)
    {
        return response()->json(['status' => '0', 'msg' => $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile(), 'data' => null]);
    }
}
