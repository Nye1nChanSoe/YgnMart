<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Review;
use App\Traits\ParseTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VendorProductController extends Controller
{
    use PhotoUploadTrait, ParseTrait;

    public function index()
    {
        $inventories = Inventory::with('product.categories')
            ->where('vendor_id', auth()->guard('vendor')->id())
            ->latest()
            ->search($this->parseHyphens(request(['search'])))
            ->paginate(25);

        return view('vendors.products.index', compact('inventories'));
    }

    public function show(Product $product)
    {
        $product = $product->load('inventory', 'analytics', 'categories');

        $ratings = Review::totalProductRatings($product);

        /* daily report data */
        $analytics = $product->analytics()->filter('day')->get();

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
            'image' => 'required|image|mimes:jpeg,png,webp,svg,jpg|max:2048|dimensions:max_width=2000,max_height=2000', // Maximum file size of 2 MB, maximum dimensions of 2000x2000 pixels, and only JPEG and PNG files allowed
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
            'image' => 'required|image|mimes:jpeg,png,webp,svg,jpg|max:2048|dimensions:max_width=2000,max_height=2000', // Maximum file size of 2 MB, maximum dimensions of 2000x2000 pixels, and only JPEG and PNG files allowed
        ]);

        /** create inventory record first */
        $inventoryData['sku'] = 'YM-' . strtoupper(uniqid());
        $inventoryData['vendor_id'] = auth()->guard('vendor')->id();
        $inventoryData['available_quantity'] = $inventoryData['in_stock_quantity'] - $inventoryData['minimum_quantity'];
        $inventoryData['is_in_stock'] = $inventoryData['available_quantity'] > 0;
        $inventory = Inventory::create($inventoryData);

        /** product data second */
        $productData['image'] = $this->upload($productData['image']);
        $productData['slug'] = strtolower(str_replace([' ', '_'], '-', $productData['name']));
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
        $product = $product->load(['inventory', 'categories']);
        $categories = Category::all();

        return view('vendors.products.edit', compact(['product', 'categories']));
    }

    public function update(Request $request, Product $product)
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
            'image' => 'image|mimes:jpeg,png,webp,svg,jpg|max:2048|dimensions:max_width=2000,max_height=2000', // Maximum file size of 2 MB, maximum dimensions of 2000x2000 pixels, and only JPEG and PNG files allowed
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
            'image' => 'image|mimes:jpeg,png,webp,svg,jpg|max:2048|dimensions:max_width=2000,max_height=2000', // Maximum file size of 2 MB, maximum dimensions of 2000x2000 pixels, and only JPEG and PNG files allowed
        ]);

        $availableQuantity = $inventoryData['in_stock_quantity'] - $inventoryData['minimum_quantity'];
        $inventoryData['available_quantity'] = $availableQuantity;
        $inventoryData['is_in_stock'] = $availableQuantity > 0;

        if($productData['image'] ?? false)
        {
            $productData['image'] = $this->upload($productData['image']);
        }
        $product->inventory->update($inventoryData);
        $product->update($productData);
        $categories = Category::whereIn('sub_type', $request->input('sub_type'))->get();

        $product->categories()->sync($categories);

        return redirect()->route('vendor.products.show', $product->slug)->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('vendor.products')->with('success', 'Product removal request successfully send');
    }
}
