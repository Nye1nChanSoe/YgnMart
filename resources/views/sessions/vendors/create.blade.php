<x-layout>
    <x-slot:title>
        Vendor Sign in - YangonMart.com
    </x-slot:title>
    <x-container class="flex flex-col py-8 justify-center md:flex-row md:justify-around">
        <div class="hidden self-stretch md:basis-1/2 md:flex md:items-center md:justify-center">
            <img src="{{ asset('/images/vendor.png') }}" alt="" width="500">
        </div>
        <x-card class="self-center w-full text-slate-700 py-4 px-6 md:py-10 md:px-10 md:basis-2/5">
            {{-- TODO: Socialite for OAuth Sign in --}}
            <h2 class="text-center text-2xl font-semibold mb-4 md:mb-8">Sign in</h2>
            <form action="/vendor/login" method="POST" class="space-y-6 md:space-y-8">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label for="email" class="block mb-1.5">Email</label>
                        <input type="email" id="email" name="email" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('email')}}" placeholder="example@email.com">
                        <x-input-error field="email" />
                    </div>
                    <div>
                        <label for="password" class="block mb-1.5">Password</label>
                        <input type="password" id="password" name="password" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" placeholder="Password...">
                        <x-input-error field="password" />
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center md:flex-row md:justify-between">
                    <div class="md:basis-1/2 mb-2 md:mb-0">
                        <x-button class="w-full md:w-fit">Sign in</x-button>
                    </div>
                    <p class="mt-2 md:mt-0">Sell your products on Yangon Mart? <a href="{{ route('vendor.register') }}" class="text-blue-500 hover:text-blue-700">Register</a></p>
                </div>
            </form>
        </x-card>
    </x-container>
</x-layout>