<x-layout>
    <div class="container mx-auto flex justify-between items-center my-10 px-8 space-x-6 md:px-16">
        <div class="hidden self-stretch basis-1/2 md:flex md:items-center md:justify-center">
            <img src="images/grocery/apple.jpeg" alt="">
        </div>
        <x-card class="text-slate-700 p-10 basis-1/2">
            <h2 class="text-center text-2xl font-semibold mb-8">Create an Account</h2>
            <form action="/register" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                    <div>
                        <label for="name" class="block mb-1.5">Name <span class="text-red-300">*</span></label>
                        <input type="text" id="name" name="name" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('name')}}">
                        <x-input-error field="name"></x-input-error>
                    </div>
                    <div>
                        <label for="username" class="block mb-1.5">Username <span class="text-red-300">*</span></label>
                        <input type="text" id="username" name="username" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('username')}}">
                        <x-input-error field="username"></x-input-error>
                    </div>
                    <div>
                        <label for="email" class="block mb-1.5">Email <span class="text-red-300">*</span></label>
                        <input type="email" id="email" name="email" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('email')}}">
                        <x-input-error field="email"></x-input-error>
                    </div>
                </div>
                <div class="space-y-2">
                    <div>
                        <label for="password" class="block mb-1.5">Password <span class="text-red-300">*</span></label>
                        <input type="password" id="password" name="password" class="w-full p-1.5 rounded outline-1 outline-slate-400">
                        <x-input-error field="password"></x-input-error>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block mb-1.5">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"class="w-full p-1.5 rounded outline-1 outline-slate-400">
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                    <div>
                        <label for="phone_number" class="block mb-1.5">Mobile Number <span class="text-red-300">*</span></label>
                        <input type="text" id="phone_number" name="phone_number" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('mobile')}}">
                        <x-input-error field="phone_number"></x-input-error>
                    </div>
                    <div>
                        <label for="street" class="block mb-1.5">Street</label>
                        <input type="text" id="street" name="street" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('street')}}">
                        <x-input-error field="street"></x-input-error>
                    </div>
                    <div>
                        <label for="ward" class="block mb-1.5">Ward</label>
                        <input type="text" id="ward" name="ward" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('ward')}}">
                        <x-input-error field="ward"></x-input-error>
                    </div>
                    <div>
                        <label for="township" class="block mb-1.5">Township</label>
                        <input type="text" id="township" name="township" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('township')}}">
                        <x-input-error field="township"></x-input-error>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <x-button>Sign up</x-button>
                    <p>Already have an account? <a href="/login" class="text-blue-500 hover:text-blue-700">Login</a></p>
                </div>
            </form>
        </x-card>
    </div>
</x-layout>