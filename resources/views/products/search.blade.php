<x-layout>
    {{-- hero / carousel --}}
    @include('partials._carousel')

    <section class="pt-6 pb-10 dark:bg-gray-900">
        <x-container class="px-2 md:px-6">
            <ul class="flex items-center my-3 py-3">
                <li class="flex items-center gap-x-1">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-700 dark:text-gray-400 dark:hover:text-blue-500">Home</a><x-icon name="chevron-right" class="dark:text-gray-200" />
                </li>
                @if (request()->filled('category'))
                <li class="flex items-center ml-2 gap-x-1">
                    <a href="{{ route('home') }} . '?category=' . {{ request('category') }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-500">{{ ucwords(request('category')) }}</a>
                </li>
                @endif
                @if (request()->filled('search'))
                <li class="flex items-center ml-2 gap-x-1">
                    <a href="{{ route('home') }} . '?search=' . {{ request('search') }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-500">{{ ucwords(request('search')) }}</a>
                </li>
                @endif
                @if (request()->filled('seller'))
                <li class="flex items-center ml-2 gap-x-1">
                    <a href="{{ route('home') }} . '?seller=' . {{ request('seller') }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-500">{{ ucwords(str_replace('-', ' ', request('seller'))) }}</a>
                </li>
                @endif
            </ul>
            <div class="mb-6">
                {{ $products->links('vendor.pagination.result') }}
            </div>

            @if (!$products->isEmpty())
            <div class="grid grid-cols-2 gap-x-2 gap-y-4 text-gray-700 md:grid-cols-3 lg:grid-cols-5 3xl:grid-cols-6">
                @foreach ($products as $product)
                <x-product-card class="border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" :product="$product">
                    <x-product-review :product="$product" class="justify-center mb-2.5" />
                    <div class="flex items-center justify-center h-24 md:h-32">
                        @if ($product->image)
                        <img src="{{ asset('storage/images/'.$product->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                        @else
                        {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                        <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                        @endif
                    </div>
                    {{-- name and stock --}}
                    <div>
                        <h3 class="font-semibold  hover:text-blue-600">
                            <p><a href="/products/{{$product->slug}}">{{$product->name}}</a></p>
                        </h3>
                    </div>

                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-gray-800 font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                    </div>
                    <div class="flex items-center gap-x-1.5">
                        @if ($product->inventory->available_quantity >= 100)
                        <div>
                            <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs dark:bg-blue-600">In stock</span>
                        </div>
                        @elseif($product->inventory->available_quantity == 0)
                        <div x-data="{open:false}" class=" relative">
                            <span x-on:mouseover="open=true" x-on:mouseleave="open=false" class="cursor-pointer px-1.5 py-1 rounded-lg bg-red-500 text-white ml-1.5 text-xs">Out of stock</span>
                            <div x-show="open" class="absolute w-60 top-7 right-4 border bg-white shadow rounded px-1.5 py-1">
                                <p class="text-xs text-gray-700">We are sorry. The product is out of stock and temporarily unavailable</p>
                            </div>
                        </div>
                        @else
                        <div>
                            <span class="px-1.5 py-1 rounded-lg bg-red-400 text-white ml-1.5 text-xs">Low stock</span>
                        </div>
                        @endif
                        <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $product->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500 dark:text-gray-300 dark:hover:text-gray-100">{{ $product->inventory->vendor->brand }}</a>
                        @if ($product->inventory->vendor->is_verified)
                        <div><x-icon name="shield" class="text-green-600 dark:text-green-300" /></div>
                        @endif
                    </div>
                </x-product-card>
                @endforeach
            </div>
            @else
            <div class="text-center">
                <div class="flex flex-col items-center">
                    <div class="mx-auto w-40 rotate-12">
                        <img src="/images/empty_product.svg" alt="">
                    </div>
                    <div class="pb-3 pt-6 text-center text-slate-700">
                        No Products Found
                    </div>
                </div>
            </div>
            @endif
            
            <div class="mt-4">
                {{ $products->links('vendor.pagination.links') }}
            </div>

        </x-container>
    </section class="py-10 dark:bg-gray-900">
</x-layout>