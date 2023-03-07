<x-layout>
    <x-container>
        {{-- TODO: breadcrumbs --}}
        <div class="my-10">
            implement > breadcrumbs > links > here
        </div>
        
        <form action="{{ route('checkout.store') }}" method="POST" class="flex space-x-2">
            @csrf
            {{-- Main Checkout UI --}}
            <div class="basis-3/4 divide-y space-y-6">

                {{-- TODO: Allow user to pick up or delivery for their purchases --}}
                {{-- Address --}}
                <div
                    x-data="{
                        open: {{$addresses->isEmpty() ? 'true' : 'false'}},
                    }" 
                    class="flex space-x-4 pt-6"
                >
                    <div>
                        <h1 class="text-sky-800 font-semibold">1</h1>
                    </div>
                    <div class="flex grow justify-between items-start pr-10">
                        <h2 class="font-semibold w-48">Delivery Address</h2>
                        <div class="flex flex-col flex-1 mr-4">
                            <div>
                                @if(!$addresses->isEmpty())
                                    @foreach ($addresses as $address)
                                        @if ($address->is_default)
                                            <p>{{$address->user->name}}</p>
                                            <p>{{$address->street}}, {{$address->ward}}, {{$address->township}}</p>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-gray-400 text-sm">Please add the address for delivery</p>
                                @endif
                            </div>
                            <div x-show="open" class="border rounded-lg mt-6">
                                <div class="p-3">
                                    <h2 class="font-semibold mb-3">Your addresses</h2>
                                    @foreach ($addresses as $address)
                                        <div class="text-sm mb-1.5">
                                            <input type="radio" name="defaultAddress" value="{{$address->id}}">
                                            {{$address->street}}, {{$address->ward}}, {{$address->township}}
                                        </div>
                                    @endforeach
                                    {{-- modal to add new address --}}
                                    <button class="mt-3">+ <span class="text-sm text-lime-600 hover:text-lime-700">Add new address</span></button>
                                </div>
                                <div class="p-3 bg-slate-100">
                                    <button type="button" class="bg-blue-500 text-white py-1 px-2 text-sm rounded-lg hover:bg-blue-600">Use this address</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" x-on:click="open=!open" class="text-blue-500 hover:text-blue-700 text-sm">Change</button>
                    </div>
                </div>

                {{-- Payment --}}
                <div 
                    x-data="{
                        open:false, payment:'credit_card'
                    }" 
                    class="flex space-x-4 pt-6"
                >
                    <div>
                        <h1 class="text-sky-800 font-semibold">2</h1>
                    </div>
                    <div class="flex grow justify-between items-start pr-10">
                        <h2 class="font-semibold w-48">Payment Method</h2>
                        <div class="flex flex-col flex-1">
                            <div>
                                <div x-show="payment==='credit_card'" class="flex-1" x-cloak>
                                    Credit Card <x-icon name="check" class="inline" />
                                </div>
                                <div x-show="payment==='cash'" class="flex-1" x-cloak>
                                    Cash <x-icon name="check" class="inline" />
                                </div>
                            </div>
                            <div x-show="open" class="flex-1 border border-slate-300 rounded-lg px-4 py-2 mt-5" x-cloak x-transition>
                                <div>
                                    <label for="">Cash</label>
                                    <input type="radio" name="payment_method" value="cash" x-model="payment">                            
                                </div>
                                <div>
                                    <label for="">Credit Card</label>
                                    <input type="radio" name="payment_method" value="credit_card" x-model="payment">                            
                                </div>
                            </div>
                        </div>
                        <button type="button" x-on:click="open=!open">
                            <x-icon name="chevron-down" x-bind:class="{ '-rotate-180 duration-400':open }"/>
                        </button>
                    </div>
                </div>

                {{-- Discount Coupons --}}
                <div
                    x-data="{
                        open: false,
                    }"
                    class="flex space-x-4 pt-6"
                >
                    <div>
                        <h1 class="text-sky-800 font-semibold">3</h1>
                    </div>
                    <div class="flex grow justify-between items-start pr-10">
                        <h2 class="font-semibold w-48">Apply coupons</h2>
                        <div class="flex flex-col flex-1">
                            <div class="flex-1 text-sm">
                                <label for="">Discount code: </label>
                                <input type="text" name="discount_coupon" class="bg-gray-50 py-1 px-2 border border-gray-300 text-gray-900 text-sm rounded-lg outline-1 outline-sky-800" placeholder="Example D-5t87z">
                            </div>
                            <div x-show="open" class="flex-1 border rounded-lg mt-7" x-cloak x-transition>
                                <div class="p-3">
                                    <h2 class="font-semibold mb-3">Your discount coupons</h2>
                                    <p class="text-gray-400 text-sm">You do not have any discount coupons currently</p>
                                </div>
                                <div class="p-3 bg-slate-100">
                                    <x-button class="text-sm rounded-lg">Use this coupon</x-button>
                                </div>
                            </div>
                        </div>
                        <button type="button" x-on:click="open=!open">
                            <x-icon name="chevron-down" x-bind:class="{ '-rotate-180 duration-400':open }"/>
                        </button>
                    </div>
                </div>

                {{-- Product Review  --}}
                <div
                    x-data="{
                        open: false,
                    }" 
                    class="flex space-x-4 pt-6"
                >
                    <div>
                        <h1 class="text-sky-800 font-semibold">4</h1>
                    </div>
                    <div class="flex-1 pr-10 mb-5">
                        <div class="flex items-start justify-between">
                            <h2 class="font-semibold w-48 mb-4">Product review</h2>
                            <button type="button" x-on:click="open=!open">
                                <x-icon name="chevron-down" x-bind:class="{ '-rotate-180 duration-400':open }"/>
                            </button>
                        </div>
                        <div x-show="open" class="border p-3 divide-y mb-4 rounded-lg">
                            @foreach ($cartItems as $cart)
                                <div class="flex space-x-4 items-center text-sm p-4">
                                    <input type="hidden" name="items[]" value="{{$cart->id}}">
                                    <img src="{{$cart->product->image}}" alt="" width="160">
                                    <div class="space-y-2">
                                        <p>{{$cart->product->name}}</p>
                                        <p>Quantity <span>{{$cart->quantity}}</span></p>
                                        <p>Price <span>{{$cart->product->price * $cart->quantity}}</span></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Order Total --}}
                        <div class="flex border rounded-lg p-6 space-x-6 items-center justify-between">
                            <x-button class="rounded-xl px-6">Order now</x-button>
                            <div>
                                <p class="text-sm">Total price</p>
                                <p class="text-sm">Delivery fees</p>
                            </div>
                            <p>Order Total</p>
                        </div>

                    </div>
                </div>
            </div>

            {{-- TODO: Quick checkout --}}
            <div class="basis-1/4 border p-3 px-5 self-start space-y-3">
                <h2 class="text-center font-semibold">Order Summary</h2>
            </div>
        </form>
    </x-container>
</x-layout>