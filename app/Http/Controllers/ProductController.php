<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::oldest()
            ->filter(request('search'))
            ->get();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product,
            'categories' => $product->categories,
        ]);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product);

        if(Cart::where('product_id', $product->id)->exists())
        {
            $quantity = Cart::where('product_id', $product->id)->first()->quantity;
            Cart::where('product_id', $product->id)->update(['quantity'=> $request->quantity + $quantity]);
        }
        else 
        {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('carts.show', ['product' => $product]);
    }
}
