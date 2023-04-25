<x-admin-layout>
    <x-slot:title>
        Profile - {{$vendor->name}} | YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.vendors') }}" class="{{ request()->routeIs('admin.vendors') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Vendors</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.vendors.show', $vendor->username) }}" class="{{ request()->routeIs('admin.vendors.show', $vendor->username) ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Vendor Profile</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">

        <div x-data="{open:false, askPassword:false}" class="flex justify-around my-8 px-10">
            <div class="flex flex-col items-center">
                <div class="flex bg-slate-200 flex-shrink-0 items-center w-32 h-32 rounded-full overflow-hidden">
                    <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full object-contain">
                </div>
                <div class="mt-6 space-y-1.5 text-center text-gray-300">
                    <div class="text-2xl font-semibold">{{ $vendor->brand }}</div>
                    <div class="text-sm flex items-center justify-center gap-x-1.5">
                        <div>@<span>{{ $vendor->username }}</span></div>
                        @if ($vendor->is_verified)
                        <div><x-icon name="shield" class="text-green-300" /></div>
                        @endif
                    </div>
                    @if ($vendor->status == 'active')
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-green-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
                    @else
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-red-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
                    @endif
                    <div class="flex items-center justify-center gap-x-2.5 pt-4">
                        <x-icon name="mail" class="text-gray-400" />
                        <a href="mailto:{{$vendor->email}}" class="hover:text-blue-300">{{ $vendor->email }}</a>
                    </div>
                    <div class="flex items-center justify-center gap-x-2.5">
                        <x-icon name="telephone" class="text-gray-400"/>
                        <a href="tel:+95{{$vendor->phone_number}}" class="hover:text-blue-300">{{ $vendor->phone_number }}</a>
                    </div>
                    <div class="pt-2.5">
                        <button x-on:click="open=!open" class="px-2.5 py-1.5 rounded-lg text-white bg-slate-500 hover:bg-slate-600">Edit Account</button>
                    </div>
                    @if (!$vendor->is_verified)
                    <div class="pt-2.5">
                        <form action="{{ route('admin.vendors.verify', $vendor->username) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-2.5 py-1.5 w-28 rounded-lg text-white bg-slate-500 hover:bg-slate-600">Verify</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            <div class="w-2/3">
                <form action="{{ route('admin.vendors.update', $vendor->username) }}" method="POST" class="py-4 px-4 bg-slate-600 rounded-lg text-gray-100 md:px-6">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="update_type" value="info">
                    <h1 class="mb-6 font-medium text-xl">Vendor Info</h1>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="brand">Brand Name</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="brand" id="brand" type="text" value="{{ old('brand') ?? $vendor->brand }}" x-bind:readonly="!open" placeholder="brand">
                        <x-input-error class="text-red-300" field="brand" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="username">Username</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="username" id="username" type="text" value="{{ old('username') ?? $vendor->username }}" x-bind:readonly="!open" placeholder="Username">
                        <x-input-error class="text-red-300" field="username" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="email">Email</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="email" id="email" type="email" value="{{ old('email') ?? $vendor->email }}" x-bind:readonly="!open" placeholder="Email">
                        <x-input-error class="text-red-300" field="email" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="phone_number">Phone Number</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="phone_number" id="phone_number" type="text" value="{{ old('phone_number') ?? $vendor->phone_number }}" x-bind:readonly="!open" placeholder="Phone Number">
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
                        <form action="{{ route('admin.vendors.destroy', $vendor->username) }}" method="POST">
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