<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /** dashboard */
    public function index()
    {
        return view('vendors.index');
    }

    /** profile */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact($vendor));
    }
}
