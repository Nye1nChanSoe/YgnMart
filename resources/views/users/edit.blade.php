<x-profile-layout>
    <x-container class="flex justify-center mt-8">

        <!-- Sidebar -->
        <x-profile-sidebar :user="$user" />

        <div class="w-full md:w-3/4 md:px-4">
            <form action="{{ route('user.update.info') }}" method="POST" class="bg-white rounded-lg shadow-md py-4 px-4 md:px-6">
                @method('PATCH')
                @csrf
                <input type="hidden" name="update_type" value="info">
                <h1 class="mb-6 font-medium text-xl">Edit Settings</h1>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="username">Username</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="username" id="username" type="text" value="{{ $user->username }}" placeholder="Username">
                    <x-input-error field="username" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="name">Name</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="name" id="name" type="text" value="{{ $user->name }}" placeholder="Name">
                    <x-input-error field="name" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="email" id="email" type="email" value="{{ $user->email }}" placeholder="Email">
                    <x-input-error field="email" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="phone_number">Phone Number</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="phone_number" id="phone_number" type="text" value="{{ $user->phone_number }}" placeholder="Email">
                    <x-input-error field="phone_number" />
                </div>
                <button class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                    Save Changes
                </button>
            </form>

            <form action="{{ route('user.update.password') }}" method="POST" class="bg-white rounded-lg mt-8 shadow-md py-4 px-4 md:px-6">
                @method('PATCH')
                @csrf
                <input type="hidden" name="update_type" value="password">
                <div class="mb-8">
                    <label class="block text-gray-700 font-medium mb-2" for="old_password">Old Password</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="old_password" id="old_password" type="password" placeholder="Old Password">
                    <x-input-error field="old_password" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="password">New Password</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="password" id="password" type="password" placeholder="New Password">
                    <x-input-error field="password" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="password_confirmation">Confirm Password</label>
                    <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Password">
                </div>
                <button class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                    Change Password
                </button>
            </form>

            <div id="edit-address" class="bg-white rounded-lg mt-8 shadow-md py-4 px-4 md:px-6">
                <h1 class="mb-6 font-medium text-xl">Addresses</h1>
                @unless ($addresses->isEmpty())
                <form action="" method="POST">
                    @csrf
                    @foreach ($addresses as $address)
                    <div class="flex flex-col items-start space-y-2 py-2.5 text-sm md:text-base md:space-y-0 md:flex-row md:items-center">
                        <div class="flex items-center gap-x-1.5">
                            <input type="hidden" name="address" value="{{ $address->id }}">
                            <input type="radio" name="defaultAddress" value="yes">
                            <p class="text-gray-700">{{$address->full_address}}</p>
                        </div>
                        <div class="flex items-center">
                            <a class="ml-4 flex items-center gap-x-1 text-amber-500 hover:text-amber-700">
                                <x-icon name="edit" class="inline" /><span class="text-sm">Edit</span>
                            </a>
                            <a class="ml-4 flex items-center gap-x-1 text-red-500 hover:text-red-700">
                                <x-icon name="delete" class="inline" /><span class="text-sm">Delete</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    <div class="my-4">
                        <button type="button" class="flex items-center gap-x-1.5">
                            <x-icon name="plus" class="inline" />
                            <span class="text-lime-600 hover:text-lime-700">Add new address</span>
                        </button>
                    </div>
                    <button type="submit" class="block bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Set Default
                    </button>
                </form>
                @else
                <form action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="label">Label</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outeline-blue-400 focus:shadow-outline" name="label" id="label" type="text" placeholder="Home, Work, School...">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="street">Street</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outeline-blue-400 focus:shadow-outline" name="street" id="street" type="text" placeholder="The name of your street">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="ward">Ward</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outeline-blue-400 focus:shadow-outline" name="label" id="label" type="text" placeholder="Ward number">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="township">Township</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outeline-blue-400 focus:shadow-outline" name="label" id="label" type="text" placeholder="The name of your township">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Save Address
                    </button>
                </form>
                @endif
            </div>

            <div class="mt-16">
                <x-warning class="text-gray-700">
                    Before deleting your user account, it's important to understand the potential consequences of doing so. Deleting your account may result in the permanent loss of all data and information associated with your account
                    <ul class="text-sm mt-3 space-y-2 md:text-base">
                        <li class="flex"><span class="mr-2">1.</span><p>Your personal information such as name, email, phone number, etc.</p></li>
                        <li class="flex"><span class="mr-2">2.</span><p>Your saved preferences, settings and configurations.</p></li>
                        <li class="flex"><span class="mr-2">3.</span><p>Any content or data that you have created or uploaded, such as posts, comments, photos, videos, etc.</p></li>
                        <li class="flex"><span class="mr-2">4.</span><p>Access to any subscriptions, services, or products that are linked to your account.</p></li>
                    </ul>
                </x-warning>
                <form action="{{ route('user.destroy') }}" method="POST" class="mt-4">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="text-white bg-red-500 px-3 py-2 rounded-lg hover:bg-red-700">Delete Account</button>
                </form>
            </div>
        </div>
    </x-container>
</x-profile-layout>