<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class VendorInventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('product')
            ->where('vendor_id', auth()->guard('vendor')->id())
            ->latest()
            ->get();

        return view('vendors.inventories.index', compact('inventories'));
    }
}
