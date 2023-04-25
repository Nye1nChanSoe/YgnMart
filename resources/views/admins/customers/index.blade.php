<x-admin-layout>
    <x-slot:title>
        Manage Customers - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.customers') }}" class="{{ request()->routeIs('admin.customers') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Customers</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-gray-300 font-medium">Customer List</h1>
        </div>

        @unless ($customers->isEmpty())
        <div class="relative shadow rounded">
            <table class="w-full text-sm text-slate-200 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start">
                            No
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Phone Number
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Address
                        </th>
                    </tr>
                </thead>
                <tbody x-data="">
                    @foreach ($customers as $customer)
                        <tr x-on:click="window.location.href = '{{ route('admin.customers.show', $customer->username) }}'" class="bg-slate-500 cursor-pointer even:bg-slate-600 hover:bg-gray-800"">
                            <td class="px-6 py-2">
                                <div>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-6 py-2 font-medium text-white whitespace-nowrap dark:text-white">
                                <div class="flex items-center gap-x-2.5">
                                    <div class="flex flex-shrink-0 items-center w-10 h-10 rounded-full overflow-hidden">
                                        <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full object-contain">
                                    </div>
                                    @if ($customer->user_status == 'active')
                                    <div class="bg-green-400 rounded-full px-1 py-1 w-fit "></div>
                                    @else
                                    <div class="bg-red-400 rounded-full px-1 py-1 w-fit "></div>
                                    @endif
                                    <div class="w-20 overflow-hidden lg:w-36">
                                        <p class="truncate">{{ $customer->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $customer->username }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $customer->email }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $customer->phone_number }}</div>
                            </td>
                            <td class="px-6 py-2">
                                @if ($customer->addresses->count() > 0)
                                <div class="w-24 flex items-center gap-x-1 overflow-hidden lg:w-40">
                                    <x-icon name="location" class="text-white shrink-0" />
                                    <p class="truncate">{{ $customer->addresses->first()->full_address }}</p>
                                </div>
                                @else
                                <div>No Address</div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-sm mt-4">
            {{ $customers->links('vendor.pagination.links') }}
        </div>
        @else
        <div class="flex items-center justify-center w-full h-60">
            <p class="text-gray-400">No Customer Found!</p>
        </div>
        @endunless

    </section>
</x-admin-layout>