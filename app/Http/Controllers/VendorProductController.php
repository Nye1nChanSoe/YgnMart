<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

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

        $inventoryData = $request->validate([
            'in_stock_quantity' => ['required', 'numeric', 'min:100'],
            'minimum_quantity' => ['required', 'numeric', 'min:50'],
            'status' => ['required'],
        ]);

        $productData['slug'] = strtolower(str_replace([' ', '_'], '-', $request->input('name')));
        $product = Product::create($productData);

        $categories = Category::whereIn('sub_type', $request->input('sub_type'))->get();

        /** add one or more records to the intermediate table */
        $product->categories()->attach($categories);

        /** create inventory record as well */
        $inventoryData['vendor_id'] = auth()->guard('vendor')->id();
        $inventoryData['product_id'] = $product->id;
        $inventoryData['available_quantity'] = $inventoryData['in_stock_quantity'] - $inventoryData['minimum_quantity'];
        $inventoryData['is_in_stock'] = $inventoryData['available_quantity'] <= 0;

        Inventory::create($inventoryData);

        return redirect()->route('vendor.products')->with('success', 'New Product added!');
    }

    public function show(Product $product)
    {
        return view('vendors.products.show', compact('product'));
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
