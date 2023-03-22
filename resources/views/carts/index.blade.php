<x-layout>
    <x-slot:title>
        Cart - YangonMart.com
    </x-slot:title>
    <x-container class="mt-14">
        <div class="rounded-lg px-4 py-5 shadow-sm border md:px-10">
            <h4 class="text-xs text-gray-700">Shopping cart</h4>

            {{-- headings --}}
            <div class="flex justify-between py-4 border-b border-gray-200 text-sm font-semibold text-slate-700">
                <h3 class="basis-1/2">Product</h3>
                <h3>Quantity</h3>
                <h3>Price</h3>
            </div>

            {{-- cart container --}}
            <form action="{{ route('carts.checkout') }}" method="POST" class="divide-y divide-gray-200"
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
                        <div class="basis-1/2 flex flex-col items-center justify-center space-y-4 sm:space-y-0 sm:flex-row sm:justify-left">
                            <div class="hidden mr-6 sm:block">
                                <input type="checkbox" class="w-3.5 h-3.5" checked>
                            </div>
                            <div class="w-20 rounded-full sm:mr-8 sm:w-32">
                                <a href="/products/{{$cart->product->slug}}"><img src="{{$cart->product->image ? asset($cart->product->image) : asset('images/no-image.png')}}" alt=""></a>
                            </div>
                            <div class="sm:basis-2/3">
                                <h4 class="text-sm sm:text-base"><a href="/products/{{$cart->product->slug}}">{{$cart->product->name}}</a></h4>

                                {{-- TODO: check product inventory and variants dynamically --}}
                                <p class="text-xs py-1 text-green-600 font-medium">In Stock</p>
                                <p class="text-xs py-1 text-gray-700">Product variant</p>
                                <div class="flex text-xs py-1 space-x-3">
                                    <button type="button" x-on:click="removeItem, $refs.item_{{$cart->id}}.remove()" class="text-red-500 hover:text-red-700">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="relative text-sm sm:text-base">
                            {{$cart->quantity}}
                        </div>
                        <div class="px-2 py-1 bg-yellow-300 rounded-lg font-semibold text-sm sm:text-base sm:p-0 sm:bg-white sm:rounded-none">
                            {{number_format($cart->product->price, 0, '.', ',')}}
                            <span class="text-xs font-normal text-gray-600">K</span>
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
                        <div class="pb-3 pt-6 text-center text-slate-700">
                            Your shopping cart is empty! 
                            <a href="/" class="block text-blue-500 hover:text-blue-700 mt-2">Add some items</a>
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
                            <div class="bg-slate-100 px-3 py-[2px] rounded-lg inline-flex items-center space-x-1">
                                <span x-text="total.toLocaleString('en-US')" class="text-lg font-semibold text-center"></span>
                                <span class="text-xs">Kyat</span>
                            </div>
                        </div>
                        <button type="submit" class="text-base bg-blue-500 text-white px-3 py-[4px] mt-6 rounded-lg shadow hover:bg-blue-600 sm:text-lg sm:px-4 sm:py-2">
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

</script>
