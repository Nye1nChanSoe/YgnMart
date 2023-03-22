<x-layout>
    <x-slot:title>
        Register - YangonMart.com
    </x-slot:title>
    <x-container class="flex flex-col justify-center md:flex-row md:justify-around">
        <div class="hidden self-stretch basis-1/2 md:flex md:flex-col md:items-center md:justify-center">
            <img src="images/creative/shopmore_savemoney.png" alt="">
        </div>
        <x-card class="text-slate-700 w-full p-6 md:p-10 md:basis-2/5">
            <h2 class="text-center text-2xl font-semibold mb-8">Create an Account</h2>
            <form action="/register" method="POST">
                @csrf
                <div class="space-y-3">
                    <h3 class="text-lg text-stone-600 font-semibold mb-2">Personal Information</h3>
                    <div>
                        <label for="name" class="block mb-1">Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" class="w-full border-2 border-blue-200 border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('name')}}" placeholder="Full name...">
                        <x-input-error field="name"></x-input-error>
                    </div>
                    <div>
                        <label for="email" class="block mb-1">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('email')}}" placeholder="Email address...">
                        <x-input-error field="email"></x-input-error>
                    </div>
                    <div>
                        <label for="phone_number" class="block mb-1">Mobile Number <span class="text-red-400">*</span></label>
                        <input type="text" id="phone_number" name="phone_number" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('phone_number')}}" placeholder="Mobile number...">
                        <x-input-error field="phone_number"></x-input-error>
                    </div>
                </div>
                <div class="space-y-3 mt-10">
                    <div>
                        <label for="password" class="block mb-1">Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" placeholder="Password...">
                        <x-input-error field="password"></x-input-error>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block mb-1">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" placeholder="Confirm password...">
                    </div>
                </div>
                <div class="flex flex-col justify-between items-center mt-6 md:flex-row">
                    <button type="submit" class="p-1.5 px-4 text-lg rounded text-white bg-blue-500 w-full hover:bg-blue-700 md:w-fit">Sign up</button>
                    <p class="mt-4 md:mt-0">Already have an account? <a href="/login" class="text-blue-500 hover:text-blue-700">Login</a></p>
                </div>
            </form>
        </x-card>
    </x-container>
</x-layout>