@props([
    'product',
    'categories'
])

<x-layout>
    <section class="container mx-auto mb-20 px-3 md:px-8">
        {{-- TODO: breadcrumbs --}}
        <div class="my-10">
            implement > breadcrumbs > links > here
        </div>

        {{-- product view --}}
        <div class="flex items-center justify-center space-x-2">
            <div class="basis-1/3">
                <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="">
            </div>

            {{-- product info --}}
            <div class="basis-1/2 p-10 bg-slate-50 rounded-lg space-y-3">
                <div class="flex items-center">
                    @foreach ($categories as $category)
                        <div class="text-xs text-slate-600 px-3 py-1 border border-blue-400 rounded-full hover:text-black hover:border-blue-600">
                            {{$category->name}}
                        </div>
                    @endforeach
                </div>
                <div>
                    <h3 class="font-semibold text-xl py-2">{{$product->name}}</h3>
                </div>
                <div class="flex justify-between w-full items-center">
                    <x-product-review/>
                    <div class="text-blue-500 hover:text-blue-700">
                        <a href="#">Visit the Vendor</a>
                    </div>
                </div>
                <div class="flex items-center pt-4">
                    <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                    <div class="ml-3">Save 10% for current promotion</div>
                </div>
                <div class="pt-4 text-zinc-800">
                    <h3 class="font-semibold mb-2">Product Description</h3>
                    <p class="indent-10 leading-7 text-sm">{{$product->description}}</p>
                </div>

                {{-- add to cart --}}
                <div 
                    x-data="{
                        open: false,
                        quantity: 1,
                    }"
                    class="flex items-center pt-4 space-x-4"
                >
                    <form action="" method="post">
                        @csrf
                        {{-- x-model is two-way bound, meaning it both "sets" and "gets". In addition to changing data, if the data itself changes, the element will reflect the change. --}}
                        <input type="hidden" name="quantity" x-model="quantity">
                        <x-button class="rounded-full shadow-lg bg-blue-400">
                            <x-icon name="cart" />
                        </x-button>
                    </form>
                    
                    <div class="relative">
                        <button @@click="open = !open" class="flex items-center bg-gray-200 text-xs px-2 py-1 rounded-full ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-400">
                            <div class="font-medium mr-1.5">
                                Qty: <span x-text="quantity"></span>
                            </div>
                            <x-icon name="chevron-right" class="w-3.5 h-3" x-bind:class="{ 'rotate-90 transition-all duration-400':open }"/>
                        </button>
                    
                        <div x-show="open" @@click.outside="open = false" class="absolute py-2 mt-1 bg-white shadow-lg w-20 max-h-56 overflow-auto scrollbar rounded-xl border border-slate-200 z-10" x-cloak x-transition>
                            <ul>
                                @for ($i = 0; $i < 100; $i++)
                                <li>
                                    <x-dropdown-item 
                                        class="leading-6" 
                                        x-on:click="quantity = {{$i}}, open = false"
                                    >
                                        {{$i}}
                                    </x-dropdown-item>
                                </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-4 space-y-1">
                    <div class="flex text-sm items-center space-x-2 ">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex text-sm items-center space-x-2 ">
                        <span>Multipayment Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- related products --}}
        <div class="bg-slate-200 w-full mt-10">
            <p>List of related products here</p>
        </div>
    </section>
</x-layout>