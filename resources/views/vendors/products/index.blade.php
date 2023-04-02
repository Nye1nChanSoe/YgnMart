<x-vendor-layout>
    <x-slot:title>
        Manage products - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-black font-medium">Product Catalogue</h1>
            <div class="flex items-center gap-x-4">
                <a href="{{ route('vendor.products.create') }}" class="px-3 py-2 text-white rounded-lg bg-blue-500 hover:bg-blue-700">Add New Product</a>
                @unless ($inventories->isEmpty())
                <a href="{{ route('vendor.inventories') }}" class="px-3 py-2 text-white rounded-lg bg-blue-500 hover:bg-blue-700">Manage Inventories</a>
                @endif
            </div>
        </div>
        @unless ($inventories->isEmpty())
        <header class="grid grid-cols-9 items-center justify-items-center text-sm py-2 bg-gray-600 rounded text-white font-medium md:grid-cols-9">
            <h1 class="col-span-1">No</h1>
            <h1 class="col-span-2">Product</h1>
            <h1 class="col-span-1">Price</h1>
            <h1 class="col-span-1">Type</h1>
            <h1 class="col-span-1">Rating</h1>
            <h1 class="col-span-1">Status</h1>
            <h1 class="col-span-2">Date</h1>
        </header>
            @foreach ($inventories as $inventory)
            <a href="{{ route('vendor.products.show', $inventory->product->slug) }}" class="grid grid-cols-9 even:bg-gray-100 items-center text-sm justify-items-center rounded py-1 text-gray-700 hover:bg-gray-200 md:grid-cols-9">
                <div class="col-span-1">{{ ($inventories->currentPage() - 1) * $inventories->perPage() + $loop->iteration }}</div>
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
                <div class="col-span-1">{{ number_format($inventory->product->price, 0, '.', ',') }}<span class="ml-1.5 text-xs text-gray-400">Kyat</span></div>
                <div class="col-span-1"><span class="text-gray-600">{{ $inventory->product->meta_type }}</span></div>

                @if ($inventory->product->rating_point >= 3)
                <div class="col-span-1 text-lime-600">{{ number_format($inventory->product->rating_point, 1) }}</div>
                @elseif($inventory->product->rating_point > 0 && $inventory->product->rating_point < 3)
                <div class="col-span-1 text-orange-600">{{ number_format($inventory->product->rating_point, 1) }}</div>
                @else
                <div class="col-span-1 text-gray-400">{{ number_format($inventory->product->rating_point, 1) }}</div>
                @endif

                @if ($inventory->status == 'sell')
                <div class="bg-green-600 rounded-lg text-white px-1.5 py-1">Selling</div>
                @else
                <div class="bg-gray-600 rounded-lg text-white px-1.5 py-1">Closed</div>
                @endif

                <div class="col-span-2">
                    <div class="flex items-center gap-x-2">
                        <time>{{\Carbon\Carbon::parse($inventory->product->updated_at)->format('M j, Y')}}</time>
                        <time>{{\Carbon\Carbon::parse($inventory->product->updated_at)->format('g:i A')}}</time>
                    </div>
                </div>
            </a>
            @endforeach
            <div class="text-sm mt-4">
                {{ $inventories->links('vendor.pagination.links') }}
            </div>
        @else
        <div class="flex items-center justify-center w-full h-60">
            <p class="text-gray-400">You do not have any listed product!</p>
        </div>
        @endunless
    </section>
</x-vendor-layout>