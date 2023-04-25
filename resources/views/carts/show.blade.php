<x-layout>
    <x-slot:title>
        Item Added - YangonMart.com | {{$product->name}}
    </x-slot:title>
    <x-container class="mt-8 mb-0">
        <ul class="flex items-center my-3 px-3 py-3 text-sm">
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Home</a><x-icon name="chevron-right" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('products.show', $product->slug) }}" class="{{ request()->routeIs('products.show') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Product</a><x-icon name="chevron-right" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('carts.show', $product->slug) }}" class="{{ request()->routeIs('carts.show') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Cart Item</a>
            </li>
        </ul>
        <div class="p-4 mt-6 border border-stone-200 rounded-lg w-full xl:w-1/2">
            <div class="flex flex-col items-center md:flex-row md:justify-between md:space-x-4">
                <div class="w-48">
                    <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-contain">
                </div>
                <p class="font-medium p-2 text-center rounded">{{ $product->name }}</p>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center mt-6 md:items-start">
            <div class="flex items-center">
                <p class="mr-2 md:text-lg">{{ $cart->quantity }} Items added</p>
                <x-icon name="check" class="inline" />
            </div>
            <a href="{{ route('carts.index') }}" class="block px-3 py-2 mt-2 bg-blue-500 text-white w-fit rounded-lg hover:bg-blue-700">Go to cart</a>
        </div>
    </x-container>
    <div class="bg-white px-3 pb-10 my-10 border rounded-md">
        <div class="container mx-auto">
            <x-related-products :related-products="$relatedProducts" :product="$product"/>
        </div>
    </div>
</x-layout>