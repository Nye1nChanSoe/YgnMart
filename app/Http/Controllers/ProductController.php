<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Traits\parseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use parseTrait;

    public function index()
    {
        $filteredQuery = Product::oldest()->filter($this->parseHyphens(request(['search', 'category'])));
        
        $products = $filteredQuery->paginate(5)->withQueryString();

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
        $cart = Cart::where('user_id', auth()->id())->where('product_id', $product->id);

        if($cart->exists())
        {
            $quantity = $cart->first()->quantity;
            $cart->update(['quantity'=> $request->quantity + $quantity]);
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
