<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorProductController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('product')
            ->where('vendor_id', auth()->guard('vendor')->id())
            ->latest()
            ->get();

        return view('vendors.products.index', compact('inventories'));
    }

    public function show(Product $product)
    {
        $product = $product->load('inventory', 'analytics');

        $ratings = DB::table(DB::raw('(SELECT 1 AS stars UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) AS stars_table'))
            ->leftJoin('reviews', function($join) use ($product) {
                $join->on('stars_table.stars', '=', 'reviews.rating')
                    ->where('reviews.product_id', '=', $product->id);
            })
            ->select(DB::raw('stars_table.stars, COALESCE(COUNT(reviews.rating), 0) AS count'))
            ->groupBy('stars_table.stars')
            ->get();

        /* daily report data */
        $analytics = $product->analytics()
            ->select(DB::raw('DATE_FORMAT(date, "%d %b") as day'),
                DB::raw('SUM(view) as view'),
                DB::raw('SUM(cart) as cart'),
                DB::raw('SUM(checkout) as checkout'),
                DB::raw('SUM(`order`) as `order`'),
                DB::raw('SUM(review) as review'),
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('SUM(revenue) as revenue'))
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();
        
        $viewData = $analytics->pluck('view', 'day');              // day => view  key:value pair
        $cartData = $analytics->pluck('cart', 'day');              
        $checkoutData = $analytics->pluck('checkout', 'day');      
        $orderData = $analytics->pluck('order', 'day');            
        $reviewData = $analytics->pluck('review', 'day');        
        $quantityData = $analytics->pluck('quantity', 'day');      
        $revenueData = $analytics->pluck('revenue', 'day');
        
        return view('vendors.products.show', compact([
            'product',
            'ratings',
            'viewData',
            'cartData',
            'checkoutData',
            'orderData',
            'reviewData',
            'quantityData',
            'revenueData',
        ]));
    }

    public function create()
    {
        $categories = Category::all();
        return view('vendors.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'meta_type' => ['required', 'max:50'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'type' => ['required'],
            'sub_type' => ['required', 'array'],
            'sub_type.*' => ['required'],
            'in_stock_quantity' => ['required', 'numeric', 'min:100'],
            'minimum_quantity' => ['required', 'numeric', 'min:50'],
            'status' => ['required'],
        ]);

        $inventoryData = $request->validate([
            'in_stock_quantity' => ['required', 'numeric', 'min:100'],
            'minimum_quantity' => ['required', 'numeric', 'min:50'],
            'status' => ['required'],
        ]);

        $productData = $request->validate([
            'name' => ['required', 'max:255'],
            'meta_type' => ['required', 'max:50'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg']
        ]);

        $request->validate([
            'type' => ['required'],
            'sub_type' => ['required', 'array'],
            'sub_type.*' => ['required'],
        ]);

        
        /** create inventory record first */
        $inventoryData['sku'] = 'YM-' . strtoupper(uniqid());
        $inventoryData['vendor_id'] = auth()->guard('vendor')->id();
        $inventoryData['available_quantity'] = $inventoryData['in_stock_quantity'] - $inventoryData['minimum_quantity'];
        $inventoryData['is_in_stock'] = $inventoryData['available_quantity'] <= 0;
        $inventory = Inventory::create($inventoryData);

        /** product data second */
        $productData['slug'] = strtolower(str_replace([' ', '_'], '-', $request->input('name')));
        $productData['inventory_id'] = $inventory->id;
        $product = Product::create($productData);

        /** categories third */
        $categories = Category::whereIn('sub_type', $request->input('sub_type'))->get();

        /** add one or more records to the intermediate table */
        $product->categories()->attach($categories);

        return redirect()->route('vendor.products')->with('success', 'New Product added!');
    }

    public function edit(Product $product)
    {
        return view('vendors.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        return redirect()->route('vendor.products')->with('success', 'You have updated your product successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('vendor.products')->with('success', 'Product removal request successfully send');
    }

}
