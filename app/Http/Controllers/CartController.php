<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        /** AJAX request so send JSON respond back to the client */
        return response()->json([
            'message' => 'Item removed from the cart', 
            'totalPrice' => $totalPrice, 
            'quantity' => $quantity, 
            'count' => $count,
        ]);
    }

    /** can add to transition table for analytics in this method */
    public function checkout(Request $request)
    {
        /**
         * the first argument, single array with the 'user_id' attribute is used to search for its value in database.
         * If exists, it will be updated with the second argument, 
         * If it's not exists, a new record will be created using both arguments 'user_id' and 'total_price'
         */
        Checkout::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'total_price' => $request->input('total_amount'),
            ]
        );

        return redirect()->route('checkout.index');
    }
}
