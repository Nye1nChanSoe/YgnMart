<x-layout>
    <x-slot:title>
        {{ $user->name }} - YangonMart.com
    </x-slot:title>
    <x-container class="flex justify-center mt-8">

        <!-- Sidebar -->
        <x-profile-sidebar :user="$user" />

          <!-- Main Content Area -->
          <div class="w-full md:w-3/4 md:px-4">
            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow-md py-4 px-4 md:px-6 dark:bg-gray-900">
                <div class="flex items-center justify-around md:justify-start">
                    <div class="flex flex-col items-center">
                        <div class="py-2 border rounded-full w-20 overflow-hidden object-cover md:w-32 md:py-4 md:px-18 dark:border-gray-700">
                            <img src="{{$user->image ? asset($user->image) : asset('images/no-image.png')}}" alt="" style="max-width: 100%; max-height:100%; object-fit:contain">
                        </div>
                        <button id="edit" class="mt-4 px-3 py-1.5 rounded-lg text-sm text-white bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Edit profile</button>
                    </div>
                    <div class="text-left text-sm md:ml-12">
                        <h2 class="text-lg mb-1 font-medium md:text-xl md:mb-2 dark:text-gray-200">{{ $user->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-400"><span class="mr-1">@</span>{{ $user->username }}</p>
                        <div class="space-y-1 mt-3 md:mt-8 md:space-y-2">
                            <div class="flex items-center gap-x-2 md:gap-x-3">
                                <x-icon name="mail" class="text-gray-700 dark:text-gray-300" />
                                <p class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                            </div>
                            <div class="flex items-center gap-x-2 md:gap-x-3">
                                <x-icon name="telephone" class="text-gray-700 dark:text-gray-300" />
                                <p class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400"><a href="tel:{{$user->phone_number}}">{{ $user->phone_number }}</a></p>
                            </div>
                            @if (($address = $user->addresses)->count() > 0)
                            <div class="flex items-center gap-x-2 md:gap-x-3">
                                <x-icon name="location" class="text-gray-700 dark:text-gray-300" />
                                <p class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                    @php
                                        $addr = $address->where('is_default', true)->first();
                                    @endphp
                                    <a href="https://www.google.com/maps/place/{{urlencode($addr->township)}}" target="_blank">{{ $addr->full_address }}</a>
                                </p>
                            </div>
                            @else
                            <button id="btn-add-new-address" type="button" class="flex items-center gap-x-1.5">
                                <x-icon name="plus" class="inline dark:text-gray-200" />
                                <span class="text-lime-600 hover:text-lime-700 dark:text-lime-500 dark:hover:text-lime-400">Add new address</span>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div id="history" class="bg-white rounded-lg shadow-md mt-10 py-4 px-4 md:px-6 dark:bg-gray-900">
                <h2 class="text-base text-gray-700 font-semibold mb-4 text-center md:text-lg md:text-left dark:text-gray-200">Orders History</h2>
                @if ($orders->count() > 0)
                <div class="grid grid-cols-4 items-center justify-items-center border-b border-gray-200 font-semibold text-slate-700 py-2 text-sm md:text-base md:py-4 md:grid-cols-4 lg:grid-cols-5 dark:border-gray-700 dark:text-gray-300">
                    <div class="col-span-1">ID</div>
                    <div class="col-span-1">Order Code</div>
                    <div class="col-span-2 md:col-span-1">Time</div>
                    <div class="col-span-1 hidden lg:block">Payment Type</div>
                    <div class="col-span-1 hidden md:block">Total Price</div>
                </div>
                @foreach ($orders as $index => $order)
                <a href="{{ route('orders.show', ['order' => $order->order_code]) }}" class="grid grid-cols-4 items-center even:bg-blue-400 even:text-white rounded justify-items-center text-slate-700 py-2 text-sm hover:bg-slate-100 hover:text-black md:text-base md:py-3 md:grid-cols-4 lg:grid-cols-5 dark:text-gray-300 dark:bg-gray-900 dark:even:bg-blue-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                    <div class="col-span-1">{{ $index + 1 }}</div>
                    <div class="col-span-1">{{ $order->order_code }}</div>
                    <div class="col-span-2 md:col-span-1">
                        <time>{{\Carbon\Carbon::parse($order->created_at)->format('M j, Y')}}</time>
                    </div>
                    <div class="col-span-1 hidden lg:block">{{ $order->payment_type }}</div>
                    <div class="col-span-1 hidden md:block">{{number_format($order->total_price, 0, '.', ',')}}</div>
                </a>
                @endforeach
                @else
                <p class="text-gray-500 text-center md:text-left">You have no orders yet!</p>
                @endif
            </div>
          </div>
    </x-container>
</x-layout>

<script>
const edit = document.getElementById('edit');
edit.addEventListener('click', function(event) {
    window.location.href = '{{ route("profile.settings", ["user" => $user]) }}';
});
    
const addAddress = document.getElementById('btn-add-new-address');
if(addAddress) {
    addAddress.addEventListener('click', function(event) {
    window.location.href = `{{ route('profile.settings', ['user' => $user->username]) . '#address' }}`;
})
}
</script>