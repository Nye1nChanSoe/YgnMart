<x-vendor-layout>
    <x-slot:title>
        Edit {{ $product->name }} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.show', $product->slug) }}" class="{{ request()->routeIs(route('vendor.products.show', $product->slug)) ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Detail</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.edit', $product->slug) }}" class="text-blue-600 hover:text-blue-600">Edit</a>
        </li>
    </ul>

    <section class="px-3 py-3 mt-6 shadow rounded">
        
    </section>
</x-vendor-layout>