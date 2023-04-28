<x-admin-layout>
    <x-slot:title>
        Manage Categories - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Categories</a>
        </li>
    </ul>

    <section x-data="{ open:false }" class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-gray-300 font-medium">Category List</h1>
            <div class="flex items-center gap-x-4">
                <button x-on:click="open=!open" type="button" class="px-2.5 py-1.5 rounded-lg text-gray-100 bg-sky-600 hover:bg-sky-700">Add New Category</button>
            </div>
        </div>

        @unless ($categories->isEmpty())
        <div class="relative shadow rounded">
            <table class="w-full text-sm text-slate-200 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start">
                            No
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Sub Type
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr x-on:click="window.location.href = '{{ route('admin.categories.show', $category->sub_type) }}'" class="bg-slate-500 even:bg-slate-600 cursor-pointer hover:bg-gray-800">
                            <td class="px-6 py-2">
                                <div>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $category->type }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="text-white font-semibold">{{ $category->sub_type }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="w-72 overflow-hidden lg:w-96">
                                    <p class="truncate">{{ $category->description }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex items-center gap-x-2">
                                    <time>{{\Carbon\Carbon::parse($category->updated_at)->format('M j, Y')}}</time>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-sm mt-4">
            {{ $categories->links('vendor.pagination.links') }}
        </div>
        @else
        <div class="flex items-center justify-center w-full h-60">
            <p class="text-gray-400">No category Found!</p>
        </div>
        @endunless

        <!-- Blur Background -->
        <div x-show="open" class="fixed inset-0 bg-gray-600 bg-opacity-50" x-cloak></div>

        <!-- Models -->
        <div x-show="open" class="fixed z-10 inset-0 overflow-y-auto" x-cloak x-transition>
            <div class="flex items-center justify-center min-h-screen">
                <div class="relative bg-gray-800 w-full max-w-sm mx-auto rounded-md shadow-lg px-4 py-3 md:px-8 md:py-5">
                    <div class="relative mb-6">
                        <h1 class="text-center text-gray-300 font-medium md:text-lg">Add New Category</h1>
                        <button x-on:click="open = false" class="absolute top-1.5 right-1.5"><x-icon name="close" class="text-gray-600 hover:text-blue-600" /></button>
                    </div>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-300 font-medium mb-3" for="type">Main Type</label>
                            @foreach ($mainCategories as $category)
                            <div class="flex items-center mb-2.5">
                                <input id="type" type="radio" name="type" value="{{ $category }}" class="w-4 h-4 text-blue-400 bg-gray-100 border-gray-300" {{$loop->iteration == 1 ? 'checked' : ''}}>
                                <label for="type" class="ml-2 text-sm font-medium text-gray-300">{{ $category }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 font-medium mb-2" for="sub_type">Sub Type</label>
                            <input class="border rounded w-full py-2 px-3 bg-slate-200 text-black leading-tight focus:outline-blue-500" name="sub_type" id="sub_type" type="text" value="" placeholder="Capsule">
                            <x-input-error field="sub_type" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 font-medium mb-2" for="description">Description</label>
                            <input class="border rounded w-full py-2 px-3 bg-slate-200 text-black leading-tight focus:outline-blue-500" name="description" id="description" type="text" value="" placeholder="Provide description for the category...">
                            <x-input-error field="description" />
                        </div>
                        <button type="submit" class="px-2.5 py-1.5 w-full rounded-lg text-white bg-blue-500 hover:bg-blue-600">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>