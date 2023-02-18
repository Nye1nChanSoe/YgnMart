@props([
    'product'
])

<x-layout>
    <x-container class="mt-14">
        <div class="flex items-center">
            <p class="mr-2">Items added</p>
            <x-icon name="check" />
        </div>
        <a href="/cart" class="text-blue-500 hover:text-blue-700">Go to cart</a>
    </x-container>
</x-layout>