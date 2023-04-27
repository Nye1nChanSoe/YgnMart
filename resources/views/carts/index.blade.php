<x-layout>
    <x-slot:title>
        Cart - YangonMart.com
    </x-slot:title>
    <x-container class="mt-10">
        <ul class="flex items-center my-3 px-3 py-3 text-sm">
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Home</a><x-icon name="chevron-right" class="dark:text-gray-200" />
            </li>
            <li class="flex items-center ml-2 gap-x-1">
                <a href="{{ route('carts.index') }}" class="{{ request()->routeIs('carts.index') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }} hover:text-blue-600 dark:hover:text-blue-500">Cart</a>
            </li>
        </ul>
        <div class="rounded-lg px-4 py-5 shadow-sm border md:px-10 dark:text-gray-300 dark:border-gray-700 dark:bg-gray-900">
            <h4 class="text-xs text-gray-700 dark:text-gray-300">Shopping cart</h4>

            {{-- headings --}}
            <div class="flex justify-between py-4 border-b border-gray-200 text-sm font-semibold text-slate-700 dark:border-gray-700 dark:text-gray-300">
                <h3 class="basis-1/2">Product</h3>
                <h3>Quantity</h3>
                <h3>Price</h3>
            </div>

            {{-- cart container --}}
            <form action="{{ route('carts.checkout') }}" method="POST" class="divide-y divide-gray-200 dark:divide-gray-700"
                x-data="{
                    count: 0,   
                    total: 0,

                    init()
                    {
                    @foreach($carts as $cart)
                        this.count += {{$cart->quantity}};
                        this.total += {{$cart->product->price * $cart->quantity}};
                    @endforeach 
                    }
                }"
            >
                @csrf

                {{-- cart item --}}
                @if (!$carts->isEmpty())
                    @foreach ($carts as $cart)
                    <div 
                        x-data="{
                            id:{{$cart->id}}
                        }" 
                        x-ref="item_{{$cart->id}}" 
                        class="flex justify-between items-center py-3"
                    >
                        <div class="basis-1/2 flex flex-col items-center justify-center space-y-4 sm:space-y-0 sm:flex-row sm:justify-start">
                            {{-- <div class="hidden mr-6 sm:block">
                                <input type="checkbox" class="w-3.5 h-3.5" checked>
                            </div> --}}
                            <div class="w-20 self-start rounded-full sm:self-center sm:mr-8 sm:w-32">
                                <a href="/products/{{$cart->product->slug}}" class="flex items-center justify-center w-20 h-20 sm:w-32 sm:h-32">
                                    @if ($cart->product->image)
                                    <img src="{{ asset('storage/images/'.$cart->product->image) }}" alt="" class="w-full h-full object-contain shrink-0">
                                    @else
                                    {{-- <img src="https://placehold.co/240/png" alt="" class="w-full h-full object-cover"> --}}
                                    <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full shrink-0 object-contain">
                                    @endif
                                </a>
                            </div>
                            <div class="w-full mr-4 sm:self-start">
                                <h4 class="text-sm sm:text-base"><a href="/products/{{$cart->product->slug}}" class="hover:text-blue-600 dark:hover:text-blue-400">{{$cart->product->name}}</a></h4>

                                {{-- TODO: check product inventory and variants dynamically --}}
                                @if ($cart->product->inventory->available_quantity >= $cart->quantity)
                                    <p class="text-xs px-1.5 py-1 mt-3 rounded-lg bg-green-600 text-white w-fit">Available</p>
                                @else
                                    <p class="ttext-xs px-1.5 py-1 mt-3 rounded-lg bg-red-400 text-white w-fit">Out of Stock</p>
                                @endif
                                <div class="flex text-xs py-1 space-x-3">
                                    <button type="button" x-on:click="removeItem, $refs.item_{{$cart->id}}.remove()" class="text-red-500 hover:text-red-700 dark:text-red-300 dark:hover:text-red-400">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div
                            x-data="{
                                id: {{ $cart->id }},
                                open: false,
                                quantity: {{ $cart->quantity }},
                            }"
                            class="relative flex items-center gap-x-2.5 text-sm sm:text-base"
                        >
                            <span x-text="quantity"></span>
                            <div>
                                <button @@click="open = !open" type="button" class="flex items-center border-2 border-gray-700 text-xs px-2 py-1 rounded-full focus:border-0 focus:ring-2 focus:ring-blue-400">
                                    <div class="font-medium mr-1.5">
                                        Qty: <span x-text="quantity"></span>
                                    </div>
                                    <x-icon name="chevron-right" class="w-3.5 h-3" x-bind:class="{ 'rotate-90 transition-all duration-400':open }"/>
                                </button>

                                <div x-show="open" @@click.outside="open = false" class="absolute py-2 mt-1 bg-white shadow-lg w-20 max-h-56 overflow-auto scrollbar rounded-xl border border-slate-200 z-10 dark:bg-gray-700 dark:text-gray-200 dark:border-slate-400" x-cloak x-transition>
                                    <ul>
                                        @for ($i = 1; $i <= ($cart->product->inventory->available_quantity > 100 ? 100 : $cart->product->inventory->available_quantity); $i++)
                                        <li>
                                            <x-dropdown-item 
                                                class="leading-6" 
                                                x-on:click="quantity = {{$i}}, open = false, updateCartItem(id, quantity)"
                                            >
                                                {{$i}}
                                            </x-dropdown-item>
                                        </li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-center sm:block">
                            {{number_format($cart->product->price * $cart->quantity, 0, '.', ',')}}
                            <span class="text-xs font-normal text-gray-600 dark:text-gray-300">Kyat</span>
                        </div>
                    </div>
                    @endforeach
                @endif
                {{-- x-if completely add or remove elements rather than just changing it's CSS to display none like x-show  --}}
                <template x-if="count == 0">
                    <div class="flex flex-col items-center">
                        <div class="mx-auto w-40 rotate-12">
                            <img src="/images/empty_cart.png" alt="">
                        </div>
                        <div class="pb-3 pt-6 text-center text-slate-700 dark:text-gray-400">
                            Your shopping cart is empty! 
                            <a href="/" class="block text-blue-500 hover:text-blue-700 mt-2 dark:hover:text-blue-300">Add some items</a>
                        </div>
                    </div>
                </template>

                {{-- checkout --}}
                @if(!$carts->isEmpty())
                <template x-if="count > 0">
                    <div class="flex flex-col justify-center items-center pt-8 pb-3 sm:items-end">
                        <div>
                            <input type="hidden" name="total_amount" x-model="total">
                            SubTotal (<span x-text="count" class="font-semibold" id="quantity="></span> items) 
                            <div class="bg-slate-100 px-3 py-[2px] rounded-lg inline-flex items-center space-x-1 dark:bg-slate-700 dark:text-gray-200">
                                <span x-text="total.toLocaleString('en-US')" class="text-lg font-semibold text-center"></span>
                                <span class="text-xs">Kyat</span>
                            </div>
                        </div>
                        <button type="submit" class="text-base bg-blue-500 text-white px-3 py-[4px] mt-6 rounded-lg shadow hover:bg-blue-600 sm:text-lg sm:px-4 sm:py-2 dark:bg-blue-700 dark:hover:bg-blue-800">
                            Proceed to checkout
                        </button>
                    </div>
                </template>
                @endif
            </form>
        </div>
    </x-container>
</x-layout>


<script>
    function removeItem()
    {
        fetch(`/carts/${this.id}`, {
            method: 'DELETE', 
            headers: {
                'Content-Type': 'application/json',

                // To resolve the issue, you need to include a CSRF token in your AJAX request:
                // The CSRF TOKEN is embedded in the meta tag 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => {
            if(!response.ok) {
                throw new Error('Network was not ok');
            }

            return response.json();
        })
        .then(data => {
            /* remove the deleted items and recalculate the total price and dynamically update with the x-text */
            this.count -= data.quantity;
            this.total -= data.totalPrice;
            this.cartItemCounter = data.count;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    function updateCartItem(id, quantity)
    {
        fetch(`/carts/${id}`, {
            method: 'PUT', 
            headers: {
                'Content-Type': 'application/json',

                // To resolve the issue, you need to include a CSRF token in your AJAX request:
                // The CSRF TOKEN is embedded in the meta tag 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                quantity: quantity,
            })
        })
        .then(response => {
            if(!response.ok) {
                throw new Error('Network was not ok');
            }

            return response.json();
        })
        .then(data => {
            console.log(data.message);

            /* refresh the data on screen */
            window.location.reload();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
</script>
