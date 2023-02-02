@props([
    'products'
])

<x-layout>
    <x-container>
        <div class="rounded-lg py-5 px-10 shadow-sm border">
            <h4 class="text-xs text-slate-500">Shopping cart</h4>

            {{-- headings --}}
            <div class="flex justify-between py-4 border-b border-gray-200 text-sm font-semibold">
                <h3 class="basis-1/2">Product</h3>
                <h3>Quantity</h3>
                <h3>Price</h3>
            </div>

            {{-- cart container --}}
            <form action="/checkout" method="POST" class="divide-y divide-gray-200">                    
                {{-- cart item --}}
                @if (!$carts->isEmpty())
                    @foreach ($carts as $cart)
                    <div class="flex justify-between items-center py-3">
                        <div class="basis-1/2 flex items-center">
                            <div class="mr-6">
                                <input type="checkbox" class="w-3.5 h-3.5" checked>
                            </div>
                            <div class="w-32 rounded-full mr-8">
                                <a href="/products/{{$cart->product->slug}}"><img src="{{$cart->product->image ? asset($cart->product->image) : asset('images/no-image.png')}}" alt=""></a>
                            </div>
                            <div class="basis-2/3">
                                <h4><a href="/products/{{$cart->product->slug}}">{{$cart->product->name}}</a></h4>
                            </div>
                        </div>
                        <div class="relative text-sm">
                            {{$cart->quantity}}
                        </div>
                        <div class="font-semibold">
                            {{number_format($cart->product->price, 0, '.', ',')}}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="pb-3 pt-6 text-center">Your cart is empty! Add some items</div>
                @endif

                {{-- checkout --}}
                @if(!$carts->isEmpty())
                <div class="flex flex-col justify-center items-end pt-8 pb-3 text-lg">
                    <div>
                        SubTotal (<span x-text="count"></span>items) <span x-text="total"></span>
                    </div>
                    <button type="submit" class="text-sm bg-blue-500 text-white px-3 py-[4px] mt-2 rounded-lg shadow hover:bg-blue-600">
                        Proceed to checkout
                    </button>
                </div>
                @endif
            </form>
        </div>
    </x-container>
</x-layout>


{{-- <script>
    function add()
    {
        this.quantity += 1;
        console.log(this.quantity);
    }
    
    function remove()
    {
        this.quantity -= 1;
        console.log(this.quantity);
    }
</script> --}}