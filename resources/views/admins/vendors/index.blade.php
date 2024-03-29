<x-admin-layout>
    <x-slot:title>
        Manage Vendors - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.vendors') }}" class="{{ request()->routeIs('admin.vendors') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Vendors</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-gray-300 font-medium">Vendor List</h1>
        </div>

        @unless ($vendors->isEmpty())
        <div class="relative shadow rounded">
            <table class="w-full text-sm text-slate-200 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start">
                            No
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Brand Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-4 text-start whitespace-nowrap">
                            Phone Number
                        </th>
                        <th scope="col" class="px-6 py-4 text-start whitespace-nowrap">
                            Total Products
                        </th>
                    </tr>
                </thead>
                <tbody x-data="">
                    @foreach ($vendors as $vendor)
                        <tr x-on:click="window.location.href = '{{ route('admin.vendors.show', $vendor->username) }}'" class="bg-slate-500 cursor-pointer even:bg-slate-600 hover:bg-gray-800"">
                            <td class="px-6 py-2">
                                <div>{{ ($vendors->currentPage() - 1) * $vendors->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-6 py-2 font-medium text-white whitespace-nowrap dark:text-white">
                                <div class="flex items-center gap-x-2.5">
                                    <div class="flex items-center justify-center w-10 h-10 overflow-hidden rounded-full bg-white">
                                        @if ($vendor->image)
                                        <img src="{{ asset('storage/images/'.$vendor->image) }}" alt="" class="w-full h-full object-cover shrink-0 rounded-full">
                                        @else
                                        <img src="https://placehold.co/40/png" alt="" class="w-full h-full object-cover rounded-full">
                                        @endif
                                    </div>
                                    @if ($vendor->is_verified)
                                    <div><x-icon name="shield" class="text-green-300" /></div>
                                    @endif
                                    
                                    @if ($vendor->status == 'active')
                                    <div class="bg-green-400 rounded-full px-1 py-1 w-fit "></div>
                                    @else
                                    <div class="bg-red-400 rounded-full px-1 py-1 w-fit "></div>
                                    @endif
                                    
                                    <div class="w-20 overflow-hidden lg:w-24">
                                        <p class="truncate">{{ $vendor->brand }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $vendor->username }}</div>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div>{{ $vendor->email }}</div>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div>{{ $vendor->phone_number }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $vendor->inventories->where('status', 'sell')->count() }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-sm mt-4">
            {{ $vendors->links('vendor.pagination.links') }}
        </div>
        @else
        <div class="flex items-center justify-center w-full h-60">
            <p class="text-gray-400">No vendor Found!</p>
        </div>
        @endunless

    </section>
</x-admin-layout>