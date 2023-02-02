@props([
    'product'
])

<x-layout>
    <div class="container mx-auto px-4 py-6">
        <div>
            {{$product->name}}
        </div>
        <div>
            {{$product->price}}
        </div>
        <a href="/cart" class="text-blue-500 hover:text-blue-700">Go to cart</a>
    </div>
</x-layout>