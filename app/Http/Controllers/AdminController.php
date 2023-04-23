<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /** dashboard */
    public function index()
    {
        // TODO: show daily active users, both unique as well as non-unique amount,
        // TODO: show user specific details,
        // TODO: show daily product sales,

        return view('admins.index');
    }
}
