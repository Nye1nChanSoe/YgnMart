<x-admin-layout>
    <x-slot:title>
        Category - {{$category->sub_type}} | YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Categories</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.categories') . '?search=' . $category->type }}" class="{{ request()->routeIs('admin.categories') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">{{ $category->type }}</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.categories.show', $category->sub_type) }}" class="{{ request()->routeIs('admin.categories.show', $category->sub_type) ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">{{ $category->sub_type }}</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">

        <div x-data="{open:false, askPassword:false}" class="flex justify-around my-8 px-10">
            <div class="flex flex-col items-center">
                <div class="flex bg-slate-200 flex-shrink-0 items-center w-32 h-32 rounded-full overflow-hidden">
                    <img src="{{ asset('images/no-image.png') }}" alt="" class="w-full h-full object-contain">
                </div>
                <div class="mt-6 space-y-1.5 text-center text-gray-300">
                    <div class="pt-2.5">
                        <button x-on:click="open=!open" class="px-2.5 py-1.5 rounded-lg text-white bg-slate-500 hover:bg-slate-600">Edit Category</button>
                    </div>
                </div>
            </div>
            <div class="w-2/3">
                <form action="{{ route('admin.categories.show', $category->sub_type) }}" method="POST" class="py-4 px-4 bg-slate-600 rounded-lg text-gray-100 md:px-6">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="type">Main Category</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="type" id="type" type="text" value="{{ old('type') ?? $category->type }}" x-bind:readonly="!open" placeholder="Main Category..">
                        <x-input-error class="text-red-300" field="type" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="sub_type">Sub Category</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="sub_type" id="sub_type" type="text" value="{{ old('sub_type') ?? $category->sub_type }}" x-bind:readonly="!open" placeholder="Sub Category..">
                        <x-input-error class="text-red-300" field="sub_type" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-100 font-medium mb-2" for="description">Description</label>
                        <input class="border rounded w-full py-2 px-3 text-black leading-tight bg-slate-200 focus:outline-blue-500 focus:outline-2" name="description" id="description" type="text" value="{{ old('description') ?? $category->description }}" x-bind:readonly="!open" placeholder="Category Description..">
                        <x-input-error class="text-red-300" field="description" />
                    </div>
                    <button x-show="open" type="submit" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600">
                        Save Changes
                    </button>
                </form>

                <div class="mt-6">
                    <button x-on:click="askPassword=true" type="button" class="px-2.5 py-1.5 rounded-lg text-white bg-red-500 hover:bg-red-600">Delete Category</button>
                </div>
            </div>

            <!-- Blur Background -->
            <div x-show="askPassword" class="fixed inset-0 bg-gray-600 bg-opacity-50" x-cloak></div>

            <!-- Models -->
            <div x-show="askPassword" class="fixed z-10 inset-0 overflow-y-auto" x-cloak x-transition>
                <div class="flex items-center justify-center min-h-screen">
                    <div class="relative bg-gray-800 w-full max-w-sm mx-auto rounded-md shadow-lg px-4 py-3 md:px-8 md:py-5">
                        <div class="relative mb-6">
                            <h1 class="text-center text-gray-300 font-medium md:text-lg">Category Deletion</h1>
                            <button x-on:click="askPassword = false" class="absolute top-1.5 right-1.5"><x-icon name="close" class="text-gray-600 hover:text-blue-600" /></button>
                        </div>
                        <form action="{{ route('admin.categories.destroy', $category->sub_type) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-4">
                                <label class="block text-gray-300 mb-2" for="password">Enter Your Password</label>
                                <input class="border rounded w-full py-2 px-3 bg-slate-200 text-gray-700 leading-tight focus:outline-blue-500" name="password" id="password" type="password">
                            </div>
                            <button type="submit" class="px-2.5 py-1.5 w-full rounded-lg text-white bg-red-500 hover:bg-red-600">Delete Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</x-admin-layout>