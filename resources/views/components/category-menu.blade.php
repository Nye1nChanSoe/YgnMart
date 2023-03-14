<div 
    x-data="{ open:false }" 
>
    <button type="button" @@click="open=!open" class="flex justify-between items-center w-full py-2 px-3 border-b" x-bind:class="{ 'border-b-0':open }">
        <h3 class="text-sm font-semibold">{{$type}}</h3>
        <x-icon name="chevron-down" x-bind:class="{ 'rotate-180 transition-all duration-400':open }" />
    </button>

    <div x-show="open" class="h-32 overflow-y-scroll scrollbar border-b" x-cloak x-transition>
        @foreach ($subTypes as $subType)
        @php
            $searchSubType = strtolower(str_replace(' ', '-', $subType));
        @endphp
        <x-dropdown-item 
            href="/?category={{ $searchSubType }}"
            :active="request()->query('category') === $searchSubType"
            class="px-3 leading-7"
        >
            {{$subType}}
        </x-dropdown-item>
        @endforeach
    </div>
</div>