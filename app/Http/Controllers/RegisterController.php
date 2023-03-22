<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    /** validate and store the user registration */
    public function store(Request $request)
    {
        $userCredentials = $request->validate([
            'name' => ['required'],
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
        return redirect()->route('register.create.address');
    }

    public function createAddress()
    {
        return view('register.create-address');
    }

    public function storeAddress(Request $request)
    {
        /** sometimes | required -> if the field is present, then validation rules are applied */
        $address = $request->validate([
            'street' => 'sometimes | required',   
            'ward' => 'sometimes | required | numeric',
            'township' => 'sometimes | required | alpha',
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
}
