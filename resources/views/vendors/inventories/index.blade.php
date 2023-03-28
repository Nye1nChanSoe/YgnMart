<x-vendor-layout>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.inventories') }}" class="{{ request()->routeIs('vendor.inventories') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Inventories</a>
        </li>
    </ul>
    <section class="mt-4 px-3 py-3 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-black font-medium">Stock Control</h1>
        </div>
        <header class="grid grid-cols-9 items-center justify-items-center text-sm py-2 text-center bg-gray-600 rounded text-white font-medium md:grid-cols-9">
            <h1 class="col-span-1">No</h1>
            <h1 class="col-span-2">Product</h1>
            <h1 class="col-span-1">Total Quantity</h1>
            <h1 class="col-span-1">Minimum Threshold</h1>
            <h1 class="col-span-1">Qty Available</h1>
            <h1 class="col-span-1">Stock Status</h1>
            <h1 class="col-span-2">Date</h1>
        </header>
        @foreach ($inventories as $index => $inventory)
        <a href="" class="grid grid-cols-9 even:bg-gray-100 items-center text-sm justify-items-center rounded py-1 text-gray-700 hover:bg-gray-200 md:grid-cols-9">
            <div class="col-span-1">{{ $index + 1 }}</div>
            <div class="col-span-2">
                <div class="flex items-center gap-x-4">
                    <div class="flex flex-shrink-0 items-center w-10 h-10 rounded-full overflow-hidden">
                        <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full object-contain">
                    </div>
                    <div class="w-32 overflow-hidden lg:w-40">
                        <p class="truncate">{{ $inventory->product->name }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-1">{{ number_format($inventory->in_stock_quantity, 0, '.', ',') }}</div>
            <div class="col-span-1">{{ $inventory->minimum_quantity }}</div>

            <div class="font-medium">{{ number_format($inventory->available_quantity, 0, '.', ',') }}</div>
            
            @if ($inventory->in_stock)
            <div class="bg-green-600 rounded-lg text-white px-1.5 py-1">In Stock</div>
            @elseif($inventory->low_stock)
            <div x-data="{open:false}" x-on:mouseenter="open=true" x-on:mouseleave="open=false" class="relative bg-orange-400 rounded-lg text-white px-1.5 py-1">
                <span>Low Stock</span>
                <div x-show="open" class="absolute w-60 top-7 right-0 bg-white z-10 text-gray-700 px-2 py-1.5 rounded-lg shadow">
                    <p class="text-sm text-center">Available quantity is less than <span class="font-medium">200</span></p>
                </div>
            </div>
            @else
            <div class="bg-red-600 rounded-lg text-white px-1.5 py-1">Out of Stock</div>
            @endif

            <div class="col-span-2">
                <div class="flex items-center gap-x-2">
                    <time>{{\Carbon\Carbon::parse($inventory->updated_at)->format('M j, Y')}}</time>
                    <time>{{\Carbon\Carbon::parse($inventory->updated_at)->format('g:i A')}}</time>
                </div>
            </div>
        </a>
        @endforeach
    </section>
</x-vendor-layout>