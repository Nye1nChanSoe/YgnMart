<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Dashboard - YangonMart.com' }}</title>
</head>
<body class="antialiased ">
    <section x-data="{ open: true }">
        {{-- sidebar --}}
        <aside x-show="open" class="fixed w-[270px] inset-0 z-40 bg-gray-100" x-transition:enter="transform ease-in-out duration-500" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="pl-8 pr-4 py-4">
                <div class="flex w-full items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 flex overflow-hidden rounded-full bg-white">
                            <img src="{{ asset('images/no-image.png') }}" alt="" class="object-contain">
                        </div>
                        <div class="flex flex-col text-gray-700">
                            <h1 class="font-medium"><a href="">Nyein Chan Soe</a></h1>
                            <span class="text-xs">@user_ncs</span>
                        </div>
                    </div>
                    <button x-on:click="open=false" x-show="open" class="hover:text-blue-700">
                        <x-icon name="hamburger" />
                    </button>
                </div>

                {{-- labels --}}
                <section class="mt-10 text-gray-700">
                    <div>
                        <h6 class="text-sm">Total Transactions</h6>
                        <div class="font-medium text-lg"><span>$</span>360,021</div>
                    </div>
                    <ul class="flex flex-col mt-10">
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 {{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.dashboard') }}"><div class="flex items-center"><x-icon name="chart" class="mr-2" />Dashboard</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 {{ request()->routeIs('vendor.products') ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.products') }}"><div class="flex items-center"><x-icon name="listings" class="mr-2" />Product Listing</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 {{ false ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.transactions') }}"><div class="flex items-center"><x-icon name="card" class="mr-2" />Transactions</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 {{ false ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.discounts') }}"><div class="flex items-center"><x-icon name="discount" class="mr-2" />Discounts</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 {{ false ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.settings') }}"><div class="flex items-center"><x-icon name="settings" class="mr-2" />Settings</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 {{ request()->routeIs('vendor.logout') ? 'text-blue-700' : '' }}">
                            <form action="/vendor/logout" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <div class="flex items-center"><x-icon name="logout" class="mr-2" />Logout</div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </section>
            </div>
        </aside>

        {{-- sidebar hidden --}}
        <aside x-show="!open" class="fixed w-14 inset-0 z-40 bg-gray-100" x-transition:enter="transform ease-in-out duration-500" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="px-2 py-4">
                <button x-on:click="open=true" x-show="!open" class="flex w-full justify-center hover:text-blue-700">
                    <x-icon name="hamburger" />
                </button>
                <div class="flex items-center justify-center mt-6">
                    <div class="h-7 w-7 flex overflow-hidden rounded-full bg-white">
                        <img src="{{ asset('images/no-image.png') }}" alt="" class="object-contain">
                    </div>
                </div>
                <ul class="flex flex-col items-center mt-10">
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.dashboard') }}"><div class="flex items-center"><x-icon name="chart" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.products') ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.products') }}"><div class="flex items-center"><x-icon name="listings" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ false ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.transactions') }}"><div class="flex items-center"><x-icon name="card" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ false ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.discounts') }}"><div class="flex items-center"><x-icon name="discount" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ false ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.settings') }}"><div class="flex items-center"><x-icon name="settings" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.logout') ? 'text-blue-700' : '' }}">
                        <form action="/vendor/logout" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <div class="flex items-center"><x-icon name="logout" /></div>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>
        
        {{-- dashboard --}}
        <div class="px-2 py-2 transition-all duration-500 ease-in-out" x-bind:class="{'ml-[270px]':open, 'ml-16':!open}">
            <nav class="flex justify-between px-3 py-3 rounded-lg shadow">
                <div>
                    <ul class="flex gap-x-5">
                        <li class="text-gray-700 hover:text-blue-600"><a href="{{ route('home') }}">Market Place</a></li>
                        <li class="text-gray-700 hover:text-blue-600"><a href="">Profile</a></li>
                        <li class="text-gray-700 hover:text-blue-600">Terms and Conditions</li>
                    </ul>
                </div>
                <div>
                    <form action="{{ route('vendor.logout') }}" method="POST">
                        <button type="submit" class="text-gray-700 hover:text-blue-600">
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
            <main>
                {{$slot}}
            </main>
        </div>
    </section>

    <x-flash />
</body>
</html>