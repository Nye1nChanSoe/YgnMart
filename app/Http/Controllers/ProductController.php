<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Review;
use App\Traits\ParseTrait;
use App\Traits\ProductAnalyticTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ParseTrait, ProductAnalyticTrait;

    public function index(Request $request)
    {
        /**
         * Eager loaded Models: reviews, inventory.vendor
         * Eager load or left join the model reviews
         * Dot notation to eager load the nested relationship like vendor
         */
        if(request()->filled('search') || request()->filled('category') || request()->filled('seller')) {
            $filteredQuery = Product::with(['reviews', 'inventory.vendor'])
                ->whereHas('inventory', fn($query) => $query
                    ->where('status', 'sell'))
                ->latest()
                ->filter($this->parseHyphens(request(['search', 'category', 'seller'])));
            $products = $filteredQuery->paginate(20)->withQueryString();

            return view('products.search', compact('products'));
        }

        $cache_key = 'product:' . Product::count();
        $recentProducts = $this->recentlyAdded($request, $cache_key);
        $foodProducts = $this->foodProducts($request, $cache_key);
        $drinkProducts = $this->drinkProducts($request, $cache_key);
        $householdProducts = $this->householdProducts($request, $cache_key);

        return view('products.index', compact([
            'recentProducts',
            'foodProducts',
            'drinkProducts',
            'householdProducts'
        ]));
    }

    public function show(Product $product)
    {
        $ratings = Review::totalProductRatings($product);

        $relatedProducts = Product::with('reviews')->relatedProducts($product)->get();

        $this->dailyProductStats($product, 'view');

        /** load related models on a specific instance */
        $product->load(['inventory.vendor']);

        return view('products.show',compact('product', 'ratings', 'relatedProducts'));
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

        $this->dailyProductStats($product, 'cart');

        return redirect()->route('carts.show', ['product' => $product]);
    }

    public function review(Request $request, Product $product)
    {
        /** user cannot review a single product twice, validate on the client side */
        if($product->reviews()->where('user_id', auth()->id())->where('product_id', $product->id)->exists())
        {
            return response()->json([
                'message' => 'error'
            ]);
        }

        $review = new Review();
        $review->user_id = auth()->id();
        $review->product_id = $product->id;
        $review->rating = $request->json('rating');
        $review->comment = $request->json('comment');
        $review->save();

        // $ratings = DB::select(DB::raw('SELECT stars_table.stars, COALESCE(COUNT(reviews.rating), 0) AS count
        //     FROM (
        //         SELECT 1 AS stars UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
        //         ) AS stars_table
        //     LEFT OUTER JOIN reviews ON stars_table.stars = reviews.rating 
        //     AND reviews.product_id = '.$product->id.'
        //     GROUP BY stars_table.stars'));

        $ratings = Review::totalProductRatings($product);


        $this->dailyProductStats($product, 'review');

        return response()->json([
            'message' => 'success',
            'ratings' => $ratings,
            'user' => [
                'name' => auth()->user()->name,
                'image' => asset('storage/images/'.auth()->user()->image),
            ],
            'comment' => request()->json('comment'),
        ]);
    }

    public function suggestions(Request $request)
    {
        /** query 10 new products per request */
        $count = 10;
        $page = $request->query('page');

        /** query amount */
        $total = $count * $page;

        try 
        {
            $product = Product::find($request->query('product'));
            $relatedProducts = Product::relatedProducts($product, $total)->get();
        } 
        catch (ModelNotFoundException $e) 
        {
            Log::error('Product Not Found: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json($relatedProducts);
    }

    /**
     * TODO: can use database triggers to calculate the rating_point for each product everytime a review table has been updated or deleted.
     */
    public function update(Request $request, Product $product)
    {
        $product->update(['rating_point' => $request->json('point')]);
        return response()->json(['message' => 'success']);
    }

    /**
     * Query most recent items from the product catelogue
     * 
     * @param Request $request
     * @param int  $key - cache key
     * @return Product $products 
     */
    protected function recentlyAdded(Request $request, $key)
    {
        $cache_key = 'recentProduct:' . $key;
        $products = Cache::remember($cache_key, '300', function() {
            return Product::with(['reviews', 'inventory.vendor'])
                ->whereHas('inventory', fn($query) => $query
                    ->where('status', 'sell'))
                ->latest()
                ->limit(30)
                ->get();
        });
        return $products;
    }

    /**
     * Query food related products from the product catelogue
     * 
     * @param Request $request
     * @param int  $key - cache key
     * @return Product $products 
     */
    protected function foodProducts(Request $request, $key)
    {
        $cache_key = 'foodProduct:' . $key;
        $products = Cache::remember($cache_key, '300', function() {
            return Product::with(['reviews', 'inventory.vendor'])
                ->whereHas('inventory', fn($query) => $query
                    ->where('status', 'sell'))
                ->whereHas('categories', fn($query) => $query
                    ->where('type', 'Food'))
                ->inRandomOrder()
                ->get();
        });
        return $products;
    }

    /**
     * Query drinks related products from the product catelogue
     * 
     * @param Request $request
     * @param int  $key - cache key
     * @return Product $products 
     */
    protected function drinkProducts(Request $request, $key)
    {
        $cache_key = 'drinkProduct:' . $key;
        $products = Cache::remember($cache_key, '300', function() {
            return Product::with(['reviews', 'inventory.vendor'])
                ->whereHas('inventory', fn($query) => $query
                    ->where('status', 'sell'))
                ->whereHas('categories', fn($query) => $query
                    ->where('type', 'Drinks'))
                ->inRandomOrder()
                ->get();
        });
        return $products;
    }

    /**
     * Query household related products from the product catelogue
     * 
     * @param Request $request
     * @param int  $key - cache key
     * @return Product $products 
     */
    protected function householdProducts(Request $request, $key)
    {
        $cache_key = 'householdProduct:' . $key;
        $products = Cache::remember($cache_key, '300', function() {
            return Product::with(['reviews', 'inventory.vendor'])
                ->whereHas('inventory', fn($query) => $query
                    ->where('status', 'sell'))
                ->whereHas('categories', fn($query) => $query
                    ->where('type', 'Households'))
                ->inRandomOrder()
                ->get();
        });
        return $products;
    }
}
