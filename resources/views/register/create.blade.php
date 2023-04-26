<x-layout>
    <x-slot:title>
        Register - YangonMart.com
    </x-slot:title>
    <x-container class="mb-10">
        <ul class="flex items-center my-3 px-3 py-3 text-sm">
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Login</a><x-icon name="chevron-right" class="dark:text-gray-200"/>
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Register</a>
            </li>
        </ul>
    </x-container>
    <x-container class="flex flex-col justify-center md:flex-row md:justify-around">
        <div class="hidden self-stretch basis-1/2 md:flex md:flex-col md:items-center md:justify-center">
            <div class="px-6 py-4 rounded-lg mb-4 md:px-20">
                <p class="text-center text-lg text-gray-700 dark:text-gray-400">
                    Are you a <span class="underline decoration-sky-500 decoration-2 font-medium"><a href="{{ route('vendor.register') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500">vendor / supplier</a></span> looking for a platform to reach a wider audience and increase sales? 
                </p>
                <p class="text-center text-gray-600 mt-2 dark:text-gray-400">
                    <a href="{{ route('vendor.register') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500">Join us </a> today and take advantage of our user-friendly interface and extensive customer base.
                </p>
            </div>
            <img src="images/creative/shopmore_savemoney.png" alt="" width="500">
        </div>
        <x-card class="text-slate-700 dark:text-gray-300 w-full p-6 md:p-10 md:basis-2/5 dark:bg-slate-800">
            <h2 class="text-center text-2xl font-semibold mb-6 dark:text-gray-300">Create an Account</h2>
            <form action="/register" method="POST">
                @csrf
                <div class="space-y-3">
                    <h3 class="text-lg text-stone-600 font-semibold mb-2 dark:text-gray-300">Personal Information</h3>
                    <div>
                        <label for="name" class="block mb-1 text-gray-400 dark:text-gray-300">Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" value="{{old('name')}}" placeholder="Full name...">
                        <x-input-error field="name" />
                    </div>
                    <div>
                        <label for="email" class="block mb-1 text-gray-400 dark:text-gray-300">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" value="{{old('email')}}" placeholder="Email address...">
                        <x-input-error field="email" class="text-red-400" />
                    </div>
                    <div>
                        <label for="phone_number" class="block mb-1 text-gray-400 dark:text-gray-300">Mobile Number <span class="text-red-400">*</span></label>
                        <input type="text" id="phone_number" name="phone_number" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" value="{{old('phone_number')}}" placeholder="Mobile number...">
                        <x-input-error field="phone_number" class="text-red-400" />
                    </div>
                </div>
                <div class="space-y-3 mt-10 dark:text-white">
                    <div>
                        <label for="password" class="block mb-1 text-gray-400 dark:text-gray-300">Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="Password...">
                        <x-input-error field="password" class="dark:text-red-400" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block mb-1 text-gray-400 dark:text-gray-300">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="Confirm password...">
                    </div>
                </div>
                <div class="flex flex-col justify-between items-center mt-6 md:flex-row">
                    <button type="submit" class="p-1.5 px-4 text-lg rounded text-white bg-blue-500 w-full hover:bg-blue-700 md:w-fit dark:bg-blue-700 dark:hover:bg-blue-600">Sign up</button>
                    <p class="mt-4 md:mt-0 dark:text-gray-400">Already have an account? <a href="/login" class="text-blue-500 hover:text-blue-700 dark:text-gray-300 dark:hover:text-gray-100">Login</a></p>
                </div>
            </form>
        </x-card>
    </x-container>
</x-layout>