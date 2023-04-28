<x-layout>
    <x-slot:title>
        Order - YangonMart.com | {{$order->order_code}}
    </x-slot:title>
    <x-container>
        <ul class="flex items-center my-3 px-3 py-3 text-sm">
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Home</a><x-icon name="chevron-right" class="text-gray-200" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('profile', auth()->user()->username) }}" class="{{ request()->routeIs('profile') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Profile</a><x-icon name="chevron-right" class="text-gray-200" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('orders.show', $order->order_code) }}" class="{{ request()->routeIs('orders.show') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Order</a>
            </li>
        </ul>
        <div class="flex flex-col bg-blue-100 p-6 rounded-lg justify-center mt-6 lg:flex-row dark:bg-gray-900 dark:text-gray-300">
            <div class="flex-1">
                <div 
                    x-data="{
                        copied: false,
                    }" 
                    class="flex items-center bg-white p-3 shadow rounded-lg justify-center space-x-2 md:w-fit md:justify-start dark:bg-gray-800"
                >
                    <h1 class="font-bold text-lg">Order Number</h1>
                    <p class="text-lime-700 dark:text-lime-500">
                        #<input x-ref="orderCode" type="button" value="{{strtoupper($order->order_code)}}" class="focus:outline-none">
                    </p>
                    <div @@click="copyToClipboard" class="relative">
                        <x-icon name="clipboard" class="inline cursor-pointer hover:text-blue-700 dark:hover:text-blue-300" />
                        <div x-show="copied" class="absolute -top-10 right-0 border rounded-lg bg-white text-gray-700 py-1 px-2 dark:bg-gray-700 dark:text-gray-200 dark:border-0" x-cloak x-transition>Copied!</div>
                    </div>
                </div>

                <!-- Order Product Table -->
                <div class="px-4 rounded-lg bg-white shadow text-sm mt-3 lg:mr-6 text-slate-700 dark:bg-gray-800 dark:text-gray-300">
                    <div class="grid grid-cols-4 items-center justify-items-center border-b border-gray-200 font-semibold py-2 md:py-4 md:grid-cols-6 dark:border-b-gray-600">
                        <div class="col-span-2 justify-self-start md:col-span-3">Item</div>
                        <div class="col-span-1">Quantity</div>
                        <div class="hidden col-span-1 md:block">Price</div>
                        <div class="col-span-1">Total Price</div>
                    </div>
                    @foreach ($order->products as $product)
                    <div class="grid grid-cols-4 items-center justify-items-center text-slate-700 py-2 md:py-3 md:grid-cols-6 dark:text-gray-300">
                        <div class="justify-self-start col-span-2 flex flex-col gap-x-1.5 items-start md:col-span-3 md:flex-row md:items-center">
                            <div class="flex justify-center w-14 h-14 rounded-full shrink-0">
                                @if ($product->image)
                                <img src="{{ asset('storage/images/'.$product->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                                @else
                                {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                                <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                                @endif
                            </div>
                            <h4 class="text-sm mt-2 hover:text-blue-600 md:mt-0 md:ml-2 dark:hover:text-blue-300"><a href="{{route('products.show', ['product' => $product->slug])}}">{{$product->name}}</a></h4>
                        </div>
                        <div class="col-span-1 text-center">{{$product->pivot->quantity}}</div>
                        <div class="hidden col-span-1 md:block">{{number_format($product->price, 0, '.', ',')}}</div>
                        <div class="col-span-1 px-2 py-1 rounded-lg font-semibold text-sm sm:text-base sm:p-0 text-lime-700 dark:text-lime-500">{{number_format($product->pivot->quantity * $product->price, 0, '.', ',')}}<span class="ml-1 text-xs dark:text-gray-300">Kyat</span></div>
                    </div>
                    @endforeach
                </div>

                <!-- Customer and Order details -->
                <div class="px-4 rounded-lg bg-white text-slate-700 shadow text-xs mt-4 md:text-sm lg:mr-6 dark:bg-gray-800 dark:text-gray-300">
                    <h1 class="border-b py-2 font-semibold text-sm sm:text-base sm:py-4 dark:border-b-gray-600">
                        Customer and Order details
                    </h1>
                    <div class="flex justify-between py-2">
                        <div>Customer Name</div>
                        <div>{{$order->user->name}}</div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Phone Number</div>
                        <div>{{$order->user->phone_number}}</div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Type</div>
                        <div>Delivery</div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Payment Method</div>
                        <div>{{ucfirst($order->payment_type)}}</div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Order Time</div>
                        {{-- 
                            M: month abbreviation, 
                            j: day of the month without leading zeros, 
                            Y: year with four digits, 
                            g: 12 hour format without leading zero, 
                            i: minutes without leading zero, 
                            A: uppercase morning or afternoon
                         --}}
                        <div><time>{{\Carbon\Carbon::parse($order->created_at)->format('M j, Y g:i A')}}</time></div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Note</div>
                        <div>{{$order->description}}</div>
                    </div>
                </div>
            </div>

            <div class="basis-1/4">
                <!-- Order Summary -->
                <div class="px-4 rounded-lg bg-white text-slate-700 shadow mt-4 text-xs md:text-sm dark:bg-gray-800 dark:text-gray-300">
                    <h1 class="py-2 font-semibold text-sm md:py-4 md:text-base">
                        Order Summary
                    </h1>
                    <div class="flex justify-between py-2">
                        <div>Order Created</div>
                        <div>
                            <time>{{\Carbon\Carbon::parse($order->created_at)->format('M j, Y')}}</time>
                        </div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Order Time</div>
                        <div>
                            <time>{{\Carbon\Carbon::parse($order->created_at)->format('g:i A')}}</time>
                        </div>
                    </div>
                    <div class="flex justify-between py-2">
                        <div>Sub Total</div>
                        <div class="font-semibold text-base">{{number_format($order->total_price, 0, '.', ',')}}
                            <span class="ml-1 text-sm font-normal">Kyat</span>
                        </div>
                    </div>
                    {{-- <div class="flex justify-between py-2">
                        <div>Delivery Fee</div>
                        <div class="text-lime-700 font-semibold">{{number_format(500, 0, '.', ',')}}<span class="ml-1 text-sm font-normal text-black">Kyat</span></div>
                    </div> --}}
                </div>

                <div class="px-4 rounded-lg bg-white shadow mt-4 dark:bg-gray-800">
                    <div class="flex justify-between py-2 text-base md:text-lg">
                        <div>Total</div>
                        <div class="font-semibold text-lime-700 text-lg dark:text-lime-400">{{number_format($order->total_price, 0, '.', ',')}}
                            <span class="ml-1 text-sm font-normal text-black dark:text-gray-200">Kyat</span>
                        </div>
                    </div>
                </div>

                {{-- TODO: include delivery info are implementing delivery system --}}
            </div>
        </div>
    </x-container>
</x-layout>

<script>
    function copyToClipboard()
    {
        const orderCodeElement = this.$refs.orderCode;
        navigator.clipboard.writeText(orderCodeElement.value);
        console.log(orderCodeElement.value);
        this.copied = true;
        setTimeout(() => this.copied = false, 1200);
    }
</script>