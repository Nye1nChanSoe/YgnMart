<x-vendor-layout>
    <x-slot:title>
        Edit {{ $product->name }} - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.show', $product->slug) }}" class="{{ request()->routeIs(route('vendor.products.show', $product->slug)) ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Detail</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.edit', $product->slug) }}" class="text-blue-600 hover:text-blue-600">Edit</a>
        </li>
    </ul>

    <section 
        x-data="{
            openCategory: true,
            openProduct: false,
            openInventory: false,
            stage: 'category',
        }" 
        class="px-3 py-3 mt-4 shadow rounded"
    >
        <form action="{{ route('vendor.products.update', $product->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="px-6 py-6 border-b">
                <div class="flex items-center gap-x-10">
                    <h1 class="text-gray-500" x-bind:class="{'font-medium text-blue-700' : stage == 'category'}">
                        <button type="button" @@click="openCategory=true; openProduct=false; openInventory=false; stage='category'">Category</button>
                    </h1>
                    <h1 class="text-gray-500" x-bind:class="{'font-medium text-blue-700' : stage == 'product'}">
                        <button type="button" @@click="openCategory=false; openProduct=true; openInventory=false; stage='product'">Product</button>
                    </h1>
                    <h1 class="text-gray-500" x-bind:class="{'font-medium text-blue-700' : stage == 'inventory'}">
                        <button type="button" @@click="openCategory=false; openProduct=false; openInventory=true; stage='inventory'">Inventory</button>
                    </h1>
                </div>
            </div>
    
            <section 
                x-show="openCategory" 
                x-data="{
                    type: '{{ $product->categories()->first()->type }}', 
                    items: [],

                    init()
                    {
                        @foreach($product->categories as $category)
                        this.items.push('{{ $category->sub_type }}');
                        @endforeach
                    }
                }"
                x-transition 
                x-cloak

                class="px-6 py-6" 
            >
                <h1 class="font-medium">1. Selected categories for {{ $product->name }}</h1>
                <div class="text-sm text-gray-400 mt-1.5 ml-1 font-normal">Note: you can only select one main category</div>
                <div class="text-gray-700 flex gap-x-16 mt-10">
                    <div x-data="{open:true}">
                        <div class="flex items-center hover:text-blue-600 mb-3">
                            <button type="button" @@click="open=!open">Main Category
                                <x-icon name="chevron-right" class="ml-2 pointer-events-none inline" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                            </button>
                        </div>
                        <div x-show="open" x-transition x-cloak>
                            <div class="flex flex-col">
                                @foreach ($categories->pluck('type')->unique() as $category)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="{{ $category }}" x-model="type" @@change="() => items = []">
                                    <span class="ml-2">{{ $category }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <x-input-error field="type" />
                    </div>
    
                    <template x-if="type==='Food'">
                        <div x-data="{open:true}" x-cloak>
                            <div class="flex items-center hover:text-blue-600 mb-3">
                                <button type="button" @@click="open=!open">Food Categories
                                    <x-icon name="chevron-right" class="ml-2 pointer-events-none inline" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                                </button>
                            </div>
                            <div x-show="open" x-cloak>
                                <div class="flex flex-col">
                                    @php
                                        $subCategories = $categories->filter(fn($category) => $category->type === 'Food')->pluck('sub_type');
                                    @endphp
                                    @foreach ($subCategories as $category)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="sub_type[]" value="{{ $category }}" x-model="items" x-bind:checked="items.includes('{{ $category }}')">
                                        <span class="ml-2">{{ $category }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <x-input-error field="sub_type" />
                        </div>
                    </template>
    
                    <template x-if="type==='Drinks'">
                        <div x-data="{open:true}" x-cloak>
                            <div class="flex items-center hover:text-blue-600 mb-3">
                                <button type="button" @@click="open=!open">Beverages Categories
                                    <x-icon name="chevron-right" class="ml-2 pointer-events-none inline" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                                </button>
                            </div>
                            <div x-show="open" x-cloak>
                                <div class="flex flex-col">
                                    @php
                                        $subCategories = $categories->filter(fn($category) => $category->type === 'Drinks')->pluck('sub_type');
                                    @endphp
                                    @foreach ($subCategories as $category)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="sub_type[]" value="{{ $category }}" x-model="items">
                                        <span class="ml-2">{{ $category }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <x-input-error field="sub_type" />
                        </div>
                    </template>
    
                    <template x-if="type==='Households'">
                        <div x-data="{open:true}" x-cloak>
                            <div class="flex items-center hover:text-blue-600 mb-3">
                                <button type="button" @@click="open=!open">Household Categories
                                    <x-icon name="chevron-right" class="ml-2 pointer-events-none inline" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                                </button>
                            </div>
                            <div x-show="open" x-cloak>
                                <div class="flex flex-col">
                                    @php
                                        $subCategories = $categories->filter(fn($category) => $category->type === 'Households')->pluck('sub_type');
                                    @endphp
                                    @foreach ($subCategories as $category)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="sub_type[]" value="{{ $category }}" x-model="items">
                                        <span class="ml-2">{{ $category }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <x-input-error field="sub_type" />
                        </div>
                    </template>
                </div>
                <div class="mt-12 flex justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Category: <span x-show="type" class="bg-green-600 px-2 py-1 text-white rounded-lg" x-text="type" x-cloak x-transition></span></p>
                        <p class="text-sm text-gray-600 mt-2.5">Sub Categories: <span class="font-medium text-green-600 text-sm" x-text="items.join(', ')"></span></p>
                    </div>
                    <button class="bg-blue-500 text-white px-5 py-1 rounded-lg self-end hover:bg-blue-700" type="button" @@click="openCategory=false; openProduct=true; openInventory=false; stage='product'">Next</button>
                </div>
            </section>
    
            <section class="px-6 py-6" x-show="openProduct" x-transition x-cloak>
                <h1 class="font-medium">2. Product Information</h1>
                <div class="text-gray-700 mt-10">
                    <div class="grid grid-cols-3 gap-x-10">
                        <div>
                            <label for="name" class="block mb-1.5">Product Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') ?? $product->name }}" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Name of the product...">
                            <x-input-error field="name" />
                        </div>
                        <div>
                            <label for="meta_type" class="block mb-1.5">Meta Type</label>
                            <input id="meta_type" type="text" name="meta_type" value="{{ old('meta_type') ?? $product->meta_type }}" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Apple, Banana, Water...">
                            <x-input-error field="meta_type" />
                        </div>
                        <div>
                            <label for="price" class="block mb-1.5">Product Price</label>
                            <input id="price" type="number" name="price" value="{{ old('price') ?? $product->price }}" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Product Price...">
                            <x-input-error field="price" />
                        </div>
                    </div>
                    <div class="w-full mt-6">
                        <div>
                            <label for="description" class="block mb-1.5">Product Description</label>
                            <textarea name="description" id="description" class="border resize-none rounded w-full py-2 px-3 h-36 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Write an explicit description about the product">{{ old('description') ?? $product->description }}</textarea>
                            <x-input-error field="description" />
                        </div>
                    </div>
                    <div class="w-full mt-6">
                        <h3 class="mb-1.5">Upload Product Image</h3>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-row items-center justify-between w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="w-1/2 flex flex-col items-center justify-center pt-5 pb-6">
                                    <x-icon name="cloud" class="w-16 h-16 text-gray-500" />
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, Webp or SVG (MAX. 2000x200px)</p>
                                </div>
                                <div id="image-container" class="w-1/2 flex items-center justify-center bg-slate-50 border h-full">
                                    @if ($product->image)
                                    <img src="{{ asset('storage/images/'.$product->image) }}" alt="" class="w-full h-full object-cover shrink-0">
                                    @else
                                    <img src="https://placehold.co/400/png" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <script>
                                    function previewImage(event) {
                                        var img = event.target.files[0];
                                        var reader = new FileReader();
                                        reader.onload = function(e) {
                                            document.querySelector('#image-container img').setAttribute('src', e.target.result);
                                        }
                                        reader.readAsDataURL(img);
                                        console.log('sds');
                                    }
                                </script>
                                <input id="image" type="file" name="image" class="hidden" value="{{ $product->image }}" onchange="previewImage(event)"/>
                            </label>
                        </div> 
                        <x-input-error field="image" />
                    </div>
                    <div class="mt-6 w-full flex justify-end">
                        <button class="bg-blue-500 text-white px-5 py-1 rounded-lg self-end hover:bg-blue-700" type="button" @@click="openCategory=false; openProduct=false; openInventory=true; stage='inventory'">Next</button>
                    </div>
                </div>
            </section>
    
            <section class="px-6 py-6" x-show="openInventory" x-transition x-cloak>
                <h1 class="font-medium">3. Refill Stock Amount</h1>
                <div 
                    x-data="{
                        amount: {{ $product->inventory->in_stock_quantity }},
                        minimum: {{ $product->inventory->minimum_quantity }}
                    }" 
                    class="text-gray-700 mt-10"
                >
                    <div>
                        <label for="in_stock_quantity" class="block mb-1.5">Stock Amount</label>
                        <input id="in_stock_quantity" type="number" name="in_stock_quantity" x-bind:min="50" x-model="amount" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Total number of products in the stock...">
                        <x-input-error field="in_stock_quantity" />
                    </div>
                    <div class="mt-6">
                        <label for="minimum_quantity" class="block mb-1.5">Minimum In Stock Amount</label>
                        <input id="minimum_quantity" type="number" name="minimum_quantity" x-bind:min="50" x-bind:max="amount-50" x-model="minimum" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Minimum number of products in stock...">
                        <x-input-error field="minimum_quantity" />
                    </div>
                    <div class="mt-6 flex flex-col">
                        <label class="block mb-1.5">Stock Status</label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="sell" {{ $product->inventory->status == 'sell' ? 'checked' : '' }}>
                            <span class="ml-2">Open</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="close" {{ $product->inventory->status == 'close' ? 'checked' : '' }}>
                            <span class="ml-2">Close</span>
                        </label>
                        <x-input-error field="status" />
                    </div>
                </div>
                <div class="mt-6 w-full flex justify-end">
                    <button class="bg-blue-500 text-white px-5 py-1 rounded-lg self-end hover:bg-blue-700" type="submit">Update</button>
                </div>
            </section>
        </form>
    </section>
</x-vendor-layout>