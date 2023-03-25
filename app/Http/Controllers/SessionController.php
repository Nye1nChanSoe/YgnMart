<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!auth()->attempt($credentials))
        {
            /**
             * withInput() -> store array of inputs for the next session so old() helper can be used
             * withErrors() -> add error message to the errors bag
             */
            return back()->withInput()->withErrors(['email' => 'Credentials could not be verified']);
        }
        
        /** generate a new session id to protect against session fixation */
        session()->regenerate();
        auth()->user()->update(['user_status' => 'active']);
        return redirect()->route('home')
            ->with('success', 'Welcome back, '.auth()->user()->name);
    }

    public function destroy()
    {
        auth()->user()->update(['user_status' => 'inactive']);
        auth()->logout();

        /** remove all the data from current session */
        session()->flush();

        return redirect()->route('login')
            ->with('success', 'Goodbye! See you again');
    }

    public function vcreate()
    {
        return view('sessions.vendors.create');
    }

    public function vstore(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!Auth::guard('vendor')->attempt($credentials))
        {
            return back()->withInput()->withErrors(['email' => 'Credentials could not be verified']);
        }

        session()->regenerate();
        auth()->guard('vendor')->user()->update(['status' => 'active']);

        return redirect()->route('vendor.dashboard')->with('success', 'Welcome, ' . auth()->guard('vendor')->user()->name);
    }

    public function vdestroy()
    {
        auth()->guard('vendor')->user()->update(['status' => 'inactive']);
        auth()->guard('vendor')->logout();

        session()->flush();

        return redirect()->route('vendor.login')->with('success', 'Thank you for using our platform');
    }
}
