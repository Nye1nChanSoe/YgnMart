<x-layout>
    <x-container class="flex space-x-2 mt-5 p-6">

        {{-- Main Checkout UI --}}
        <div class="basis-3/4 space-y-16">

            {{-- Address --}}
            <div class="flex space-x-4">
                <div>
                    <h1 class="text-sky-800 font-semibold">1</h1>
                </div>
                <div class="flex grow justify-between items-start pr-10">
                    <h2 class="font-semibold w-48">Delivery Address</h2>
                    @php
                        $defaultAddress = auth()->user()->addresses()->where('is_default', true)->get();
                    @endphp
                    @if (!$addresses->isEmpty())

                        {{-- has default address, use it --}}
                        @if (!$defaultAddress->isEmpty())
                            @php
                                $defaultAddress = $defaultAddress->first();
                            @endphp
                            <div class="basis-1/2">
                                <p>{{$defaultAddress->user->name}}</p>
                                <p>{{$defaultAddress->street}}, {{$defaultAddress->ward}}, {{$defaultAddress->township}}</p>
                            </div>

                            {{-- Model to add new address for user --}}
                            <button type="button" class="basis-1/6 text-blue-500 hover:text-blue-700 text-sm">Change</button>
                            
                        {{-- select default address --}}
                        @else
                            <div class="flex-1 border rounded-lg">
                                <div class="p-3">
                                    <h2 class="font-semibold mb-3">Your addresses</h2>
                                    @foreach ($addresses as $address)
                                        <div class="text-sm mb-1.5">
                                            <input type="radio" name="defaultAddress" value="{{$address->id}}">
                                            {{$address->street}}, {{$address->ward}}, {{$address->township}}
                                        </div>
                                    @endforeach
                                    <button class="mt-3">+ <span class="text-sm text-lime-600 hover:text-lime-700">Add new address</span></button>
                                </div>
                                <div class="p-3 bg-slate-100">
                                    <x-button class="text-sm rounded-lg">Use this address</x-button>
                                </div>
                            </div>
                        @endif
                    
                    @else
                    <div class="flex-1 border rounded-lg">
                        <div class="p-3">
                            <h2 class="font-semibold mb-3">Your addresses</h2>
                            <button>+ <span class="text-sm text-lime-600 hover:text-lime-700">Add new address</span></button>
                        </div>
                        <div class="p-3 bg-slate-100">
                            <x-button class="text-sm rounded-lg">Use this address</x-button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Payment --}}
            <div class="flex space-x-4">
                <div>
                    <h1 class="text-sky-800 font-semibold">2</h1>
                </div>
                <div class="flex grow justify-between items-start pr-10">
                    <h2 class="font-semibold w-48">Payment Method</h2>
                    <div class="flex-1 text-sm">
                        <div>
                            <label for="">Cash</label>
                            <input type="radio" name="payment" value="cash">                            
                        </div>
                        <div>
                            <label for="">Credit Card</label>
                            <input type="radio" name="payment" value="credit_card">                            
                        </div>
                    </div>
                </div>
            </div>

            {{-- Discount Coupons --}}
            <div class="flex space-x-4">
                <div>
                    <h1 class="text-sky-800 font-semibold">3</h1>
                </div>
                <div class="flex grow justify-between items-start pr-10">
                    <h2 class="font-semibold w-48">Apply coupons</h2>
                    <div class="flex-1 text-sm">
                        <label for="">Discount code: </label>
                        <input type="text" id="first_name" class="bg-gray-50 py-1 px-2 border border-gray-300 text-gray-900 text-sm rounded-lg outline-1 outline-sky-800" placeholder="Example D-5t87z">
                    </div>
                    <button type="button" class="basis-1/6 text-blue-500 hover:text-blue-700 text-sm"></button>
                </div>
            </div>

            {{-- Product Review  --}}
            <div class="flex space-x-4">
                <div>
                    <h1 class="text-sky-800 font-semibold">4</h1>
                </div>
                <div class="flex-1 pr-10 mb-5">
                    <h2 class="font-semibold w-48 mb-4">Product review</h2>
                    <div class="border p-3 divide-y mb-4">
                        @foreach ($cartItems as $cart)
                            <div class="flex space-x-4 items-center text-sm p-4">
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
                    <div class="flex border p-6 space-x-6 items-center justify-between">
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
    </x-container>
</x-layout>