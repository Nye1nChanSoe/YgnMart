<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'username' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')],
        ]);

        // TODO: 
        $address = $request->validate([
            'street' => [''],
        ]);

        /** created accounts are user by default */
        $userCredentials['role'] = 'user';
        $user = User::create($userCredentials);

        auth()->login($user);
        return redirect()->route('home')->with('success', 'Welcome '.$userCredentials['name']);
    }
}
