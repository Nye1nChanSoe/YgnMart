<x-layout>
    <x-container>
        {{-- TODO: breadcrumbs --}}
        {{-- <div class="my-10">
            implement > breadcrumbs > links > here
        </div> --}}
        
        <form id="payment-form" action="" method="POST" class="flex flex-col space-x-4 md:flex-row">
            @csrf
            {{-- Main Checkout UI --}}
            <div class="basis-3/4 divide-y space-y-6">

                {{-- TODO: Allow user to pick up or delivery for their purchases --}}
                {{-- Address --}}
                <div
                    x-data="{
                        open: false,
                        text: {{$addresses->isEmpty() ? '\'Add\'' : '\'Change\''}},
                    }" 
                    class="flex space-x-4 pt-6"
                >
                    <div>
                        <h1 class="text-sky-800 font-semibold">1</h1>
                    </div>
                    <div class="flex grow justify-between items-start pr-10">
                        <h2 class="font-semibold w-48">Delivery Address</h2>
                        <div class="flex flex-col flex-1 mr-4 text-sm">
                            <div>
                                @if(!$addresses->isEmpty())
                                    @foreach ($addresses as $address)
                                        @if ($address->is_default)
                                            <p>{{$address->user->name}}</p>
                                            <p>{{$address->street}}, {{$address->ward}}, {{$address->township}}</p>
                                        @endif
                                    @endforeach
                                @else
                                    <button type="button" x-on:click="open=!open"><p class="text-gray-400 text-sm cursor-pointer">Please add the address for delivery</p></button>
                                @endif
                            </div>
                            <div x-show="open" class="border rounded-lg mt-6" x-transition>
                                <div class="p-3">
                                    <h2 class="font-semibold mb-3">Your addresses</h2>
                                    @foreach ($addresses as $address)
                                        <div class="text-sm mb-1.5">
                                            <input type="radio" name="defaultAddress" value="{{$address->id}}">
                                            {{$address->street}}, {{$address->ward}}, {{$address->township}}
                                        </div>
                                    @endforeach
                                    {{-- modal to add new address --}}
                                    <button type="button" class="mt-3">+ <span class="text-sm text-lime-600 hover:text-lime-700">Add new address</span></button>
                                </div>
                                <div class="p-3 bg-slate-100">
                                    <button type="button" class="bg-blue-500 text-white py-1 px-2 text-sm rounded-lg hover:bg-blue-600">Use this address</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" x-on:click="open=!open" class="text-blue-500 hover:text-blue-700 text-sm" x-text="text"></button>
                    </div>
                </div>

                {{-- Payment --}}
                <div 
                    x-data="{
                        open:false, 
                        payment:'card',
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
                                <div x-show="payment==='card'" x-transition>
                                    <div class="flex flex-col">
                                        <input type="hidden" id="client-secret-key" value="{{$clientSecret}}">
                                        <div class="mb-2">
                                            <label for="card-number" class="block text-gray-600 mb-2">Card Number <span class="text-red-300">*</span></label>
                                            <div id="card-number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300"></div>
                                        </div>
                                        <div class="flex justify-between gap-x-4 mb-2">
                                            <div class="flex-1">
                                                <label for="card-expiry-date" class="block text-gray-600 mb-2">Card Expiry <span class="text-red-300">*</span></label>
                                                <div id="card-expiry-date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300"></div>
                                            </div>
                                            <div class="flex-1">
                                                <label for="card-cvc" class="block text-gray-600 mb-2">Card CVC <span class="text-red-300">*</span></label>
                                                <div id="card-cvc" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline focus:outline-slate-300"></div>
                                            </div>
                                        </div>
                                        <div id="card-errors" role="alert" class="text-red-500 mb-4"></div>
                                    </div>
                                </div>
                            </div>
                            <div x-show="open" class="flex-1 border border-slate-300 rounded-lg px-4 py-2 mt-7 text-sm space-y-2" x-cloak x-transition>
                                <div>
                                    <label for="">Cash</label>
                                    <input type="radio" name="payment_method" value="cash" x-model="payment" x-on:click="open=!open">                            
                                </div>
                                <div>
                                    <label for="">Credit Card</label>
                                    <input type="radio" name="payment_method" value="card" x-model="payment" x-on:click="open=!open">                            
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
                                    <button type="button" class="bg-blue-500 text-white py-1 px-2 text-sm rounded-lg hover:bg-blue-600">Use this coupon</button>
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
                        <div x-show="open" class="border p-1 divide-y mb-4 rounded-lg" x-transition>
                            @foreach ($cartItems as $cart)
                                <div class="flex space-x-4 items-center text-xs p-3">
                                    <img src="{{$cart->product->image ? asset($cart->product->image) : asset('images/no-image.png')}}" alt="" width="120" style="object-fit:contain">
                                    <div class="space-y-1 text-gray-800">
                                        <p class="">{{$cart->product->name}}</p>
                                        <p>Quantity <span class="font-semibold">{{$cart->quantity}}</span></p>
                                        <p class="py-1">Price <span class="font-semibold">{{$cart->product->price * $cart->quantity}}</span></p>
                                    </div>
                                </div>
                                <input type="hidden" name="items[]" value="{{$cart->id}}">
                                <input type="hidden" name="total_amount" value="{{$cart->product->price * $cart->quantity}}">
                            @endforeach
                        </div>

                        {{-- Order Total --}}
                        <div class="flex border rounded-lg p-6 space-x-6 items-center justify-between">
                            <button id="payment-submit" type="submit" class="shadow bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Order Now</button>
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

<script src="https://js.stripe.com/v3/"></script>
<script>
    /** declare global variables which are necessary in external JavaScript file to handle Stripe payments */
    window.publicApiKeys = {
        stripeKey: "{{ env('STRIPE_PUBLIC_KEY') }}"
    };

    window.user = {
        name: '{{ auth()->user()->name }}',
        email: '{{ auth()->user()->email }}',
        phone_number: '{{ auth()->user()->phone_number }}'
    };
</script>
<script src="{{ asset('/js/stripePayment.js') }}"></script>