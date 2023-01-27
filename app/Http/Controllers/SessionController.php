<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return redirect()->route('home')->with('success', 'Welcome back, '.auth()->user()->name);
    }

    public function destroy()
    {
        auth()->logout();

        /** remove all the data from current session */
        session()->flush();

        return redirect()->route('login')->with('success', 'Goodbye! See you again');
    }
}
