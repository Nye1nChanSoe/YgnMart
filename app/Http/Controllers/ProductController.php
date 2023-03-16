<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Traits\parseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $ratings = DB::select(DB::raw('SELECT stars_table.stars, COALESCE(COUNT(reviews.rating), 0) AS count
                    FROM (
                        SELECT 1 AS stars UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
                        ) AS stars_table
                    LEFT OUTER JOIN reviews ON stars_table.stars = reviews.rating 
                    AND reviews.product_id = '.$product->id.'
                    GROUP BY stars_table.stars'));

        return view('products.show',compact('product', 'ratings'));
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

    public function review(Request $request, Product $product)
    {
        if($product->reviews()->wherePivot('user_id', auth()->id())->exists())
        {
            return response()->json([
                'message' => 'error'
            ]);
        }

        $product->reviews()->attach(auth()->id(), [
            'rating' => $request->json('rating'),
            'comment' => $request->json('comment'),
        ]);

        $ratings = DB::select(DB::raw('SELECT stars_table.stars, COALESCE(COUNT(reviews.rating), 0) AS count
            FROM (
                SELECT 1 AS stars UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
                ) AS stars_table
            LEFT OUTER JOIN reviews ON stars_table.stars = reviews.rating 
            AND reviews.product_id = '.$product->id.'
            GROUP BY stars_table.stars'));

        return response()->json([
            'message' => 'success',
            'ratings' => $ratings,
            'user' => [
                'name' => auth()->user()->name,
                'image' => auth()->user()->image,
            ],
            'comment' => request()->json('comment'),
        ]);
    }
}
