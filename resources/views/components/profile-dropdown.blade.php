<div x-data="{ open: false }" class="relative">
    <button @@click="open = !open" class="flex items-center justify-center w-9 rounded-full">
        <img src="/images/grocery/apple.jpeg" alt="" width="34">
        <x-icon name="chevron-right" class="absolute -right-2 w-3.5 h-3.5" x-bind:class="{ 'rotate-90 transition-all duration-400':open }"/>
    </button>

    <div x-show="open" @@click.outside="open = false" class="absolute -left-20 py-2 mt-2 bg-white shadow-lg w-28  max-h-56 overflow-auto scrollbar rounded-xl border border-slate-200 z-10 md:w-36" x-cloak x-transition>
        <x-dropdown-item href="/profile">
            <div class="flex items-center">
                <x-icon name="profile" class="inline mr-2" />
                <span>Profile</span>
            </div>
        </x-dropdown-item>
        <x-dropdown-item href="/orders">
            <div class="flex items-center">
                <x-icon name="orders" class="inline mr-2" />
                <span>Orders</span>
            </div>
        </x-dropdown-item>
        <x-dropdown-item href="/settings">
            <div class="flex items-center">
                <x-icon name="settings" class="inline mr-2" />
                <span>Settings</span>
            </div>
        </x-dropdown-item>
        <x-dropdown-item href="/help">
            <div class="flex items-center">
                <x-icon name="help" class="inline mr-2" />
                <span>Help</span>
            </div>
        </x-dropdown-item>
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="block w-full text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focus:text-white">
                <div class="flex items-center">
                    <x-icon name="logout" class="inline mr-2" />
                    <span>Sign out</span>
                </div>
            </button>
        </form>
    </div>
</div>