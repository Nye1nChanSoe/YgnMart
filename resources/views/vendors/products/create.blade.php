<x-vendor-layout>
    <x-slot:title>
        Add new product - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Dashboard</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products') }}" class="{{ request()->routeIs('vendor.products') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Products</a><x-icon name="chevron-right" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('vendor.products.create') }}" class="{{ request()->routeIs('vendor.products.*') ? 'text-blue-600' : 'text-gray-700' }} hover:text-blue-600">Upload New Product</a>
        </li>
    </ul>
    <section 
        x-data="{
            openCategory: true,
            openProduct: false,
            openInventory: false,
            stage: 'category',
        }" 
        class="mx-10 mt-6 shadow rounded"
    >
        <form action="{{ route('vendor.products.store') }}" method="POST">
            @csrf
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
                    type: '', 
                    items: [],
                }" 
                class="px-6 py-6" 
                x-transition 
                x-cloak
            >
                <h1 class="font-medium">1. Select the Category you want to sell</h1>
                <div class="text-gray-700 flex gap-x-16 mt-10">
                    <div x-data="{open:false}">
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
                                        <input type="checkbox" name="sub_type[]" value="{{ $category }}" x-model="items">
                                        <span class="ml-2">{{ $category }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <x-input-error field="sub_type" />
                        </div>
                    </template>
    
                    <template x-if="type==='Beverages'">
                        <div x-data="{open:true}" x-cloak>
                            <div class="flex items-center hover:text-blue-600 mb-3">
                                <button type="button" @@click="open=!open">Beverages Categories
                                    <x-icon name="chevron-right" class="ml-2 pointer-events-none inline" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                                </button>
                            </div>
                            <div x-show="open" x-cloak>
                                <div class="flex flex-col">
                                    @php
                                        $subCategories = $categories->filter(fn($category) => $category->type === 'Beverages')->pluck('sub_type');
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
    
                    <template x-if="type==='Household'">
                        <div x-data="{open:true}" x-cloak>
                            <div class="flex items-center hover:text-blue-600 mb-3">
                                <button type="button" @@click="open=!open">Household Categories
                                    <x-icon name="chevron-right" class="ml-2 pointer-events-none inline" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                                </button>
                            </div>
                            <div x-show="open" x-cloak>
                                <div class="flex flex-col">
                                    @php
                                        $subCategories = $categories->filter(fn($category) => $category->type === 'Household')->pluck('sub_type');
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
                <h1 class="font-medium">2. Fill Product Information</h1>
                <div class="text-gray-700 mt-10">
                    <div class="grid grid-cols-3 gap-x-10">
                        <div>
                            <label for="name" class="block mb-1.5">Product Name</label>
                            <input id="name" type="text" name="name" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Name of the product...">
                            <x-input-error field="name" />
                        </div>
                        <div>
                            <label for="meta_type" class="block mb-1.5">Meta Type</label>
                            <input id="meta_type" type="text" name="meta_type" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Apple, Banana, Water...">
                            <x-input-error field="meta_type" />
                        </div>
                        <div>
                            <label for="price" class="block mb-1.5">Product Price</label>
                            <input id="price" type="number" name="price" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Product Price...">
                            <x-input-error field="price" />
                        </div>
                    </div>
                    <div class="w-full mt-6">
                        <div>
                            <label for="description" class="block mb-1.5">Product Description</label>
                            <textarea name="description" id="description" class="border resize-none rounded w-full py-2 px-3 h-36 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Write an explicit description about the product"></textarea>
                            <x-input-error field="description" />
                        </div>
                    </div>
                    <div class="w-full mt-6">
                        <h3 class="mb-1.5">Upload Product Image</h3>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <x-icon name="cloud" class="w-16 h-16 text-gray-500" />
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input id="image" type="file" name="image" class="hidden" />
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
                <h1 class="font-medium">3. Fill Stock Amount</h1>
                <div x-data="{amount: 100}" class="text-gray-700 mt-10">
                    <div>
                        <label for="in_stock_quantity" class="block mb-1.5">Stock Amount</label>
                        <input id="in_stock_quantity" type="number" name="in_stock_quantity" x-model="amount" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Total number of products in the stock...">
                        <x-input-error field="in_stock_quantity" />
                    </div>
                    <div class="mt-6">
                        <label for="minimum_quantity" class="block mb-1.5">Minimum In Stock Amount</label>
                        <input id="minimum_quantity" type="number" name="minimum_quantity" x-bind:min="amount - 50" x-bind:max="amount" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-blue-300" placeholder="Minimum number of products in stock...">
                        <x-input-error field="minimum_quantity" />
                    </div>
                    <div class="mt-6 flex flex-col">
                        <label class="block mb-1.5">Stock Status</label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="sell">
                            <span class="ml-2">Open</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="close">
                            <span class="ml-2">Close</span>
                        </label>
                        <x-input-error field="status" />
                    </div>
                </div>
                <div class="mt-6 w-full flex justify-end">
                    <button class="bg-blue-500 text-white px-5 py-1 rounded-lg self-end hover:bg-blue-700" type="submit">Submit</button>
                </div>
            </section>
        </form>
    </section>
</x-vendor-layout>