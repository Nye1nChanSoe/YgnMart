<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Traits\ParseTrait;
use Illuminate\Support\Facades\Cache;

class vendorOrdersController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $transactions = Transaction::with('order.products')
            ->where('vendor_id', auth()->guard('vendor')->id())
            ->latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);

        return view('vendors.orders.index', compact('transactions'));
    }
}
