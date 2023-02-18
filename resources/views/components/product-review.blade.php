<div class="flex items-center">
    <div class="flex">
        <i class="fa-solid fa-star text-xs text-yellow-400"></i>
        <i class="fa-solid fa-star text-xs text-yellow-400"></i>
        <i class="fa-solid fa-star text-xs text-yellow-400"></i>
        <i class="fa-solid fa-star text-xs text-slate-200"></i>
        <i class="fa-solid fa-star text-xs text-slate-200"></i>
        {{-- TODO: hovering chevron will popup the ratings detail info --}}
        {{-- linear-gradient for half fill --}}
        <svg class="inline w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    {{-- move to the rating section anchor add as url fragment --}}
    <a href="#" class="text-sm text-blue-500 hover:text-blue-700 ml-2">{{rand(5, 80)}}</a>
</div>