@props(['type'])

<x-dropdown>
    <x-slot name="trigger">
        <button @@click="open=!open" class="inline-flex items-center hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
            {{$type}}
            <x-icon name="chevron-right" class="absolute pointer-events-none right-4 lg:right-4" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
        </button>
    </x-slot>

    {{-- TODO: populate drop down items with category records from database --}}
    @foreach ($categories->where('type', $type) as $category)
        <x-dropdown-item href="/">
            {{$category->name}}
        </x-dropdown-item>
    @endforeach
</x-dropdown>