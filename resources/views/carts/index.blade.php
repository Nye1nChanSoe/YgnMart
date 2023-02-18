@props([
    'products'
])

<x-layout>
    <x-container class="mt-14">
        <div class="rounded-lg py-5 px-10 shadow-sm border">
            <h4 class="text-xs text-gray-700">Shopping cart</h4>

            {{-- headings --}}
            <div class="flex justify-between py-4 border-b border-gray-200 text-sm font-semibold text-slate-700">
                <h3 class="basis-1/2">Product</h3>
                <h3>Quantity</h3>
                <h3>Price</h3>
            </div>

            {{-- cart container --}}
            <form action="/checkout" method="POST" class="divide-y divide-gray-200"
                x-data="{
                    count: 0,
                    total: 0,

                    init()
                    {
                    @foreach($carts as $cart)
                        this.count += {{$cart->quantity}}
                        this.total += {{$cart->product->price * $cart->quantity}}
                    @endforeach 
                    }
                }"
            >                    
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
                        <div class="basis-1/2 flex items-center">
                            <div class="mr-6">
                                <input type="checkbox" class="w-3.5 h-3.5" checked>
                            </div>
                            <div class="w-32 rounded-full mr-8">
                                <a href="/products/{{$cart->product->slug}}"><img src="{{$cart->product->image ? asset($cart->product->image) : asset('images/no-image.png')}}" alt=""></a>
                            </div>
                            <div class="basis-2/3">
                                <h4><a href="/products/{{$cart->product->slug}}">{{$cart->product->name}}</a></h4>

                                {{-- TODO: check product inventory and variants dynamically --}}
                                <p class="text-xs py-1 text-green-600 font-medium">In Stock</p>
                                <p class="text-xs py-1 text-gray-700">Product variant</p>
                                <div class="flex text-xs py-1 space-x-3">
                                    <button type="button" x-on:click="removeItem, $refs.item_{{$cart->id}}.remove()" class="text-red-500 hover:text-red-700">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            {{$cart->quantity}}
                        </div>
                        <div class="font-semibold">
                            {{number_format($cart->product->price, 0, '.', ',')}}
                        </div>
                    </div>
                    @endforeach
                @endif
                <template x-if="count == 0">
                    <div class="flex flex-col items-center">
                        <div class="mx-auto w-40 rotate-12">
                            <img src="/images/empty_cart.png" alt="">
                        </div>
                        <div class="pb-3 pt-6 text-center text-slate-700">
                            Your shopping cart is empty! 
                            <a href="/" class="block text-blue-500 hover:text-blue-700 mt-2">Add some items</a>
                        </div>
                    </div>
                </template>

                {{-- checkout --}}
                @if(!$carts->isEmpty())
                <template x-if="count > 0">
                    <div class="flex flex-col justify-center items-end pt-8 pb-3">
                        <div>
                            SubTotal (<span x-text="count" class="font-semibold" id="quantity="></span> items) 
                            <span x-text="total.toLocaleString('en-US')" class="text-lg font-semibold text-center bg-slate-100 px-3 py-[2px] rounded-lg"></span>
                        </div>
                        <button type="submit" class="text-sm bg-blue-500 text-white px-3 py-[4px] mt-4 rounded-lg shadow hover:bg-blue-600">
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
        fetch(`/cart/${this.id}`, {
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

</script>
