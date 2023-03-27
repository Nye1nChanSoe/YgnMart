<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function index()
    {
        return view('products.vendors.index');
    }

    public function show(Product $product)
    {
        return view('products.vendors.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.vendors.edit', compact('product'));
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
