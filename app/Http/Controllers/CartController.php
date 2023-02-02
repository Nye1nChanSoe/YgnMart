<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('carts.index', [
            'carts' => Cart::with('product')->where('user_id', auth()->id())->get(),
        ]);
    }

    /** show a specifically added item here */
    public function show(Product $product)
    {
        return view('carts.show', [
            'product' => $product,
        ]);
    }

    public function store()
    {
        
    }
}
