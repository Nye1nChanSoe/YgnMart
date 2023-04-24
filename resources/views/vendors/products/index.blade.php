<x-vendor-layout>
    <x-slot:title>
        Manage products - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-black font-medium">Product Catalogue</h1>
            <div class="flex items-center gap-x-4">
                <a href="{{ route('vendor.products.create') }}" class="px-3 py-2 text-white rounded-lg bg-blue-500 hover:bg-blue-700">Add New Product</a>
                @unless ($inventories->isEmpty())
                <a href="{{ route('vendor.inventories') }}" class="px-3 py-2 text-white rounded-lg bg-blue-500 hover:bg-blue-700">Manage Inventories</a>
                @endif
            </div>
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
                            Price
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Rating
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
                                <div class="text-gray-700">{{ number_format($inventory->product->price, 0, '.', ',') }}<span class="ml-1.5 text-xs text-gray-400">Kyat</span></div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="max-w-[140px] text-xs flex items-center gap-x-1  overflow-hidden">
                                    <p class="truncate">
                                        @foreach ($inventory->product->categories as $category)
                                        {{ $category->sub_type }}
                                        @endforeach
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                @if ($inventory->product->rating_point >= 3)
                                <div class="text-lime-600 font-bold">{{ number_format($inventory->product->rating_point, 1) }}</div>
                                @elseif($inventory->product->rating_point > 0 && $inventory->product->rating_point < 3)
                                <div class="text-orange-600 font-bold">{{ number_format($inventory->product->rating_point, 1) }}</div>
                                @else
                                <div class="text-gray-400">{{ number_format($inventory->product->rating_point, 1) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-2">
                                @if ($inventory->status == 'sell')
                                <div class="bg-green-100 rounded-lg text-green-900 text-center px-1 py-1">Selling</div>
                                @else
                                <div class="bg-gray-500 rounded-lg text-white text-center px-1 py-1">Closed</div>
                                @endif
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex items-center gap-x-2">
                                    <time>{{\Carbon\Carbon::parse($inventory->product->updated_at)->format('M j, Y')}}</time>
                                    <time>{{\Carbon\Carbon::parse($inventory->product->updated_at)->format('g:i A')}}</time>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-sm mt-4">
            {{ $inventories->links('vendor.pagination.links') }}
        </div>
        @else
        <div class="flex items-center justify-center w-full h-60">
            <p class="text-gray-400">You do not have any listed product!</p>
        </div>
        @endunless

    </section>
</x-vendor-layout>