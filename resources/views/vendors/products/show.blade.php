<x-vendor-layout>
    <x-slot:title>
        {{ $product->name }} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.show', $product->slug) }}" class="{{ request()->routeIs('vendor.products.*') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Current Product</a>
        </li>
    </ul>
    {{-- product info, categories, views, how many time added to carts, purchases, stock info, total reviews, edit, remove --}}
    <section class="px-3 py-3 mt-6 shadow rounded">

    </section>
</x-vendor-layout>