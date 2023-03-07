<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        /** if user try to directly access the route without items in the cart redirect them back to cart menu */
        if(Cart::where('user_id', auth()->id())->get()->isEmpty())
        {
            return redirect()->route('carts.index');
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        $addresses = auth()->user()->addresses;
        return view('checkout.index', compact(['cartItems', 'addresses']));
    }

    public function store(Request $request)
    {
        dd($request->input());
    }
}
