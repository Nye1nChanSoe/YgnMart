@props(['relatedProducts', 'product'])

<section id="related-products" {{$attributes->merge(['class' => 'px-2 md:px-0'])}}>
    <h1 class="text-lg pt-4 pb-2 my-4 text-center md:text-left">Similar Products like <span class="text-base font-medium">"{{ $product->name }}"</span></h1>
    @unless ($relatedProducts->count() == 0)
        @if ($relatedProducts->count() > 5)
        <div class="grid grid-cols-2 grid-rows-2 gap-x-2 gap-y-2 justify-center md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 md:gap-x-4 md:gap-y-4">
            @foreach ($relatedProducts as $relatedProduct)
            <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" class="flex flex-col items-center p-4 drop-shadow bg-white rounded-lg transition-all duration-300 hover:-translate-y-3 dark:border dark:bg-gray-800 dark:border-gray-700">
                <x-product-review :product="$relatedProduct" class="pb-2" />
                <div class="flex items-center justify-center w-32 h-24 md:w-40 md:h-32">
                    @if ($relatedProduct->image)
                    <img src="{{ asset('storage/images/'.$relatedProduct->image) }}" alt="" class="w-full h-full object-contain shrink-0">
                    @else
                    {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                    <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                    @endif
                </div>
                <h2 class="text-xs text-center my-2 hover:text-blue-600 md:text-sm dark:hover:text-blue-300">{{ $relatedProduct->name }}</h2>
                <div>
                    <h5 class="px-3 py-[2px] bg-yellow-300 text-gray-900 font-semibold rounded-xl text-base text-center md:text-lg">{{number_format($relatedProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="grid grid-cols-2 gap-x-2 gap-y-2 justify-center md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 md:gap-x-4 md:gap-y-4">
            @foreach ($relatedProducts as $relatedProduct)
            <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" class="flex flex-col items-center p-4 drop-shadow bg-white rounded-lg transition-all duration-300 hover:-translate-y-3 dark:border dark:bg-gray-800 dark:border-gray-700">
                <x-product-review :product="$relatedProduct" class="pb-2" />
                <div class="flex items-center justify-center w-32 h-24 md:w-40 md:h-32">
                    @if ($relatedProduct->image)
                    <img src="{{ asset('storage/images/'.$relatedProduct->image) }}" alt="" class="w-full h-full object-contain shrink-0">
                    @else
                    {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                    <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                    @endif
                </div>
                <h2 class="text-xs text-center my-2 hover:text-blue-600 md:text-sm dark:hover:text-blue-300">{{ $relatedProduct->name }}</h2>
                <div>
                    <h5 class="px-3 py-[2px] bg-yellow-300 text-gray-900 font-semibold rounded-xl text-base text-center md:text-lg">{{number_format($relatedProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                </div>
            </a> 
            @endforeach
        </div>
        @endif
    @else
        <p class="text-gray-600 dark:text-gray-400">There are no similar products like <span class="font-semibold">{{$product->name}}</span> yet!</p>
    @endif
</section>