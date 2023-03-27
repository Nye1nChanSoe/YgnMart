<x-vendor-layout>
    <div class="mt-4 px-3 py-3 shadow rounded-lg">
        <div class="grid grid-cols-7 items-center justify-items-center py-2 text-gray-700 font-medium md:grid-cols-7">
            <h1 class="col-span-1">No</h1>
            <h1 class="col-span-2">Product</h1>
            <h1 class="col-span-1">Price</h1>
            <h1 class="col-span-1">Type</h1>
            <h1 class="col-span-1">Rating</h1>
            <h1 class="col-span-1">Updates</h1>
        </div>
        <a href="" class="block grid grid-cols-7 even:bg-gray-50 items-center justify-items-center rounded py-1 text-gray-700 hover:bg-gray-100 md:grid-cols-7">
            <div class="col-span-1">1</div>
            <div class="justify-self-start col-span-2">
                <div class="flex items-center gap-x-4">
                    <div class="flex items-center w-16 h-16">
                        <img src="{{asset('images/no-image.png')}}" alt="" class="w-full h-full object-contain">
                    </div>
                    <div class="">
                        <p>A fresh orange Lorem ipsum dolor sit amet consectetur</p>
                    </div>
                </div>
            </div>
            <div class="col-span-1">{{number_format('5000', 0, '.', ',')}}</div>
            <div class="col-span-1">Alcohol</div>
            <div class="col-span-1">3.95</div>
            <div class="col-span-1">{{ now()->diffForHumans() }}</div>
        </a>
    </div>
</x-vendor-layout>