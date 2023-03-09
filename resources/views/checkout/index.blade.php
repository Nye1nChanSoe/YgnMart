<x-layout>
    <x-container>
        {{-- TODO: breadcrumbs --}}
        <div class="my-10">
            implement > breadcrumbs > links > here
        </div>
        
        <div class="flex space-x-2">
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
                        open:false, 
                        payment:'card'
                    }" 
                    class="flex space-x-4 pt-6"
                >
                    <div>
                        <h1 class="text-sky-800 font-semibold">2</h1>
                    </div>
                    <div class="flex grow justify-between items-start pr-10">
                        <h2 class="font-semibold w-48">Payment Method</h2>
                        <div class="flex flex-col flex-1 mr-10">
                            <div class="flex-1 text-sm">
                                <div x-show="payment==='cash'">
                                    <p class="text-gray-400 text-sm">Pay with <span class="text-gray-600 font-semibold">cash<x-icon name="cash" class="inline ml-1.5" /></span></p>
                                </div>
                                <div x-show="payment==='card'">
                                    <p class="text-gray-400 text-sm">Pay with <span class="text-gray-600 font-semibold">card<x-icon name="card" class="inline ml-1.5" /></span></p>
                                    <form id="payment-form" action="{{ route('payment.store') }}" method="POST" class="flex flex-col space-y-3 mt-3">
                                        @csrf
                                        <input type="hidden" id="client-secret-key" value="{{$clientSecret}}">
                                        <div>
                                            <label for="card-holder-name" class="block text-gray-600 mb-2">Card Holder's Name</label>
                                            <input type="text" id="card-holder-name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300" placeholder="Enter card holder's name">
                                        </div>
                                        <div>
                                            <label for="card-number" class="block text-gray-600 mb-2">Card Number</label>
                                            <div id="card-number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300"></div>
                                        </div>
                                        <div class="flex justify-between space-x-8">
                                            <div class="flex-1">
                                                <label for="card-expiry-date" class="block text-gray-600 mb-2">Card Expiry</label>
                                                <div id="card-expiry-date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300"></div>
                                            </div>
                                            <div class="flex-1">
                                                <label for="card-cvc" class="block text-gray-600 mb-2">Card CVC</label>
                                                <div id="card-cvc" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300"></div>
                                            </div>
                                        </div>
                                        <div id="card-errors" role="alert" class="text-red-500 mb-4"></div>
                                        <button id="payment-submit" type="submit" class="self-start bg-blue-500 text-white py-1.5 px-3 text-sm rounded-lg hover:bg-blue-600">Submit Payment</button>
                                    </form>
                                    <script src="https://js.stripe.com/v3/"></script>
                                    <script>
                                        window.publicApiKeys = {
                                            stripeKey: "{{ env('STRIPE_PUBLIC_KEY') }}"
                                        };
                                    </script>
                                    <script src="{{ asset('js/stripePayment.js') }}"></script>
                                </div>
                            </div>
                            <div x-show="open" class="flex-1 border border-slate-300 rounded-lg px-4 py-2 mt-7 text-sm space-y-2" x-cloak x-transition>
                                <div>
                                    <label for="">Cash</label>
                                    <input type="radio" name="payment_method" value="cash" x-model="payment">                            
                                </div>
                                <div>
                                    <label for="">Credit Card</label>
                                    <input type="radio" name="payment_method" value="card" x-model="payment">                            
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
                        open: true,
                        totalPrice: 0,
                        totalQuantity: 0,
                        products: [],
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
                        <div x-show="open" class="border p-1 divide-y mb-4 rounded-lg">
                            @foreach ($cartItems as $cart)
                                <div class="flex space-x-4 items-center text-xs p-3">
                                    <img src="{{$cart->product->image}}" alt="" width="120" style="object-fit:contain">
                                    <div class="space-y-1">
                                        <p>{{$cart->product->name}}</p>
                                        <p>Quantity <span>{{$cart->quantity}}</span></p>
                                        <p>Price <span>{{$cart->product->price * $cart->quantity}}</span></p>
                                    </div>
                                </div>
                                <input type="hidden" name="items[]" value="{{$cart->id}}">
                                <input type="hidden" name="total_amount" value="{{$cart->product->price * $cart->quantity}}">
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
        </div>
    </x-container>
</x-layout>