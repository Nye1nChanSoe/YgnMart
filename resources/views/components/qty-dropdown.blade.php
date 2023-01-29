<div x-data="{ open: false }" class="relative">
    <button @@click="open = !open" class="flex items-center bg-gray-200 text-xs px-2 py-1 rounded-full ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-400">
        <div class="font-medium">
            Qty: @{{quantity}}
        </div>
        <x-icon name="chevron-right" class="w-3.5 h-3" x-bind:class="{ 'rotate-90 transition-all duration-400':open }"/>
    </button>

    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-20 max-h-56 overflow-auto scrollbar rounded-xl border border-slate-200 z-10" x-cloak x-transition>
        <ul>
            @for ($i = 0; $i < 100; $i++)
            <li>
                <x-dropdown-item class="leading-6 font-medium">
                    {{$i}}
                </x-dropdown-item>
            </li>
            @endfor
        </ul>
    </div>
</div>