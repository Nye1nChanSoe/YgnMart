<div x-data="{ open: false }" class="relative">
    {{-- usually a button --}}
    {{$trigger}}

    {{-- drop down items AKA: links --}}
    <div x-show="open" @@click.outside="open = false" class="absolute py-2 z-10 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl border md:w-36 dark:border-slate-600 dark:bg-gray-700" x-cloak x-transition>
        {{$slot}}
    </div>
</div>