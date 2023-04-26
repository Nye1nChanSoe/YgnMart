<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductAnalytic;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /** dashboard */
    public function index()
    {
        $vendorId = auth()->guard('vendor')->id();

        $transactions = Cache::remember('vendor:dashboard:transaction', '300', function() use ($vendorId)  {
            return Transaction::with('order.products')
            ->where('vendor_id', $vendorId)
            ->latest()
            ->get();
        });

        /** daily transactions for vendor account */
        $data = Cache::remember('vendor:dashboard:transactionAnalytic', '300', function() {
            return Transaction::filter('day')->get();
        });

        $transactionData = $data->pluck('revenue', 'day');

        /* daily report data */
        $analytics = Cache::remember('vendor:dashboard:productAnalytic', '300', function() {
            return ProductAnalytic::filter('day')->get();
        });

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
        return view('vendors.show', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $update_type = $request->input('update_type');

        if($update_type == 'info')
        {
            return $this->updateInfo($request, $vendor);
        }

        if($update_type == 'password')
        {
            return $this->updatePassword($request, $vendor);
        }
    }

    protected function updateInfo(Request $request, Vendor $vendor)
    {
        $updatedInfo = $request->validate([
            'username' => ['required', Rule::unique('vendors', 'username')->ignore($vendor->id), 'max:18', 'regex:/^[a-zA-Z0-9_]+$/'],       // alphanumeric and underscore only
            'brand' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('vendors', 'email')->ignore($vendor->id)],
            'phone_number' => ['required', Rule::unique('vendors', 'phone_number')->ignore($vendor->id), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        $vendor->update($updatedInfo);

        return redirect()->route('vendor.show', $vendor->username)
            ->with('success', 'Your profile has been updated successfully');
    }

    protected function updatePassword(Request $request, Vendor $vendor)
    {
        $updatedPassword = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        
        if (!Hash::check($request->input('old_password'), $vendor->password)) {
            return back()->withInput()->withErrors(['old_password' => 'Incorrect password']);
        }
        
        // If old password is correct, update the user's password
        $vendor->password = $updatedPassword['password'];
        $vendor->save();
        
        return redirect()->route('vendor.show', $vendor->username)
            ->with('success', 'Password updated successfully');
    }
}
