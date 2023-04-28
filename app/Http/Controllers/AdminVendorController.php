<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function show(Vendor $vendor)
    {
        return view('admins.vendors.show', compact('vendor'));
    }

    protected function update(Request $request, Vendor $vendor)
    {
        $updatedInfo = $request->validate([
            'username' => ['required', Rule::unique('vendors', 'username')->ignore($vendor->id), 'max:18', 'regex:/^[a-zA-Z0-9_]+$/'],       // alphanumeric and underscore only
            'brand' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('vendors', 'email')->ignore($vendor->id)],
            'phone_number' => ['required', Rule::unique('vendors', 'phone_number')->ignore($vendor->id), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        $vendor->update($updatedInfo);

        return redirect()->route('admin.vendors.show', $vendor->username)
            ->with('success', "Vendor {$vendor->brand} updated");
    }

    public function destroy(Request $request, Vendor $vendor)
    {
        if(!Hash::check($request->input('password'), auth()->user()->password)) {
            return back()->with('error', 'Incorrect password');
        }

        $vendor->delete();
        return redirect()->route('admin.vendors')->with('success', "Vendor {$vendor->brand} removed");
    }

    public function verify(Vendor $vendor)
    {
        $vendor->update(['is_verified' => true]);
        return back()->with('success', "Vendor {$vendor->brand} verified");
    }
}
