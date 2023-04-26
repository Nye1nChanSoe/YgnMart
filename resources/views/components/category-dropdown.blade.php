<x-dropdown>
    <x-slot name="trigger">
        <button @@click="open=!open" class="
            inline-flex 
            items-center py-2 px-3 text-center text-sm font-semibold rounded-xl w-32 
            bg-slate-100 dark:bg-gray-700 hover:bg-slate-200 dark:hover:bg-gray-600" 
            x-bind:class="{ 'bg-slate-200': open }"
        >
            {{$type}}
            <x-icon name="chevron-right" class="pointer-events-none ml-4 dark:text-gray-300" 
                x-bind:class="{ 'rotate-90 transition-all duration-400':open }"
            />
        </button>
    </x-slot>

    @foreach ($subTypes as $subType)
    @php
        $searchSubType = strtolower(str_replace(' ', '-',$subType));
    @endphp
    <x-dropdown-item 
        href="/?category={{ $searchSubType }}"
        :active="request()->query('category') === $searchSubType"
    >
        {{$subType}}
    </x-dropdown-item>
    @endforeach
</x-dropdown>