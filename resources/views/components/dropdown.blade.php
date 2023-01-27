<div x-data="{ open: false }" class="relative">
    {{-- usually a button --}}
    {{$trigger}}

    {{-- drop down items AKA: links --}}
    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-28 mt-1 max-h-56 overflow-auto scrollbar rounded-xl border z-10 md:w-36" x-cloak x-transition>
        {{$slot}}
    </div>
</div>