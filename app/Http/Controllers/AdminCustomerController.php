<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $customers = User::with('addresses')
            ->latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);

        return view('admins.customers.index', compact('customers'));
    }
}
