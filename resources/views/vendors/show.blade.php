<x-vendor-layout>
    <x-slot:title>
        Profile - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-700">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.show', $vendor->username) }}" class="{{ request()->routeIs(['vendor.show', 'vendor.settings']) ? 'text-blue-700' : 'text-gray-700' }} hover:text-blue-700">Profile</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 shadow rounded-lg">

        <div class="flex justify-around my-8 px-10">
            <div class="flex flex-col items-center">
                <div class="flex bg-slate-50 flex-shrink-0 items-center w-32 h-32 rounded-full overflow-hidden">
                    <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full object-contain">
                </div>
                <div class="mt-6 space-y-1.5 text-center text-gray-700">
                    <div class="text-2xl font-semibold">{{ $vendor->brand }}</div>
                    <div class="text-sm flex items-center justify-center gap-x-1.5">
                        <span>@<span>{{ $vendor->username }}</span> </span>
                        @if ($vendor->is_verified)
                        <x-icon name="shield" class="text-green-700" />
                        @endif
                    </div>
                    @if ($vendor->status == 'active')
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-green-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
                    @else
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-red-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
                    @endif
                    <div class="flex items-center justify-center gap-x-2.5 pt-4">
                        <x-icon name="mail" class="text-gray-500" />
                        <a href="mailto:{{$vendor->email}}" class="hover:text-blue-700">{{ $vendor->email }}</a>
                    </div>
                    <div class="flex items-center justify-center gap-x-2.5">
                        <x-icon name="telephone" class="text-gray-500"/>
                        <a href="tel:+95{{$vendor->phone_number}}" class="hover:text-blue-700">{{ $vendor->phone_number }}</a>
                    </div>
                </div>
            </div>
            <div class="w-2/3">
                <form action="{{ route('vendor.update', $vendor->username) }}" method="POST" class="py-4 px-4 bg-slate-100 text-gray-700 rounded-lg md:px-6">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="update_type" value="info">
                    <h1 class="mb-6 font-medium text-xl">Edit Settings</h1>
                    <div class="mb-4">
                        <label class="block font-medium mb-2" for="username">Username</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="username" id="username" type="text" value="{{ old('username') ?? $vendor->username }}" placeholder="Username">
                        <x-input-error class="text-red-300" field="username" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-2" for="brand">Brand</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="brand" id="brand" type="text" value="{{ old('brand') ?? $vendor->brand }}" placeholder="Brand">
                        <x-input-error class="text-red-300" field="brand" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-2" for="email">Email</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="email" id="email" type="email" value="{{ old('email') ?? $vendor->email }}" placeholder="Email">
                        <x-input-error class="text-red-300" field="email" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-2" for="phone_number">Phone Number</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="phone_number" id="phone_number" type="text" value="{{ old('phone_number') ?? $vendor->phone_number }}" placeholder="Email">
                        <x-input-error class="text-red-300" field="phone_number" />
                    </div>
                    <button class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Save Changes
                    </button>
                </form>

                <form action="{{ route('vendor.update', $vendor->username) }}" method="POST" class="mt-8 py-4 px-4 bg-slate-100 text-gray-700 rounded-lg md:px-6">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="update_type" value="password">
                    <div class="mb-8">
                        <label class="block font-medium mb-2" for="old_password">Old Password</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="old_password" id="old_password" type="password" placeholder="Old Password">
                        <x-input-error class="text-red-300" field="old_password" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-2" for="password">New Password</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="password" id="password" type="password" placeholder="New Password">
                        <x-input-error class="text-red-300" field="password" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-2" for="password_confirmation">Confirm Password</label>
                        <input class="border rounded w-full py-2 px-3 leading-tight focus:outline-blue-500 focus:outline-2" name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Password">
                    </div>
                    <button class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Change Password
                    </button>
                </form>
            </div>
        </div>

    </section>
</x-vendor-layout>