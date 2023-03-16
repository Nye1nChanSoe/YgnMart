<div class="flex items-center">
    <div class="flex">
        <x-icon name="star-solid" class="text-yellow-400" />
        <x-icon name="star-solid" class="text-yellow-400" />
        <x-icon name="star-solid" class="text-yellow-400" />
        <x-icon name="star-solid" class="text-slate-300" />
        <x-icon name="star-solid" class="text-slate-300" />
        {{-- TODO: hovering chevron will popup the ratings detail info --}}
        {{-- linear-gradient for half fill --}}
        <svg class="inline w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    <a href="#review" class="text-sm text-blue-500 hover:text-blue-700 ml-2">{{rand(5, 80)}}</a>
    {{ $slot }}
</div>