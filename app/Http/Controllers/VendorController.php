<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductAnalytic;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /** dashboard */
    public function index()
    {
        $vendorId = auth()->guard('vendor')->id();

        $transactions = Transaction::with('order.products')
            ->where('vendor_id', $vendorId)
            ->latest()
            ->get();

        /** daily transactions for vendor account */
        $data = Transaction::filter('day')->get();
        $transactionData = $data->pluck('revenue', 'day');

        /* daily report data */
        $analytics = ProductAnalytic::filter('day')->get();
        $viewData = $analytics->pluck('view', 'day');              // day => view  key:value pair
        $cartData = $analytics->pluck('cart', 'day');
        $checkoutData = $analytics->pluck('checkout', 'day');
        $orderData = $analytics->pluck('order', 'day');
        $quantityData = $analytics->pluck('quantity', 'day');

        /** orders and products */
        return view('vendors.index', compact([
            'transactions',
            'transactionData',
            'viewData',
            'cartData',
            'checkoutData',
            'orderData',
            'quantityData',
        ]));
    }

    /** profile */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact($vendor));
    }

    public function edit()
    {
        return 'moo';
    }
}
