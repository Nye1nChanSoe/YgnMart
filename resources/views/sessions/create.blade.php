<x-layout class="dark:bg-gray-900">
    <x-slot:title>
        Sign in - YangonMart.com
    </x-slot:title>
    <x-container class="flex bg-tablet flex-col py-8 justify-center md:mt-20 md:flex-row md:justify-between">
        <div class="hidden flex-shrink-0 self-stretch md:basis-1/2 md:flex md:items-center md:justify-center">
            <img src="images/creative/shopmore_savemoney.png" alt="" width="340">
        </div>
        <div class="self-center w-full z-10 md:w-[460px]">
            <x-card class="text-slate-700 py-4 px-6 md:py-10 md:px-10 dark:bg-gray-800">
                {{-- TODO: Socialite for OAuth Sign in --}}
                <h2 class="text-center text-2xl font-semibold mb-4 md:mb-8 dark:text-gray-300">Sign in</h2>
                <form action="/login" method="POST" class="space-y-6 md:space-y-8">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label for="email" class="block mb-1.5 dark:text-gray-300">Email</label>
                            <input type="email" id="email" name="email" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" value="{{old('email')}}" placeholder="example@email.com">
                            <x-input-error field="email" />
                        </div>
                        <div>
                            <label for="password" class="block mb-1.5 dark:text-gray-300">Password</label>
                            <input type="password" id="password" name="password" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="Password...">
                            <x-input-error field="password" />
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center md:flex-row md:justify-between">
                        <x-button class="w-full mb-2 md:mb-0 md:w-fit bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600">Sign in</x-button>
                        <p class="mt-2 md:mt-0 dark:text-gray-400">Don't have an account? <a href="/register" class="text-blue-500 hover:text-blue-700 dark:text-gray-200 dark:hover:text-gray-50">Register</a></p>
                    </div>
                </form>
            </x-card>
            <div class="mt-4 text-right text-gray-600 dark:text-gray-400">
                <p><a href="{{ route('vendor.login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500">Login</a> as a vendor</p>
            </div>
        </div>
    </x-container>
</x-layout>