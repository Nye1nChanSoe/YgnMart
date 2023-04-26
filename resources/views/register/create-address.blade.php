<x-layout>
    <x-container class="mb-10">
        <ul class="flex items-center my-3 py-3 text-sm">
            <li class="flex items-center gap-x-1">
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Login</a><x-icon name="chevron-right" class="dark:text-gray-200"/>
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Register</a><x-icon name="chevron-right" class="dark:text-gray-200"/>
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('register') }}" class="text-blue-600 dark:text-gray-400 dark:hover:text-blue-500">Register Address</a>
            </li>
        </ul>
    </x-container>
    <x-container>
        <form action="{{ route('register.store.address') }}" method="POST" class="flex items-center justify-center p-2 md:p-10">
            @csrf
            <div class="bg-white rounded-lg shadow-lg px-4 py-4 w-80 md:px-10 md:w-128 dark:bg-gray-900">
                <h3 class="text-lg font-bold text-center dark:text-gray-300">Address</h3>
                <div class="px-3 py-2 border rounded-lg my-3 md:my-5 dark:border-gray-600">
                    <x-icon name="info" class="text-blue-500 inline-block"/>
                    <span class="text-gray-600 text-xs md:text-sm dark:text-gray-400">You can skip this for now and fill them out later when you're ready to make a purchase</span></p>
                </div>
                <div>
                    <div class="space-y-1.5 md:space-y-2.5">
                        <div>
                            <label for="street" class="block mb-1 dark:text-white">Street</label>
                            <input type="text" id="street" name="street" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{old('street')}}" placeholder="Street...">
                            <x-input-error field="street" />
                        </div>
                        <div>
                            <label for="ward" class="block mb-1 dark:text-white">Ward</label>
                            <input type="text" id="ward" name="ward" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{old('ward')}}" placeholder="Ward...">
                            <x-input-error field="ward" />
                        </div>
                        <div>
                            <label for="township" class="block mb-1 dark:text-white">Township</label>
                            <input type="text" id="township" name="township" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400 dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{old('township')}}" placeholder="Township...">
                            <x-input-error field="township" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="p-1.5 px-3 text-base rounded text-white bg-blue-500 w-fit hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-500">Add Address</button>
                        <button id="btn-skip" type="button" class="text-amber-500 hover:text-amber-700 text-sm md:text-base dark:text-gray-400 dark:hover:text-white">
                            <span>Skip</span>
                            <x-icon name="arrow-right" class="inline" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-container>
</x-layout>

<script>
    const skip = document.getElementById('btn-skip');
    skip.addEventListener('click', function(event) {
        console.log('skio');
        window.location.href = '{{ route("register.address.skip") }}';
    })
</script>