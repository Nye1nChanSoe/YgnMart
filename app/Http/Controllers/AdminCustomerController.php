<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminCustomerController extends Controller
{
    use ParseTrait;

    public function index()
    {
        $customers = Cache::remember('admin:customer', '300', function() {
            return User::with('addresses')
            ->latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);
        });

        return view('admins.customers.index', compact('customers'));
    }
}
