<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return 'display order page here';
    }

    public function store(Request $request)
    {
        /** 
         * client-side AJAX request send JSON payload in the Request body
         * retrieve the $request using $request->json()
         */


        return response()->json([
            'message' => 'Order created successfully'
        ]);
    }
}
