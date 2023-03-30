<x-vendor-layout>
    <x-slot:title>
        {{ $product->name }} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.show', $product->slug) }}" class="{{ request()->routeIs('vendor.products.*') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Current Product</a>
        </li>
    </ul>
    {{-- product info, categories, views, how many time added to carts, purchases, stock info, total reviews, edit, remove --}}
    <section class="px-3 py-3 mt-6 shadow rounded">
        <div class="flex items-center justify-between">
            <div>
                <h1>Product Name</h1>
                <p class="text-gray-700">{{ $product->name }}</p>
            </div>
            <div>
                <div>{{ $product->inventory->status }}</div>
                <time>{{ $product->created_at->format('d M Y') }}</time>
            </div>
        </div>
        <div>
            <h1>Metadata</h1>
            <p class="text-gray-700">{{ $product->meta_type }}</p>
        </div>
        <div>
            <h1>Price</h1>
            <p class="text-gray-700">{{ $product->price }}</p>
        </div>
        <div>
            <h1>Total Reviews</h1>
            <p class="text-gray-700">{{$product->reviews->count()}}</p>
        </div>
        <div>
            <h1>Total Rating Point</h1>
            <p class="text-gray-700">{{ number_format($product->rating_point, 1) }}</p>
        </div>
        <div>
            <h1>Ratings table</h1>
            <table class="table-auto w-full">
                <thead>
                  <tr>
                    <th class="px-4 py-2">Stars</th>
                    <th class="px-4 py-2">Ratings</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($ratings as $rating)
                    <tr>
                        <td class="border px-4 py-2">{{ $rating->stars }}</td>
                        <td class="border px-4 py-2">{{ $rating->count }}</td>
                    </tr>
                @endforeach
                </tbody>
                <caption class="caption-bottom">
                    Table 3.1: Professional wrestlers and their signature moves.
                  </caption>
              </table>
        </div>
        <div>
            <h1>Description</h1>
            <p class="text-gray-700">{{$product->description}}</p>
        </div>

        <h1>Product Stock</h1>
        <div>
            <h1>Total Stock Quantity</h1>
            <div>{{ $product->inventory->in_stock_quantity }}</div>
        </div>
        <div>
            <h1>Minimum Stock Quantity</h1>
            <div>{{ $product->inventory->minimum_quantity }}</div>
        </div>
        <div>
            <h1>Available Stock Quantity</h1>
            <div>{{ $product->available_quantity }}</div>
        </div>

        @if ($product->inventory->is_in_stock)
        <div>
            In Stock
        </div>
        @else
        <div>
            Out of Stock
        </div>
        @endif

    </section>
</x-vendor-layout>