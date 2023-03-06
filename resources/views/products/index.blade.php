<x-layout>
    {{-- hero / carousel --}}
    @include('partials._carousel')

    {{-- TODO: divide sections and display related products for each section --}}
    <main>
        <div class="container mx-auto grid grid-cols-2 gap-x-2 gap-y-4 mb-10 px-2 md:px-6 md:grid-cols-3 lg:grid-cols-4 3xl:grid-cols-6">
            @foreach ($products as $product)
                <x-product-card>
                    <div class="self-center h-32 md:h-40">
                        <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" style="max-width: 100%; height:100%; object-fit:contain">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="/products/{{$product->slug}}">{{$product->name}}</a>
                        </h3>
                        <span class="text-xs ml-2">{{rand(40, 230)}} in stock</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">{{number_format($product->price + ($product->price * 0.1), 0, '.', ',')}}</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>
                
                    <x-product-review />
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </x-product-card>
            @endforeach
        </div>
    </main>
</x-layout>

