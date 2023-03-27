<x-layout>
    <x-slot:title>
        Register - YangonMart.com
    </x-slot:title>
    <x-container class="flex flex-col justify-center md:flex-row md:justify-around">
        <div class="hidden self-stretch basis-1/2 md:flex md:flex-col md:items-center md:justify-center">
            <div class="px-6 py-4 rounded-lg mb-4 md:px-20">
                <p class="text-center text-lg text-gray-700">
                    Are you a <span class="underline decoration-sky-500 decoration-2 font-medium">vendor / supplier</span> looking for a platform to reach a wider audience and increase sales? 
                </p>
                <p class="text-center text-gray-600 mt-2">
                    Join us today and take advantage of our user-friendly interface and extensive customer base.
                </p>
            </div>
            <img src="{{ asset('/images/vendor.png') }}" alt="">
        </div>
        <div class="block w-full mb-8 md:hidden">
            <div class="px-6 py-4 rounded-lg mb-4 md:px-20">
                <p class="text-center text-lg text-gray-700">
                    Are you a <span class="underline decoration-sky-500 decoration-2 font-medium">vendor / supplier</span> looking for a platform to reach a wider audience and increase sales? 
                    
                </p>
                <p class="text-center text-gray-600 mt-6">
                    Join us today and take advantage of our user-friendly interface and extensive customer base.
                </p>
            </div>
        </div>
        <x-card class="text-slate-700 w-full p-6 bg-sky-700 md:p-10 md:basis-2/5">
            <h2 class="text-center text-2xl text-white font-semibold mb-8">Create an vendor / supplier Account</h2>
            <form action="/vendor/register" method="POST">
                @csrf
                <div class="space-y-3">
                    <h3 class="text-lg text-white font-semibold mb-2">Personal Information</h3>
                    <div>
                        <label for="name" class="text-white block mb-1">Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('name')}}" placeholder="Account name...">
                        <x-input-error field="name" />
                    </div>
                    <div>
                        <div x-data="{open:false}" class="relative flex items-center justify-between mb-1">
                            <label for="brandname" class="text-white">Brand Name </label>
                            <x-icon name="info" class="ml-1 inline text-blue-200 hover:text-white" x-on:mouseover="open = true" x-on:mouseleave="open = false" />
                            <div x-show="open" class="absolute top-6 right-0 px-4 py-2 bg-amber-100 rounded-lg shadow" x-transition x-cloak x-on:mouseover="open = true" x-on:mouseleave="open = false">
                                <p class="text-gray-700 text-sm">If you omitted the brand name, it will display as <span class="font-medium">"Local brand"</span></p>
                            </div>
                        </div>
                        <input type="brand" id="brand" name="brand" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('brand')}}" placeholder="Brand name...">
                        <x-input-error field="brand" />
                    </div>
                    <div>
                        <label for="email" class="text-white block mb-1">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('email')}}" placeholder="Email..">
                        <x-input-error field="email" />
                    </div>
                    <div>
                        <label for="phone_number" class="text-white block mb-1">Mobile Number <span class="text-red-400">*</span></label>
                        <input type="text" id="phone_number" name="phone_number" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('phone_number')}}" placeholder="Mobile number...">
                        <x-input-error field="phone_number" />
                    </div>
                </div>
                <div class="space-y-3 mt-10">
                    <div>
                        <label for="password" class="text-white block mb-1">Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" placeholder="Password...">
                        <x-input-error field="password" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="text-white block mb-1">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" placeholder="Confirm password...">
                    </div>
                </div>
                <div class="flex flex-col justify-between items-center mt-6 md:flex-row">
                    <button type="submit" class="p-1.5 px-4 text-lg rounded text-white bg-orange-500 w-full hover:bg-orange-600 md:w-fit">Sign up</button>
                    <p class="mt-4 text-white md:mt-0">Already have one? <a href="{{ route('vendor.login') }}" class="ml-2 rounded-lg px-2 py-1.5 bg-blue-400 text-white hover:bg-blue-500">Login</a></p>
                </div>
            </form>
        </x-card>
    </x-container>
</x-layout>