<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminVendorController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $vendors = Cache::remember('admin:vendor', '300', function() {
            return Vendor::with('inventories')
            ->latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);
        });

        return view('admins.vendors.index', compact('vendors'));
    }
}
