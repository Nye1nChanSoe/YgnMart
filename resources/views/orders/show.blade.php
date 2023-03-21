<x-layout>
    <x-slot:title>
        YangonMart.com Order - {{$order->order_code}}
    </x-slot:title>
    <x-container class="bg-slate-50 p-6 mt-10 mb-10 rounded-xl">
        <div class="flex justify-center">
            <div class="flex-1">
                <div 
                    x-data="{
                        copied: false,
                    }" 
                    class="flex items-center space-x-2"
                >
                    <h1 class="font-bold text-lg">Order Number</h1>
                    <p class="text-lime-700">
                        #<input x-ref="orderCode" type="button" value="{{$order->order_code}}" class="focus:outline-none">
                    </p>
                    <div @@click="copyToClipboard" class="relative">
                        <x-icon name="clipboard" class="inline cursor-pointer hover:text-blue-700" />
                        <div x-show="copied" class="absolute -top-10 right-0 border rounded-lg bg-blue-400 text-white py-1 px-2" x-cloak x-transition>Copied!</div>
                    </div>
                </div>

                <!-- Order Product Table -->
                <div class="px-4 border rounded-lg bg-white text-sm mt-3 mr-6">
                    <div class="grid grid-cols-6 items-center justify-items-center border-b border-gray-200 font-semibold text-slate-700 py-4">
                        <div class="col-span-3 justify-self-start text">Item</div>
                        <div class="col-span-1">Quantity</div>
                        <div class="col-span-1">Price</div>
                        <div class="col-span-1">Total Price</div>
                    </div>
                    @foreach ($order->products as $product)
                    <div class="grid grid-cols-6 items-center justify-items-center text-slate-700 py-3">
                        <div class="justify-self-start col-span-3 flex items-center">
                            <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="" width="80" style="object-fit:contain">
                            <h4 class="text-sm ml-2"><a href="{{route('products.show', ['product' => $product->slug])}}">{{$product->name}}</a></h4>
                        </div>
                        <div class="col-span-1 text-center">{{$product->pivot->quantity}}</div>
                        <div class="col-span-1">{{number_format($product->price, 0, '.', ',')}}</div>
                        <div class="col-span-1 font-semibold">{{number_format($product->pivot->quantity * $product->price, 0, '.', ',')}}<span class="ml-1 text-xs">Kyat</span></div>
                    </div>
                    @endforeach
                </div>

                <!-- Customer and Order details -->
                <div class="px-4 border rounded-lg bg-white text-sm mt-4 mr-6">
                    <h1 class="border-b text-slate-700 py-4 font-semibold text-base">
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
                <div class="px-4 border rounded-lg bg-white mt-4">
                    <h1 class="text-slate-700 py-4 font-semibold text-lg">
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
                        <div class="font-semibold">{{number_format($order->total_price, 0, '.', ',')}}
                            <span class="ml-1 text-sm font-normal">Kyat</span>
                        </div>
                    </div>
                    {{-- <div class="flex justify-between py-2">
                        <div>Delivery Fee</div>
                        <div class="text-lime-700 font-semibold">{{number_format(500, 0, '.', ',')}}<span class="ml-1 text-sm font-normal text-black">Kyat</span></div>
                    </div> --}}
                </div>

                <div class="px-4 border rounded-lg bg-white mt-4">
                    <div class="flex justify-between py-2 text-lg">
                        <div>Total</div>
                        <div class="font-semibold text-lime-700">{{number_format($order->total_price, 0, '.', ',')}}
                            <span class="ml-1 text-sm font-normal text-black">Kyat</span>
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