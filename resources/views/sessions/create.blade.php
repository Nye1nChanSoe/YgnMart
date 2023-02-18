<x-layout>
    <div class="container mx-auto flex justify-between items-center my-10 px-8 space-x-6 md:px-16">
        <div class="hidden self-stretch basis-1/2 md:flex md:items-center md:justify-center">
            <img src="images/creative/shopmore_savemoney.png" alt="">
        </div>
        <x-card class="text-slate-700 p-10 basis-1/2">
            {{-- TODO: Socialite for OAuth Sign in --}}
            <h2 class="text-center text-2xl font-semibold mb-8">Sign in</h2>
            <form action="/login" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-2">
                    <div>
                        <label for="email" class="block mb-1.5">Email</label>
                        <input type="email" id="email" name="email" class="w-full p-1.5 rounded outline-1 outline-slate-400" value="{{old('email')}}">
                        <x-input-error field="email" />
                    </div>
                    <div>
                        <label for="password" class="block mb-1.5">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-1.5 rounded outline-1 outline-slate-400">
                        <x-input-error field="password" />
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <x-button>Sign in</x-button>
                    <p>Don't have an account? <a href="/register" class="text-blue-500 hover:text-blue-700">Register</a></p>
                </div>
            </form>
        </x-card>
    </div>
</x-layout>