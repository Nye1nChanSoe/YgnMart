<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Models\Vendor;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use PhotoUploadTrait;

    public function create()
    {
        return view('register.create');
    }

    /** validate and store the user registration */
    public function store(Request $request)
    {
        $userCredentials = $request->validate([
            'name' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone_number' => ['required', Rule::unique('users', 'phone_number'), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        /** created accounts are user by default */
        $userCredentials['username'] = strtolower(str_replace([' ', '-'], '', $userCredentials['name'])) . '_' . strtolower(Str::random('3'));
        $userCredentials['role'] = 'user';
        $userCredentials['user_status'] = 'active';

        $user = User::create($userCredentials);

        auth()->login($user);
        return view('register.create-address');
    }

    public function storeAddress(Request $request)
    {
        /** sometimes | required -> if the field is present, then validation rules are applied */
        $address = $request->validate([
            'street' => 'sometimes | required | max:32',   
            'ward' => 'sometimes | required | numeric',
            'township' => 'sometimes | required | alpha | max:20',
        ]);

        $address['user_id'] = auth()->id();

        /** If the user submits address for the first time */
        if(!Address::where('user_id', auth()->id())->exists())
        {
            $address['is_default'] = true;
            $address['label'] = 'home';
        }

        Address::create($address);

        return redirect()->route('home')->with('success', 'Welcome, ' . auth()->user()->name);
    }

    public function skipAddress()
    {
        return redirect()->route('home')->with('success', 'Welcome, ' . auth()->user()->name);
    }

    public function vcreate()
    {
        return view('register.vendors.create');
    }

    public function vstore(Request $request)
    {
        $vendorCredentials = $request->validate([
            'brand' => ['max:32'],
            'email' => ['required', 'email', Rule::unique('vendors', 'email')],
            'phone_number' => ['required', Rule::unique('vendors', 'phone_number'), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if(empty($vendorCredentials['brand']))
        {
            $vendorCredentials['brand'] = 'Local brand';
        }

        /** verified in admin panel */
        $vendorCredentials['is_verified'] = false;
        $vendorCredentials['username'] = 'v_' . strtolower(str_replace([' ', '-'], '_', $request->name) . '_' . Str::random(3));

        $vendor = Vendor::create($vendorCredentials);
        auth()->guard('vendor')->login($vendor);

        return redirect()->route('vendor.dashboard')->with('success', 'Welcome, ' . auth()->guard('vendor')->user()->name);
    }
}
