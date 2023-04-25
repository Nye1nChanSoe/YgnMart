<x-layout>
    {{-- hero / carousel --}}
    @include('partials._carousel')

    {{-- TODO: divide sections and display related products for each section --}}
    <main>
        @if (!$products->isEmpty())
        <div class="mb-10">
            <div class="mx-auto container mb-2">
                {{ $products->links('vendor.pagination.result') }}
            </div>
            <section class="p-4">
                <div class="mx-auto container">
                    <h2 class="mb-1.5 px-2.5 py-1.5 bg-purple-400 text-white font-semibold inline-block rounded-full text-sm">Recently Added Products</h2>
                    <div id="glide-container" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($products as $product)
                                <li class="glide__slide my-1.5">
                                    <x-product-card :product="$product">
                                        <div class="flex justify-center h-24 md:h-28">
                                            <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="w-full h-full shrink-0 object-contain">
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600">
                                                <p><a href="/products/{{$product->slug}}">{{$product->name}}</a></p>
                                            </h3>
                                        </div>
    
                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($product->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs">In stock</span>
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $product->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500">{{ $product->inventory->vendor->brand }}</a>
                                        </div>
                                    </x-product-card>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><x-icon name="chevron-big" class="transform rotate-180" /></button>
                            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><x-icon name="chevron-big" /></button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="p-4">
                <div class="mx-auto container">
                    <h2 class="mb-1.5 px-2.5 py-1.5 bg-orange-500 text-white font-semibold inline-block rounded-full text-sm">Food Related Products</h2>
                    <div id="glide-container2" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($products as $product)
                                <li class="glide__slide my-1.5">
                                    <x-product-card :product="$product">
                                        <div class="flex justify-center h-24 md:h-28">
                                            <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="w-full h-full shrink-0 object-contain">
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600">
                                                <p><a href="/products/{{$product->slug}}">{{$product->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($product->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs">In stock</span>
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $product->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500">{{ $product->inventory->vendor->brand }}</a>
                                        </div>
                                    </x-product-card>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><x-icon name="chevron-big" class="transform rotate-180" /></button>
                            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><x-icon name="chevron-big" /></button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="p-4">
                <div class="mx-auto container">
                    <h2 class="mb-1.5 px-2.5 py-1.5 bg-red-400 text-white font-semibold inline-block rounded-full text-sm">Drinks Related Products</h2>
                    <div id="glide-container3" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($products as $product)
                                <li class="glide__slide my-1.5">
                                    <x-product-card :product="$product">
                                        <div class="flex justify-center h-24 md:h-28">
                                            <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="w-full h-full shrink-0 object-contain">
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600">
                                                <p><a href="/products/{{$product->slug}}">{{$product->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($product->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs">In stock</span>
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $product->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500">{{ $product->inventory->vendor->brand }}</a>
                                        </div>
                                    </x-product-card>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><x-icon name="chevron-big" class="transform rotate-180" /></button>
                            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><x-icon name="chevron-big" /></button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="p-4">
                <div class="mx-auto container">
                    <h2 class="mb-1.5 px-2.5 py-1.5 bg-blue-500 text-white font-semibold inline-block rounded-full text-sm">Household Related Products</h2>
                    <div id="glide-container4" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($products as $product)
                                <li class="glide__slide my-1.5">
                                    <x-product-card :product="$product">
                                        <div class="flex justify-center h-24 md:h-28">
                                            <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="w-full h-full shrink-0 object-contain">
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600">
                                                <p><a href="/products/{{$product->slug}}">{{$product->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($product->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs">In stock</span>
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $product->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500">{{ $product->inventory->vendor->brand }}</a>
                                        </div>
                                    </x-product-card>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><x-icon name="chevron-big" class="transform rotate-180" /></button>
                            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><x-icon name="chevron-big" /></button>
                        </div>
                    </div>
                </div>
            </section>
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
    </main>
</x-layout>

<style>
.glide {
    padding: 0px 4px;
}
.glide__arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: transparent;
    border: none;
    color: #131313;
    box-shadow: none;
    padding: 4px;
}
.glide__arrow:hover {
    background-color: #efefef;
}
.glide__arrow--left {
    left: -35px;
}
.glide__arrow--right {
    right: -35px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Glide('#glide-container', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 5000,
        hoverpause: true,
        breakpoints: {
            1536: {
                perView: 4
            },
            1024: {
                perView: 3
            },
            768: {
                perView: 2
            },
            480: {
                perView: 1
            }
        },
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container').classList.remove('invisible');

    new Glide('#glide-container2', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 5000,
        hoverpause: true,
        breakpoints: {
            1536: {
                perView: 4
            },
            1024: {
                perView: 3
            },
            768: {
                perView: 2
            },
            480: {
                perView: 1
            }
        },
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container2').classList.remove('invisible');

    new Glide('#glide-container3', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 5000,
        hoverpause: true,
        breakpoints: {
            1536: {
                perView: 4
            },
            1024: {
                perView: 3
            },
            768: {
                perView: 2
            },
            480: {
                perView: 1
            }
        },
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container3').classList.remove('invisible');

    new Glide('#glide-container4', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 5000,
        hoverpause: true,
        breakpoints: {
            1536: {
                perView: 4
            },
            1024: {
                perView: 3
            },
            768: {
                perView: 2
            },
            480: {
                perView: 1
            }
        },
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container4').classList.remove('invisible');
});

</script>