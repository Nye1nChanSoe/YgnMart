<x-layout>
    <x-slot:title>
        YangonMart.com Cart item added
    </x-slot:title>
    <x-container class="mt-8">
        <div>
            <div class="flex items-center mb-2">
                <p class="mr-2">Items added</p>
                <x-icon name="check" />
            </div>
            <a href="{{ route('carts.index') }}" class="block px-3 py-2 bg-blue-500 text-white w-fit rounded-lg hover:bg-blue-700">Go to cart</a>
            <div class="p-4 mt-6 border border-stone-400 rounded-lg w-full xl:w-1/2">
                <h2 class="text-center text-gray-700 mb-4 md:text-left">Added Item</h2>
                <div class="flex flex-col items-center md:flex-row md:justify-between md:space-x-4">
                    <div class="w-48">
                        <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-contain">
                    </div>
                    <p class="font-medium p-2 text-center rounded">{{ $product->name }}</p>
                </div>
            </div>
        </div>
        <x-related-products :related-products="$relatedProducts" :product="$product" class="pt-3 border-t" />
    </x-container>
</x-layout>