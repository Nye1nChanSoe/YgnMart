@props(['relatedProducts', 'product'])

<section id="related-products" {{$attributes->merge(['class' => 'px-2 md:px-0'])}}>
    <h1 class="text-lg pt-4 pb-2 my-4 text-center md:text-left">Similar Products like <span class="text-base font-medium">"{{ $product->name }}"</span></h1>
    @if ($relatedProducts->count() > 5)
    <div class="grid grid-cols-2 grid-rows-2 gap-x-2 gap-y-2 justify-center md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 md:gap-x-4 md:gap-y-4">
        @foreach ($relatedProducts as $relatedProduct)
        <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" class="flex flex-col items-center p-4 drop-shadow bg-white rounded-lg transition-all duration-300 hover:-translate-y-3">
            <x-product-review :product="$relatedProduct" class="pb-2" />
            <div class="flex items-center justify-center w-32 h-24 md:w-40 md:h-32">
                <img src="{{$relatedProduct->image ? asset($relatedProduct->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-contain">
            </div>
            <h2 class="text-xs text-center my-2 hover:text-blue-600 md:text-sm">{{ $relatedProduct->name }}</h2>
            <div>
                <h5 class="px-3 py-[2px] bg-yellow-300 text-black font-semibold rounded-xl text-base text-center md:text-lg">{{number_format($relatedProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="grid grid-cols-2 gap-x-2 gap-y-2 justify-center md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 md:gap-x-4 md:gap-y-4">
        @foreach ($relatedProducts as $relatedProduct)
        <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" class="flex flex-col items-center p-4 drop-shadow bg-white rounded-lg transition-all duration-300 hover:-translate-y-3">
            <x-product-review :product="$relatedProduct" class="pb-2" />
            <div class="flex items-center justify-center w-32 h-24 md:w-40 md:h-32">
                <img src="{{$relatedProduct->image ? asset($relatedProduct->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-cont">
            </div>
            <h2 class="text-xs text-center my-2 hover:text-blue-600 md:text-sm">{{ $relatedProduct->name }}</h2>
            <div>
                <h5 class="px-3 py-[2px] bg-yellow-300 text-black font-semibold rounded-xl text-base text-center md:text-lg">{{number_format($relatedProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
            </div>
        </a> 
        @endforeach
    </div>
    @endif
</section>