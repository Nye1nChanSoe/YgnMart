<x-vendor-layout>
    <x-slot:title>
        Manage inventory - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.inventories') }}" class="{{ request()->routeIs('vendor.inventories') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Inventories</a>
        </li>
    </ul>
    <section class="mt-4 px-3 py-3 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-black font-medium">Stock Control</h1>
        </div>

        @unless ($inventories->isEmpty())
        <div class="relative overflow-x-auto shadow rounded">
            <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start">
                            No
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Product Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Total Stocks
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Minimum Threshold
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Qty Avaliable
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody x-data="">
                    @foreach ($inventories as $inventory)
                        <tr x-on:click="window.location.href = '{{ route('vendor.products.show', $inventory->product->slug) }}'" class="bg-white border-b even:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-300">
                            <td class="px-6 py-2">
                                <div>{{ ($inventories->currentPage() - 1) * $inventories->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex items-center gap-x-4">
                                    <div class="flex flex-shrink-0 items-center w-10 h-10 rounded-full overflow-hidden">
                                        <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full object-contain">
                                    </div>
                                    <div class="w-32 overflow-hidden lg:w-40">
                                        <p class="truncate">{{ $inventory->product->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="col-span-1">{{ number_format($inventory->in_stock_quantity, 0, '.', ',') }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="col-span-1">{{ $inventory->minimum_quantity }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="font-medium">{{ number_format($inventory->available_quantity, 0, '.', ',') }}</div>
                            </td>
                            <td class="px-2 py-2 text-center">
                                @if ($inventory->in_stock)
                                <div class="bg-green-600 rounded-lg text-white px-1.5 py-1">In Stock</div>
                                @elseif($inventory->low_stock)
                                <div x-data="{open:false}" x-on:mouseenter="open=true" x-on:mouseleave="open=false" class="relative bg-orange-400 rounded-lg text-white px-1.5 py-1">
                                    <span>Low Stock</span>
                                    <div x-show="open" class="absolute w-60 top-7 right-0 bg-white z-10 text-gray-700 px-2 py-1.5 rounded-lg shadow">
                                        <p class="text-sm text-center">Available quantity is less than <span class="font-medium">200</span></p>
                                    </div>
                                </div>
                                @else
                                <div class="bg-red-600 rounded-lg text-white px-1.5 py-1">Out of Stock</div>
                                @endif
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex items-center whitespace-nowrap gap-x-2">
                                    <time>{{\Carbon\Carbon::parse($inventory->product->updated_at)->format('M j, Y')}}</time>
                                    <time>{{\Carbon\Carbon::parse($inventory->product->updated_at)->format('g:i A')}}</time>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endunless
        <div class="text-sm mt-4">
            {{ $inventories->links('vendor.pagination.links') }}
        </div>

    </section>
</x-vendor-layout>