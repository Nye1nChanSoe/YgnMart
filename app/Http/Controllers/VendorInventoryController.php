<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VendorInventoryController extends Controller
{
    use ParseTrait;

    public function index()
    {
        if(request()->filled('search')) {
            $inventories = Inventory::with('product')
                ->where('vendor_id', auth()->guard('vendor')->id())
                ->latest()
                ->search($this->parseHyphens(request(['search'])))
                ->paginate(25);

            return view('vendors.inventories.index', compact('inventories'));
        }

        $cache_key = 'vendor:inventory:' . Inventory::count();
        $inventories = Cache::remember($cache_key, '300', function() {
            return Inventory::with('product')
                ->where('vendor_id', auth()->guard('vendor')->id())
                ->latest()
                ->paginate(25);
        });

        return view('vendors.inventories.index', compact('inventories'));
    }
}
