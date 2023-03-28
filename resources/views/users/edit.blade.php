<x-profile-layout>
    <x-container class="flex justify-center mt-8">

        <!-- Sidebar -->
        <x-profile-sidebar :user="$user" />

        <div 
            x-data="{
                open: false,
                open_edit: false,
                open_delete: false,
            }" 
            class="w-full md:w-3/4 md:px-4"
        >
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

            <div id="address" class="bg-white rounded-lg mt-8 shadow-md py-4 px-4 md:px-6">
                <h1 class="mb-6 font-medium text-xl">Addresses</h1>
                @unless ($addresses->isEmpty())
                <form action="{{ route('address.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="default_update" value="1">
                    @foreach ($addresses as $address)
                    <div class="flex flex-col items-start space-y-2.5 py-4 text-sm md:text-base md:space-y-0 md:flex-row md:items-center">
                        <div class="flex items-center gap-x-1.5">
                            <input type="radio" name="default_address" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} class="self-start mt-1 md:mt-0 md:self-auto">
                            <span class="text-xs text-gray-600 pr-2 self-start md:self-auto">{{ $address->label }}</span>
                            <p class="text-gray-700">{{$address->full_address}}</p>
                        </div>
                        <div class="flex items-center">
                            <a 
                                @@click="
                                    open_edit = true, 
                                    $refs.address_id_edit.value = '{{$address->id}}'
                                    $refs.label.value = '{{$address->label}}'
                                    $refs.street.value = '{{$address->street}}'
                                    $refs.ward.value = '{{$address->ward}}'
                                    $refs.township.value = '{{$address->township}}'
                                " 
                                class="ml-4 flex items-center gap-x-1 text-amber-500 hover:text-amber-700"
                            >
                                <x-icon name="edit" class="inline" /><span class="text-sm cursor-pointer">Edit</span>
                            </a>
                            <a 
                                @@click="
                                    open_delete = true, 
                                    $refs.address_id_delete.value = '{{$address->id}}'
                                " 
                                class="ml-4 flex items-center gap-x-1 text-red-500 hover:text-red-700"
                            >
                                <x-icon name="delete" class="inline" /><span class="text-sm cursor-pointer">Delete</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    <div class="my-4">
                        <button x-on:click="open = !open" type="button" class="flex items-center gap-x-1.5">
                            <x-icon name="plus" class="inline" />
                            <span class="text-lime-600 hover:text-lime-700">Add new address</span>
                        </button>
                    </div>
                    <button type="submit" class="block bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Set Default
                    </button>
                </form>
                @else
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="settings" value="1">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="label">Label</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="label" id="label" type="text" value="" placeholder="Home, Work, School...">
                        <x-input-error field="label" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="street">Street</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="street" id="street" type="text" value="" placeholder="The name of your street">
                        <x-input-error field="street" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="ward">Ward</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="ward" id="ward" type="text" value="" placeholder="Ward number">
                        <x-input-error field="ward" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="township">Township</label>
                        <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="township" id="township" type="text" value="" placeholder="The name of your township">
                        <x-input-error field="township" />
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Save Address
                    </button>
                </form>
                @endif
            </div>

            <div x-data="{open:false}" class="mt-16">
                <button x-on:click="open=!open" class="flex items-center gap-x-4 text-gray-500 hover:text-blue-600">
                    <span>I want to delete my account</span>
                    <x-icon name="chevron-down" x-bind:class="{ '-rotate-180 duration-400':open }" />
                </button>
                <div x-show="open" class="mt-6" x-cloak x-transition>
                    <x-warning class="text-gray-700">
                        Before deleting your user account, it's important to understand the potential consequences of doing so. Deleting your account may result in the permanent loss of all data and information associated with your account.
                        <span class="text-red-500">Deleted Accounts Will Be Permanently Lost Within <span class="font-medium">14 Days</span></span>
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

            <!-- Blur Background -->
            <div x-show="open || open_edit || open_delete" class="fixed inset-0 bg-gray-700 bg-opacity-50" x-cloak></div>
            
            <!-- Models -->
            <div x-show="open" class="fixed z-10 inset-0 overflow-y-auto" x-cloak x-transition>
                <div class="flex items-center justify-center min-h-screen">
                    <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg px-4 py-3 md:px-8 md:py-5">
                        <div class="relative">
                            <h1 class="text-center text-gray-700 font-medium md:text-lg">Add New Address</h1>
                            <button x-on:click="open = false" class="absolute top-1.5 right-1.5"><x-icon name="close" class="text-gray-600 hover:text-blue-600" /></button>
                        </div>
                        <form action="{{ route('address.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="label">Label</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="label" id="label" type="text" value="" placeholder="Home, Work, School...">
                                <x-input-error field="label" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="street">Street</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="street" id="street" type="text" value="" placeholder="The name of your street">
                                <x-input-error field="street" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="ward">Ward</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="ward" id="ward" type="text" value="" placeholder="Ward number">
                                <x-input-error field="ward" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="township">Township</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="township" id="township" type="text" value="" placeholder="The name of your township">
                                <x-input-error field="township" />
                            </div>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                                Add Address
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="open_edit" class="fixed z-10 inset-0 overflow-y-auto" x-cloak x-transition>
                <div class="flex items-center justify-center min-h-screen">
                    <div class="relative bg-white w-full max-w-md mx-auto rounded shadow-lg px-4 py-3 md:px-8 md:py-5">
                        <div class="relative">
                            <h1 class="text-center text-gray-700 font-medium md:text-lg">Update the Address</h1>
                            <button x-on:click="open_edit = false" class="absolute top-1.5 right-1.5"><x-icon name="close" class="text-gray-600 hover:text-blue-600" /></button>
                        </div>
                        <form action="{{ route('address.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" x-ref="address_id_edit" name="id">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="label">Label</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="label" id="label" type="text" value="" placeholder="Home, Work, School..." x-ref="label">
                                <x-input-error field="label" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="street">Street</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="street" id="street" type="text" value="" placeholder="The name of your street" x-ref="street">
                                <x-input-error field="street" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="ward">Ward</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="ward" id="ward" type="text" value="" placeholder="Ward number" x-ref="ward">
                                <x-input-error field="ward" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2" for="township">Township</label>
                                <input class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" name="township" id="township" type="text" value="" placeholder="The name of your township" x-ref="township">
                                <x-input-error field="township" />
                            </div>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                                Edit Address
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="open_delete" class="fixed z-10 inset-0 overflow-y-auto" x-cloak x-transition>
                <div class="flex items-center justify-center min-h-screen">
                    <div class="relative bg-white w-full max-w-sm mx-auto rounded-lg shadow-lg px-2 py-3">
                        <div class="relative pb-6">
                            <h1 class="text-center text-gray-700 font-medium md:text-lg">Are you sure?</h1>
                            <button x-on:click="open_delete = false" class="absolute top-1 right-1.5"><x-icon name="close" class="text-gray-600 hover:text-blue-600" /></button>
                        </div>
                        <form action="{{ route('address.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" x-ref="address_id_delete" name="id">
                            <div class="flex justify-center items-center pt-3 border-t">
                                <button type="button" x-on:click="open_delete = false" class="flex-1 text-center text-gray-600 hover:text-black">Cancel</button>
                                <button type="submit" class="flex-1 text-center text-red-500 hover:text-red-700">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </x-container>
</x-profile-layout>