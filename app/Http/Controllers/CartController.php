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
            'carts' => Cart::with('product')->where('user_id', auth()->id())->orderBy('created_at', 'asc')->get(),
        ]);
    }

    /** show a specifically added item here */
    public function show(Product $product)
    {
        return view('carts.show', [
            'product' => $product,
        ]);
    }

    public function destroy(Cart $cart)
    {
        // Can add more functionalities like recently added items 
        // Add this cart item to the recently added items before deletion

        $cart->delete();
        
        $quantity = $cart->quantity;
        $totalPrice = $cart->product->price * $quantity;
        $count = Cart::where('user_id', auth()->id())->count();

        return response()->json([
            'message' => 'Item removed from the cart', 
            'totalPrice' => $totalPrice, 
            'quantity' => $quantity, 
            'count' => $count,
        ]);
    }


    // TODO: Add Stripe
    public function checkout()
    {

    }
}
