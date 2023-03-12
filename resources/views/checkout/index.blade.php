@php
    $user = auth()->user();    
@endphp

<x-layout>
    <x-container>
        {{-- TODO: breadcrubs --}}
        <div class="my-10">
            implement > breadcrumbs > links > here
        </div>

        {{-- The form wrapping around the whole checkout process --}}
        <form 
            x-data="{
                payment: 'card',
                total: 0,
                quantities: [],
                products: [],

                init()
                {
                    this.total = {{$checkout->total_price}};
                    @foreach($cartItems as $cart)
                        this.quantities.push({{$cart->quantity}});
                        this.products.push({{$cart->product->id}});
                    @endforeach
                }
            }" 

            action="" 
            method="POST" 
            x-bind:id = "payment==='cash' ? 'cash-payment-form' : 'card-payment-form'" 
            class="flex justify-between"
        >
            @csrf
            <div class="flex-1 space-y-6 divide-y mr-6 p-4">
                <!-- Address -->
                <div 
                    x-data="{
                        open: {{$addresses->isEmpty() ? 'true' : 'false'}},
                    }" 
                    class="flex justify-between space-x-4 mr-8"
                >
                    <h1 class="text-sky-800 font-semibold">1</h1>
                    <div class="flex items-start flex-1">
                        <h2 class="font-semibold w-48">Delivery Address</h2>
                        <div class="flex flex-col flex-1 text-sm mr-6">
                            <div>
                                @if(!$addresses->isEmpty())
                                    @foreach ($addresses as $address)
                                        @if ($address->is_default)
                                        <p>{{$address->user->name}}</p>
                                        <p>{{$address->street}}, {{$address->ward}}, {{$address->township}}</p>
                                        @endif
                                    @endforeach
                                @else
                                <p class="text-gray-400 text-sm cursor-pointer">Please add the address for delivery</p>
                                @endif
                            </div>
                            <div 
                                x-show="open" 
                                class="border rounded-lg mt-6" 
                                x-transition
                            >
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
                        <button type="button" @@click="open=!open">
                            <x-icon name="chevron-down" class="hover:text-blue-600 rounded-full" x-bind:class="{ '-rotate-180 duration-400':open }" />
                        </button>
                    </div>
                </div>
                <!-- End Address -->

                <!-- Payment -->
                <div 
                    x-data="{
                        open: false,
                    }"
                    class="flex justify-between space-x-4 pt-5 mr-8"
                >
                    <h1 class="text-sky-800 font-semibold">2</h1>
                    <div class="flex items-start flex-1">
                        <h2 class="font-semibold w-48">Payment Method</h2>
                        <div class="flex flex-col flex-1 text-sm mr-6">
                            {{-- radio buttons --}}
                            <div>
                                <div class="flex items-center mb-3">
                                    <input id="payment-cash" type="radio" name="payment_method" value="cash" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" x-model="payment" checked>
                                    <label for="payment-cash" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pay with cash</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="payment-card" type="radio" name="payment_method" value="card" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" x-model="payment">
                                    <label for="payment-card" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pay with cards</label>
                                    <x-icon name="card-solid" class="ml-2 text-blue-400"/>
                                </div>
                            </div>

                            <div x-show="payment==='card'" class="mt-6" x-transition>
                                <input type="hidden" id="client-secret-key" name="client_secret_key" value="{{$clientSecret}}">
                                <input type="hidden" id="checkout-id" name="checkout_id" value="{{$checkout->id}}">
                                <div id="card" class="appearance-none border border-black/25 rounded-lg w-80 py-2 px-3"></div>
                                <div id="card-errors" role="alert" class="text-red-500 mt-2"></div>
                            </div>
                        </div>
                        <div x-data="{ show:false }" class="relative" @@mouseleave="show=false">
                            <button type="button" @@mouseenter="show=true">
                                <x-icon name="info" class="text-black hover:text-blue-600" />
                            </button>
                            <div x-show="show" class="absolute top-5 right-0 border p-2 bg-slate-100 rounded-lg">
                                <div class="text-xs text-gray-700 w-60">
                                    <h2 class="mb-2">You can test the payment</h2>
                                    <div class="flex space-x-4">
                                        <span class="text-sky-500">4242424242424242</span>
                                        <span class="text-gray-500">Succeessful payment</span>
                                    </div>
                                    {{-- <div class="flex space-x-4">
                                        <span class="text-sky-500">4000000000009995</span>
                                        <span class="text-gray-500">Always declined</span>
                                    </div>
                                    <div class="flex space-x-4">
                                        <span class="text-sky-500">4000002500003155</span>
                                        <span class="text-gray-500">Requires authentication</span>
                                    </div> --}}
                                    {{-- <p class="mt-1.5 mr-2 text-gray-500">Check more <a href="https://stripe.com/docs/testing" target="_blank" class="underline hover:text-gray-700">https://stripe.com/docs/testing</a></p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Payment -->

                <!-- Product Review -->
                <div 
                    x-data="{
                        open: true,
                    }"
                    class="flex justify-between space-x-4 pt-5 mr-8"
                >
                    <h1 class="text-sky-800 font-semibold">3</h1>
                    <div class="flex-1 items-start">
                        <div class="flex flex-1 justify-between">
                            <h2 class="font-semibold w-48">Product Review</h2>
                            <button type="button" @@click="open=!open">
                                <x-icon name="chevron-down" class="hover:text-blue-600 rounded-full" x-bind:class="{ '-rotate-180 duration-400':open }" />
                            </button>
                        </div>

                        {{-- products display --}}
                        <div x-show="open" class="mt-4 mr-10 p-3 border rounded-lg divide-y space-y-3">
                            @foreach ($cartItems as $cart)
                            <div class="flex items-center">
                                <img src="{{$cart->product->image ? asset($cart->product->image) : asset('images/no-image.png')}}" alt="" width="120" style="object-fit:contain">
                                <div class="text-sm ml-8">
                                    <p class="text-gray-900">{{$cart->product->name}}</p>
                                    <div class="bg-slate-50 rounded-lg mt-2 p-2 w-36">
                                        <p>Quantity: <span class="font-semibold ml-1">{{$cart->quantity}}</span></p>
                                        <p>Price: <span class="font-semibold text-lime-700 ml-1">{{number_format($cart->product->price * $cart->quantity, 0, '.', ',')}}</span> Kyat</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- final order --}}
                        <div class="flex justify-between items-center border rounded-lg p-4 mt-4 mr-10">

                            <button id="payment-submit" type="submit" x-on:click="processOrder" class="w-40 px-4 py-2 bg-blue-500 text-white rounded-lg text-lg hover:bg-blue-600">Order Now</button>
                            <div id="payment-loading" class="flex justify-center items-center w-40 px-4 py-2 bg-blue-50 rounded-lg text-lg space-x-2">
                                <span class="text-gray-500">Ordering</span>
                                <div class="spinner"></div>
                            </div>

                            <div class="flex flex-col items-center text-xl">
                                <h1 class="text-lg">Total</h1>
                                <div class="flex items-center">
                                    <p x-text="total.toLocaleString('en-US')" class="font-semibold text-lime-700 inline text-2xl"></p>
                                    <span class="text-xs ml-2"> Kyat</span>
                                </div>
                            </div>
                        </div>
                        <input id="quantities" type="hidden" name="quantities" value="" x-model="quantities">
                        <input id="products" type="hidden" name="products" value="" x-model="products">
                        <input id="total-amount" type="hidden" name="total_amount" value="" x-model="total">
                    </div>
                </div>
                <!-- End Review -->
            </div>

            {{-- quick purchase --}}
            <div class="bg-slate-100 p-4">
                Order Summary
            </div>
        </form>

    </x-container>
</x-layout>

<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");


/** 
 * create pre-build stripe elements like card number, card expiry ... 
 * https://stripe.com/docs/payments/accept-card-payments?platform=web&ui=elements
 */
var elements = stripe.elements();

var style = {
    base: {
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        fontSmoothing: 'antialiased',
        '::placeholder': {
            color: 'gray'
        },
        color: 'black',
        fontWeight: 500,
    },
    invalid: {
        color: '#D22B2B',
    }
};

var cardElement = elements.create('card', {style:style});

cardElement.mount('#card');

/** Handle validation errors */
var displayError = document.getElementById('card-errors');
cardElement.addEventListener('change', function(event) {
    if(event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = "";
    }
});


var paymentSubmit = document.getElementById('payment-submit');
var paymentLoading = document.getElementById('payment-loading');
paymentLoading.style.display = 'none';

/** input fields */
var totalAmount = document.getElementById('total-amount');
var products = document.getElementById('products');
var quantities = document.getElementById('quantities');
var id = document.getElementById('checkout-id');

function processOrder()
{
    var cashForm = document.getElementById('cash-payment-form');
    var cardForm = document.getElementById('card-payment-form');

    if(cashForm) 
    {
        console.log('Cash Form submitted asynchronously');
        cashForm.addEventListener('submit', function(event) {
            event.preventDefault();
            paymentSubmit.style.display = 'none';
            paymentLoading.style.display = 'flex';
            const formData = {
                total_amount: totalAmount.value,
                products: products.value,
                quantities: quantities.value,
                payment_method: 'cash'
            };
            console.log('Purchase Data: ', formData);

            // send AJAX request to remove checkout record and create new order record
            fetch('/checkout/' + id.value, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    // include CSRF TOKEN in the request so the server can verify it
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function(response) {
                if(!response.ok) {
                    throw new Error('Internal server error. Response was not OK');
                }
                return response.json();
            })
            .then(function(data) {
                console.log(data.message);
                fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        payment_intent_id: "{{$checkout->payment_intent_id}}",
                        form_data: formData     // send form data in the json payload to create order record
                    })
                })
                .then(function(response) {
                    if(!response.ok) {
                        throw new Error('Internal server error. Response was not OK');
                    }
                    return response.json();
                })
                .then(function(data) {
                    console.log(data.message);

                    window.location.href = '/orders/success?order=' + encodeURIComponent(data.order_code);

                })
                .catch(function(error) {
                    console.error('Error: ', error);
                    alert('There was an error processing your request. Please try again later.');
                });
            })
            .catch(function(error) {
                console.error('Error: ', error);
                alert('There was an error processing your request. Please try again later.');
            });
        });
    }

    if(cardForm) {
        console.log('Card Form submitted asynchronously');
        cardForm.addEventListener('submit', function(event) {
            event.preventDefault();
            paymentSubmit.style.display = 'none';
            paymentLoading.style.display = 'flex';
            const formData = {
                total_amount: totalAmount.value,
                products: products.value,
                quantities: quantities.value,
                payment_method: 'card'
            };
            console.log('Purchase Data: ', formData);

            /* 
             Client secret is a unique string generated by the stripe server and sent
             to the client (this application). It is used to authenticate the client (my server)
             and verified that the payment information is being submitted by the authorized user
            */
            const clientSecret = document.getElementById('client-secret-key').value;
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: "{{$user->name}}",
                        email: "{{$user->email}}",
                        phone: "{{$user->phone_number}}",
                    },
                }
            })
            .then(function(result) {    // Stripe send back a response containing a result object
                if(result.error) 
                {
                    console.log(result.error.message);
                    displayError.textContent = result.error.message;
                    paymentSubmit.style.display = 'block';
                    paymentLoading.style.display = 'none';
                }
                else
                {
                    console.log('Payment Status: ', result.paymentIntent.status);
                    var paymentIntentId = result.paymentIntent.id;

                    // send AJAX request to remove checkout record and create new order record
                    fetch('/checkout/' + id.value, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(function(response) {
                        if(!response.ok) {
                            throw new Error('Internal server error. Response was not OK');
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        console.log(data.message); 
                        fetch('/orders', {      // send another AJAX request to create a new order
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                payment_intent_id: paymentIntentId,
                                form_data: formData 
                            })
                        })
                        .then(function(response) {
                            if(!response.ok) {
                                throw new Error('Internal server error. Response was not OK');
                            }
                            return response.json();
                        })
                        .then(function(data) {
                            console.log(data.message);  // handle the response data as needed

                            window.location.href = '/orders/success?order=' + encodeURIComponent(data.order_code);

                        })
                        .catch(function(error) {
                            console.error('Error: ', error);
                            displayError.textContent = error.message;
                        });
                    })
                    .catch(function(error) {
                        console.error('Error: ', error);
                        displayError.textContent = error.message;
                    });
                }
            });
        });
    }   
}
</script>