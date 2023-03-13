<x-layout>
    <div class="bg-forcefields md:p-20 xl:mx-40">
        <x-container>
            <div class="flex flex-col items-center p-10 md:p-20">
                <div class="text-gray-600">
                    <p class="text-3xl font-base text-center">Thank you for purchasing from <span class="text-slate-600 font-semibold">Yangon Mart</span></p>
                    <p class="mt-6 text-center text-green-600">We have processed your order and it will arrive soon</p>
                </div>
                <div class="grid grid-cols-2 gap-4 justify-center mt-12 text-gray-600">
                    <a href="/orders/{{$order->order_code}}">
                        <div class="flex flex-col items-center justify-center h-full bg-slate-50 p-4 border rounded-lg transition-all duration-300 hover:-translate-y-3 hover:bg-slate-100 hover:text-blue-500">
                            <svg class="w-7 h-7 mb-3 md:w-9 md:h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                            </svg>
                            <span class="text-xs font-semibold text-center md:text-sm">Check Order</span>
                        </div>
                    </a>
                    <a href="{{route('home')}}">
                        <div class="flex flex-col items-center justify-center h-full bg-slate-50 p-4 border rounded-lg transition-all duration-300 hover:-translate-y-3 hover:bg-slate-100 hover:text-blue-500">
                            <svg class="w-7 h-7 mb-3 md:w-9 md:h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span class="text-xs font-semibold text-center md:text-sm">Keep Shopping</span>
                        </div>
                    </a>
                </div>
            </div>
        </x-container>
    </div>
</x-layout>
