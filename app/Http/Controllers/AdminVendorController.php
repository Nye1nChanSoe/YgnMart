<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $vendors = Vendor::with('inventories')
            ->latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);

        return view('admins.vendors.index', compact('vendors'));
    }
}
