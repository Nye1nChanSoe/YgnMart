<x-layout>
    {{-- hero / carousel --}}
    @include('partials._carousel')

    {{-- TODO: divide sections and display related products for each section --}}
    <main>
        <div class="py-10 text-gray-700 dark:bg-gray-900">
            {{-- <div class="mx-auto container mb-2">
                {{ $householdProduct->links('vendor.pagination.result') }}
            </div> --}}

            @unless ($recentProducts->isEmpty())
            <section class="p-4">
                <div class="mx-auto container px-2 md:px-4 lg:px-5">
                    <div class="flex justify-center sm:justify-start">
                        <h2 class="mb-1.5 px-2.5 py-1.5 bg-purple-400 text-white font-semibold inline-block rounded-full text-sm dark:bg-purple-600">Recently Added Products</h2>
                    </div>
                    <div id="glide-container" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($recentProducts as $recentProduct)
                                <li class="glide__slide my-1.5">
                                    <x-product-card class="border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" :product="$recentProduct">
                                        <x-product-review :product="$recentProduct" class="justify-center mb-2.5" />
                                        <div class="flex items-center justify-center h-24 md:h-32">
                                            @if ($recentProduct->image)
                                            <img src="{{ asset('storage/images/'.$recentProduct->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                                            @else
                                            {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                                            <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                                            @endif
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                                <p><a href="/products/{{$recentProduct->slug}}">{{$recentProduct->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-gray-800 font-semibold rounded-xl w-32 text-xl text-center">{{number_format($recentProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($recentProduct->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs dark:bg-blue-600">In stock</span>
                                            </div>
                                            @elseif($recentProduct->inventory->available_quantity == 0)
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $recentProduct->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500 dark:text-gray-300 dark:hover:text-gray-100">{{ $recentProduct->inventory->vendor->brand }}</a>
                                            @if ($recentProduct->inventory->vendor->is_verified)
                                            <div><x-icon name="shield" class="text-green-600 dark:text-green-300" /></div>
                                            @endif
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
            @endunless

            @unless ($foodProducts->isEmpty())
            <section class="p-4">
                <div class="mx-auto container px-2 md:px-4 lg:px-5">
                    <div class="flex justify-center sm:justify-start">
                        <h2 class="mb-1.5 px-2.5 py-1.5 bg-orange-500 text-white font-semibold inline-block rounded-full text-sm dark:bg-orange-600">Food Related Products</h2>
                    </div>
                    <div id="glide-container2" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($foodProducts as $foodProduct)
                                <li class="glide__slide my-1.5">
                                    <x-product-card class="border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" :product="$foodProduct">
                                        <x-product-review :product="$foodProduct" class="justify-center mb-2.5" />
                                        <div class="flex items-center justify-center h-24 md:h-32">
                                            @if ($foodProduct->image)
                                            <img src="{{ asset('storage/images/'.$foodProduct->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                                            @else
                                            {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                                            <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                                            @endif
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                                <p><a href="/products/{{$foodProduct->slug}}">{{$foodProduct->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-gray-900 font-semibold rounded-xl w-32 text-xl text-center">{{number_format($foodProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($foodProduct->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs dark:bg-blue-600">In stock</span>
                                            </div>
                                            @elseif($foodProduct->inventory->available_quantity == 0)
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $foodProduct->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500 dark:text-gray-300 dark:hover:text-gray-100">{{ $foodProduct->inventory->vendor->brand }}</a>
                                            @if ($foodProduct->inventory->vendor->is_verified)
                                            <div><x-icon name="shield" class="text-green-600 dark:text-green-300" /></div>
                                            @endif
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
            @endunless

            @unless ($drinkProducts->isEmpty())
            <section class="p-4">
                <div class="mx-auto container px-2 md:px-4 lg:px-5">
                    <div class="flex justify-center sm:justify-start">
                        <h2 class="mb-1.5 px-2.5 py-1.5 bg-red-400 text-white font-semibold inline-block rounded-full text-sm dark:bg-red-600">Drinks Related Products</h2>
                    </div>
                    <div id="glide-container3" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($drinkProducts as $drinkProduct)
                                <li class="glide__slide my-1.5">
                                    <x-product-card class="border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" :product="$drinkProduct">
                                        <x-product-review :product="$drinkProduct" class="justify-center mb-2.5" />
                                        <div class="flex items-center justify-center h-24 md:h-32">
                                            @if ($drinkProduct->image)
                                            <img src="{{ asset('storage/images/'.$drinkProduct->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                                            @else
                                            {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                                            <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                                            @endif
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                                <p><a href="/products/{{$drinkProduct->slug}}">{{$drinkProduct->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-gray-900 font-semibold rounded-xl w-32 text-xl text-center">{{number_format($drinkProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($drinkProduct->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs dark:bg-blue-600">In stock</span>
                                            </div>
                                            @elseif($drinkProduct->inventory->available_quantity == 0)
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $drinkProduct->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500 dark:text-gray-300 dark:hover:text-gray-100">{{ $drinkProduct->inventory->vendor->brand }}</a>
                                            @if ($drinkProduct->inventory->vendor->is_verified)
                                            <div><x-icon name="shield" class="text-green-600 dark:text-green-300" /></div>
                                            @endif
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
            @endunless

            @unless ($householdProducts->isEmpty())
            <section class="p-4">
                <div class="mx-auto container px-2 md:px-4 lg:px-5">
                    <div class="flex justify-center sm:justify-start">
                        <h2 class="mb-1.5 px-2.5 py-1.5 bg-blue-500 text-white font-semibold inline-block rounded-full text-sm dark:bg-blue-600">Household Related Products</h2>
                    </div>
                    <div id="glide-container4" class="glide invisible">
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                @foreach ($householdProducts as $householdProduct)
                                <li class="glide__slide my-1.5">
                                    <x-product-card class="border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" :product="$householdProduct">
                                        <x-product-review :product="$householdProduct" class="justify-center mb-2.5" />
                                        <div class="flex items-center justify-center h-24 md:h-32">
                                            @if ($householdProduct->image)
                                            <img src="{{ asset('storage/images/'.$householdProduct->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                                            @else
                                            {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                                            <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                                            @endif
                                        </div>
                                        {{-- name and stock --}}
                                        <div>
                                            <h3 class="font-semibold  hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                                <p><a href="/products/{{$householdProduct->slug}}">{{$householdProduct->name}}</a></p>
                                            </h3>
                                        </div>

                                        <div>
                                            <h5 class="px-2.5 py-[3px] bg-yellow-300 text-gray-900 font-semibold rounded-xl w-32 text-xl text-center">{{number_format($householdProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            @if ($householdProduct->inventory->available_quantity >= 100)
                                            <div>
                                                <span class="px-1.5 py-1 rounded-lg bg-blue-400 text-white ml-1.5 text-xs dark:bg-blue-600">In stock</span>
                                            </div>
                                            @elseif($householdProduct->inventory->available_quantity == 0)
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
                                            <a href="?seller={{ strtolower(str_replace([' ', '_'], '-', $householdProduct->inventory->vendor->brand)) }}" class="text-sm text-gray-500 hover:text-blue-500 dark:text-gray-300 dark:hover:text-gray-100">{{ $householdProduct->inventory->vendor->brand }}</a>
                                            @if ($householdProduct->inventory->vendor->is_verified)
                                            <div><x-icon name="shield" class="text-green-600 dark:text-green-300" /></div>
                                            @endif
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
            @endunless
        </div>
    </main>
</x-layout>

<style>
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

    .dark .glide__arrow {
        color: #f1f1f1;
    }

    .dark .glide__arrow:hover {
        background-color: #4b4b4b;
    }

    .glide__arrow--left {
        left: -34px;
    }

    .glide__arrow--right {
        right: -34px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let breakpoints = {
            1536: {
                perView: 4,
            },
            1024: {
                perView: 3,
            },
            768: {
                perView: 2
            },
            480: {
                perView: 1
            }
        };

@unless($recentProducts->isEmpty())
    new Glide('#glide-container', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 4500,
        hoverpause: true,
        breakpoints: breakpoints,
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container').classList.remove('invisible');
@endunless

@unless($foodProducts->isEmpty())
    new Glide('#glide-container2', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 4650,
        hoverpause: true,
        breakpoints: breakpoints,
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container2').classList.remove('invisible');
@endunless

@unless($drinkProducts->isEmpty())
    new Glide('#glide-container3', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 4450,
        hoverpause: true,
        breakpoints: breakpoints,
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container3').classList.remove('invisible');
@endunless

@unless($householdProducts->isEmpty())
    new Glide('#glide-container4', {
        type: 'carousel',
        perView: 6,
        focusAt: '0',
        gap: 12,
        autoplay: 5000,
        hoverpause: true,
        breakpoints: breakpoints,
        navigation: {
            prevEl: '.glide__prev',
            nextEl: '.glide__next'
        }
    }).mount();
    document.getElementById('glide-container4').classList.remove('invisible');
@endunless
});

</script>