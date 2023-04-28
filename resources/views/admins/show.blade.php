<x-admin-layout>
    <x-slot:title>
        {{ $user->name }} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.show', $user->username) }}" class="{{ request()->routeIs(['admin.show', 'admin.settings']) ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Profile</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">

        <div class="flex justify-around my-8 px-10">
            <div class="flex flex-col items-center">
                <div id="image-container" class="flex items-center justify-center border rounded-full w-32 h-32 dark:border-gray-700">
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
                    @else
                    <div class="flex items-center justify-center gap-x-1.5">Status <div class="bg-red-400 inline-block rounded-full px-1 py-1 w-fit "></div></div>
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
                <form action="{{ route('admin.update', $user->username) }}" method="POST" enctype="multipart/form-data" class="mb-6 flex flex-col items-center sm:block">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-x-2.5 items-center mt-4">
                        <input type="hidden" name="update_type" value="image">
                        <input class="block w-fit text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400" name="image" type="file" onchange="previewImage(event)">
                        <button type="submit" class="bg-blue-500 text-white py-1 px-2 rounded-lg text-sm hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">Upload</button>
                    </div>
                    <p class="mt-3 text-sm text-gray-300 dark:text-gray-200 text-center sm:text-start">PNG, JPG, Webp or SVG (MAX. 2000x200px).</p>
                </form>
                <script>
                    function previewImage(event) {
                        var img = event.target.files[0];
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.querySelector('#image-container img').setAttribute('src', e.target.result);
                        }
                        reader.readAsDataURL(img);
                    }
                </script>
                <form action="{{ route('admin.update', $user->username) }}" method="POST" class="py-4 px-4 bg-slate-600 rounded-lg text-gray-100 md:px-6">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="update_type" value="info">
                    <h1 class="mb-6 font-medium text-xl">Edit Settings</h1>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="username">Username</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="username" id="username" type="text" value="{{ old('username') ?? $user->username }}" placeholder="Username">
                        <x-input-error class="text-red-300" field="username" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="name">Name</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="name" id="name" type="text" value="{{ old('name') ?? $user->name }}" placeholder="Name">
                        <x-input-error class="text-red-300" field="name" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="email">Email</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="email" id="email" type="email" value="{{ old('email') ?? $user->email }}" placeholder="Email">
                        <x-input-error class="text-red-300" field="email" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="phone_number">Phone Number</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="phone_number" id="phone_number" type="text" value="{{ old('phone_number') ?? $user->phone_number }}" placeholder="Phone Number">
                        <x-input-error class="text-red-300" field="phone_number" />
                    </div>
                    <button class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Save Changes
                    </button>
                </form>

                <form action="{{ route('admin.update', $user->username) }}" method="POST" class="mt-8 py-4 px-4 bg-slate-600 rounded-lg text-gray-100 md:px-6">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="update_type" value="password">
                    <div class="mb-8">
                        <label class="block text-gray-100 font-medium mb-2" for="old_password">Old Password</label>
                        <input class="border rounded w-full py-2 px-3 bg-slate-200 text-black placeholder-slate-500 leading-tight focus:outline-blue-500 focus:outline-2" name="old_password" id="old_password" type="password" placeholder="Old Password">
                        <x-input-error class="text-red-300" field="old_password" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="password">New Password</label>
                        <input class="border rounded w-full py-2 px-3 bg-slate-200 text-black placeholder-slate-500 leading-tight focus:outline-blue-500 focus:outline-2" name="password" id="password" type="password" placeholder="New Password">
                        <x-input-error class="text-red-300" field="password" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="password_confirmation">Confirm Password</label>
                        <input class="border rounded w-full py-2 px-3 bg-slate-200 text-black placeholder-slate-500 leading-tight focus:outline-blue-500 focus:outline-2" name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Password">
                    </div>
                    <button class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Change Password
                    </button>
                </form>
            </div>
        </div>

    </section>
</x-admin-layout>