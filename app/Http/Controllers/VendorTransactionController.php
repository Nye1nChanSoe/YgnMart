<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VendorTransactionController extends Controller
{
    use ParseTrait;

    public function index()
    {
        if(request()->filled('search')) {
            $transactions = Transaction::with('order.products')
                ->where('vendor_id', auth()->guard('vendor')->id())
                ->latest()
                ->search($this->parseHyphens(request(['search'])))
                ->paginate(25);

            return view('vendors.transactions.index', compact('transactions'));
        }

        $cache_key = 'vendor:transaction:' . Transaction::count();
        $transactions = Cache::remember($cache_key, '300', function() {
            return Transaction::with('order.products')
                ->where('vendor_id', auth()->guard('vendor')->id())
                ->latest()
                ->paginate(25);
        });

        return view('vendors.transactions.index', compact('transactions'));
    }
}
