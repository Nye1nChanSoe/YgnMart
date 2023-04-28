@php
    $user = auth()->user();
@endphp

<div x-data="{ open: false }" class="relative">
    <button @@click="open = !open" class="flex items-center justify-center border rounded-full w-8 h-8 overflow-hidden object-contain hover:text-blue-600 dark:hover:text-white dark:border-gray-700">
        @if ($user->image)
        <img src="{{ asset('storage/images/'.$user->image) }}" alt="" class="w-full h-full object-cover rounded-full">
        @else
        <img src="https://placehold.co/32/png" alt="" class="w-full h-full object-cover rounded-full">
        @endif
        <x-icon name="chevron-right" class="absolute -right-5 w-3.5 h-3.5" x-bind:class="{ 'rotate-90 transition-all duration-400':open }"/>
    </button>

    <div x-show="open" @@click.outside="open = false" class="absolute -left-20 py-2 mt-2 bg-white shadow-lg w-32 max-h-56 rounded-xl border border-slate-200 z-10 md:w-36 dark:bg-gray-700 dark:text-gray-200 dark:border-slate-600" x-cloak x-transition>
        @if ($user->role == 'user')
        <x-dropdown-item href="{{ route('profile', $user->username) }}">
            <div class="flex items-center">
                <div class="w-5 mr-2"><x-icon name="profile" /></div>
                <span class="truncate">{{ $user->name }}</span>
            </div>
        </x-dropdown-item>
        @else
        <x-dropdown-item href="{{ route('admin.show', $user->username) }}" target="_blank">
            <div class="flex items-center">
                <div class="w-5 mr-2"><x-icon name="profile" /></div>
                <span class="truncate">{{ $user->name }}</span>
            </div>
        </x-dropdown-item>
        @endif
        <x-dropdown-item href="{{ route('profile', $user->username) . '#history' }}">
            <div class="flex items-center">
                <div class="w-5 mr-2"><x-icon name="orders" /></div>
                <span>Orders</span>
            </div>
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('profile.settings', $user->username) }}">
            <div class="flex items-center">
                <div class="w-5 mr-2"><x-icon name="settings" /></div>
                <span>Settings</span>
            </div>
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('profile.help', $user->username) }}">
            <div class="flex items-center">
                <div class="w-5 mr-2"><x-icon name="help" /></div>
                <span>Help</span>
            </div>
        </x-dropdown-item>
        <form action="/logout" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="block w-full text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focus:text-white">
                <div class="flex items-center">
                    <div class="w-5 mr-2"><x-icon name="profile" /></div>
                    <span>Sign out</span>
                </div>
            </button>
        </form>
    </div>
</div>