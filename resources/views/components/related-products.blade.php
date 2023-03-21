@props(['relatedProducts', 'product'])

<section id="related-products" {{$attributes->merge(['class' => 'my-10'])}}>
    <h1 class="text-lg p-2 my-4 border-l-4 border-sky-400">Similar Products like <span class="text-base font-medium">"{{ $product->name }}"</span></h1>
    @if ($relatedProducts->count() > 5)
    <div class="grid grid-cols-2 grid-rows-2 gap-x-4 gap-y-4 justify-center md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach ($relatedProducts as $relatedProduct)
        <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" class="flex flex-col items-center p-4 drop-shadow bg-white rounded-lg transition-all duration-300 hover:-translate-y-3">
            <x-product-review :product="$relatedProduct" class="pb-2" />
            <div class="flex items-center justify-center w-40 h-32">
                <img src="{{$relatedProduct->image ? asset($relatedProduct->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-contain">
            </div>
            <h2 class="text-sm text-center my-2 hover:text-blue-600">{{ $relatedProduct->name }}</h2>
            <div>
                <h5 class="px-3 py-[2px] bg-yellow-300 text-black font-semibold rounded-xl text-lg text-center">{{number_format($relatedProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="grid grid-cols-2 gap-x-4 justify-center md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach ($relatedProducts as $relatedProduct)
        <a href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}" class="flex flex-col items-center p-4 drop-shadow bg-white rounded-lg transition-all duration-300 hover:-translate-y-3">
            <x-product-review :product="$relatedProduct" class="pb-2" />
            <div class="flex items-center justify-center w-40 h-32">
                <img src="{{$relatedProduct->image ? asset($relatedProduct->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-cont">
            </div>
            <h2 class="text-sm text-center my-2 hover:text-blue-600">{{ $relatedProduct->name }}</h2>
            <div>
                <h5 class="px-3 py-[2px] bg-yellow-300 text-black font-semibold rounded-xl text-lg text-center">{{number_format($relatedProduct->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</section>