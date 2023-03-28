<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return view('vendors.index');
    }

    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact($vendor));
    }
}
