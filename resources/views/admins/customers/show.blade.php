@php
    $analytic = $user->analytics()->orderBy('updated_at', 'desc')->first();
@endphp

<x-admin-layout>
    <x-slot:title>
        {{$user->name}} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.customers') }}" class="{{ request()->routeIs('admin.customers') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Customers</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.customers.show', $user->username) }}" class="{{ request()->routeIs('admin.customers.show', $user->username) ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">User Profile</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">

        <div x-data="{open:false, askPassword:false}" class="flex justify-around my-8 px-10">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-32 h-32 overflow-hidden rounded-full bg-white">
                    @if ($user->image)
                    <img src="{{ asset('storage/images/'.$user->image) }}" alt="" class="w-full h-full object-cover shrink-0 rounded-full">
                    @else
                    <img src="https://placehold.co/128/png" alt="" class="w-full h-full object-cover rounded-full">
                    @endif
                </div>
                <div class="mt-6 space-y-1.5 text-center text-gray-300">
                    <div class="text-2xl font-semibold">{{ $user->name }}</div>
                    <div class="text-sm">
                        <span>@<span>{{ $user->username }}</span> </span>
                        <span>({{ ucfirst($user->role) }})</span>
                    </div>
                    @if ($user->user_status == 'active')
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-green-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
                    <time class="text-sm text-gray-400 font-normal">{{ \Carbon\Carbon::createFromTimestamp(strtotime($analytic->end_time))->diffForHumans() }}</time>
                    @else
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-red-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
                    <time class="text-sm text-gray-400 font-normal">{{ \Carbon\Carbon::createFromTimestamp(strtotime($analytic->end_time))->diffForHumans() }}</time>
                    @endif
                    <div class="flex items-center justify-center gap-x-2.5 pt-4">
                        <x-icon name="mail" class="text-gray-400" />
                        <a href="mailto:{{$user->email}}" class="hover:text-blue-300">{{ $user->email }}</a>
                    </div>
                    <div class="flex items-center justify-center gap-x-2.5">
                        <x-icon name="telephone" class="text-gray-400"/>
                        <a href="tel:+95{{$user->phone_number}}" class="hover:text-blue-300">{{ $user->phone_number }}</a>
                    </div>
                </div>
            </div>
            <div class="w-2/3">
                <div class="py-4 px-4 bg-slate-600 rounded-lg text-gray-300 md:px-6">
                    <div>
                        <div class="mt-1.5">
                            <h3 class="my-1">Total Orders</h3>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block">{{ $user->orders->count() }}</span>
                        </div>
                        <div class="mt-1.5">
                            <h3 class="my-1">Purchased Amount</h3>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block">{{ number_format($user->orders->sum('total_price'), 0, '.', ',') }}<span class="text-xs text-gray-400 ml-1">Kyat</span></span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 py-4 px-4 bg-slate-600 rounded-lg text-gray-300 md:px-6">
                    <div>
                        <div class="mt-1.5">
                            <h3 class="my-1">IP Address</h3>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block text-green-500">{{ $analytic->ip_address }}</span>
                        </div>
                        <div class="mt-1.5">
                            <h3 class="my-1">Device Type</h3>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block text-green-500">{{ $analytic->device_type }}</span>
                        </div>
                        <div class="mt-1.5">
                            <h3 class="my-1">Device Name</h3>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block text-green-500">{{ $analytic->device_name }}</span>
                        </div>
                        <div class="mt-1.5">
                            <h3 class="my-1">Browser Type</h3>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block text-green-500">{{ $analytic->browser_type }}</span>
                        </div>
                        <div class="mt-1.5">
                            <span>Operating System</span>
                            <span class="bg-gray-800 rounded p-1.5 w-full inline-block text-green-500">{{ $analytic->operating_system }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.customers.update', $user->username) }}" method="POST" class="mt-4 py-4 px-4 bg-slate-600 rounded-lg text-gray-100 md:px-6">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="update_type" value="info">
                    <div class="flex mb-6 justify-between">
                        <h1 class="font-medium text-xl">User Info</h1>
                        <div>
                            <button x-on:click="open=!open" type="button" class="px-2.5 py-1.5 rounded-lg text-white bg-slate-700 hover:bg-slate-800">Edit Account</button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="username">Username</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="username" id="username" type="text" value="{{ old('username') ?? $user->username }}" x-bind:readonly="!open" placeholder="Username">
                        <x-input-error class="text-red-300" field="username" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="name">Name</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="name" id="name" type="text" value="{{ old('name') ?? $user->name }}" x-bind:readonly="!open" placeholder="Name">
                        <x-input-error class="text-red-300" field="name" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="email">Email</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="email" id="email" type="email" value="{{ old('email') ?? $user->email }}" x-bind:readonly="!open" placeholder="Email">
                        <x-input-error class="text-red-300" field="email" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="phone_number">Phone Number</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="phone_number" id="phone_number" type="text" value="{{ old('phone_number') ?? $user->phone_number }}" x-bind:readonly="!open" placeholder="Phone Number">
                        <x-input-error class="text-red-300" field="phone_number" />
                    </div>
                    <button x-show="open" type="submit" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Save Changes
                    </button>
                </form>

                <div class="mt-6">
                    <button x-on:click="askPassword=true" type="button" class="px-2.5 py-1.5 rounded-lg text-white bg-red-500 hover:bg-red-600">Delete Account</button>
                </div>
            </div>

            <!-- Blur Background -->
            <div x-show="askPassword" class="fixed inset-0 bg-gray-600 bg-opacity-50" x-cloak></div>
            
            <!-- Models -->
            <div x-show="askPassword" class="fixed z-10 inset-0 overflow-y-auto" x-cloak x-transition>
                <div class="flex items-center justify-center min-h-screen">
                    <div class="relative bg-gray-800 w-full max-w-sm mx-auto rounded-md shadow-lg px-4 py-3 md:px-8 md:py-5">
                        <div class="relative mb-6">
                            <h1 class="text-center text-gray-300 font-medium md:text-lg">Account Deletion</h1>
                            <button x-on:click="askPassword = false" class="absolute top-1.5 right-1.5"><x-icon name="close" class="text-gray-600 hover:text-blue-600" /></button>
                        </div>
                        <form action="{{ route('admin.customers.destroy', $user->username) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-4">
                                <label class="block text-gray-300 mb-2" for="password">Enter Your Password</label>
                                <input class="border rounded w-full py-2 px-3 bg-slate-200 text-gray-700 leading-tight focus:outline-blue-500" name="password" id="password" type="password">
                            </div>
                            <button type="submit" class="px-2.5 py-1.5 w-full rounded-lg text-white bg-red-500 hover:bg-red-600">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</x-admin-layout>