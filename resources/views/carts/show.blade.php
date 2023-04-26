<x-layout>
    <x-slot:title>
        Item Added - YangonMart.com | {{$product->name}}
    </x-slot:title>
    <x-container class="mt-8 mb-0">
        <ul class="flex items-center my-3 px-3 py-3 text-sm">
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Home</a><x-icon name="chevron-right" class="dark:text-gray-200" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('products.show', $product->slug) }}" class="{{ request()->routeIs('products.show') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Product</a><x-icon name="chevron-right" class="dark:text-gray-200" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('carts.show', $product->slug) }}" class="{{ request()->routeIs('carts.show') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Cart Item</a>
            </li>
        </ul>
        <div class="p-4 mt-6 border border-stone-200 rounded-lg w-full xl:w-1/2 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900">
            <div class="flex flex-col items-center md:flex-row md:justify-between md:space-x-4">
                <div class="w-48">
                    <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" class="max-w-full max-h-full object-contain">
                </div>
                <p class="font-medium p-2 text-center rounded">{{ $product->name }}</p>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center mt-6 md:items-start">
            <div class="flex items-center">
                <p class="mr-2 md:text-lg dark:text-gray-300">{{ $cart->quantity }} Items added</p>
                <x-icon name="check" class="inline" />
            </div>
            <a href="{{ route('carts.index') }}" class="block px-3 py-2 mt-2 bg-blue-500 text-white w-fit rounded-lg hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">Go to cart</a>
        </div>
    </x-container>
    <div class="bg-white px-3 pb-6 border rounded-md dark:bg-gray-900 dark:border-0 dark:text-gray-300">
        <div class="container mx-auto ">
            <x-related-products :related-products="$relatedProducts" :product="$product"/>
        </div>
    </div>
</x-layout>