<x-admin-layout>
    <x-slot:title>
        Manage Categories - YangonMart.com
    </x-slot:title>
    <ul class="flex items-center my-3 px-3 py-3 text-sm">
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">Dashboard</a><x-icon name="chevron-right" class="text-gray-300" />
        </li>
        <li class="flex items-center ml-2 gap-x-1">
            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'text-sky-100 font-bold' : 'text-gray-100' }} hover:text-sky-100">categories</a>
        </li>
    </ul>

    <section class="mt-4 px-3 py-3 bg-gray-700 shadow rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl text-gray-300 font-medium">Category List</h1>
        </div>

        @unless ($categories->isEmpty())
        <div class="relative shadow rounded">
            <table class="w-full text-sm text-slate-700 dark:text-gray-400">
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
                <tbody x-data="">
                    @foreach ($categories as $category)
                        <tr x-on:click="window.location.href = '{{ route('admin.categories.show', $category->sub_type) }}'" class="bg-slate-200 border-b even:bg-slate-200/90 dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-200">
                            <td class="px-6 py-2">
                                <div>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div>{{ $category->type }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="text-gray-900">{{ $category->sub_type }}</div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="w-72 overflow-hidden lg:w-96">
                                    <p class="truncate">{{ $category->description }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex items-center gap-x-2">
                                    <time>{{\Carbon\Carbon::parse($category->updated_at)->format('M j, Y')}}</time>
                                    <time>{{\Carbon\Carbon::parse($category->updated_at)->format('g:i A')}}</time>
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

    </section>
</x-admin-layout>