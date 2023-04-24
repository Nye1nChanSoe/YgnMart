@php
    $user = auth()->user();
@endphp

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
<body class="antialiased" x-cloak>
    <section x-data="{ open: true }">
        {{-- sidebar --}}
        <aside x-show="open" class="fixed w-[270px] inset-0 z-40 bg-gray-900" x-transition:enter="transform ease-in-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="pl-8 pr-4 py-4">
                <div class="flex w-full items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 flex overflow-hidden rounded-full bg-white">
                            <img src="{{ asset('images/no-image.png') }}" alt="" class="object-contain">
                        </div>
                        <div class="flex flex-col text-gray-300">
                            <h1 class="font-medium"><a href="{{ route('admin.show', $user->username) }}" class="hover:text-blue-300">{{ $user->name }}</a></h1>
                            <span class="text-xs">@<span>{{ $user->username }}</span> </span>
                        </div>
                    </div>
                    <button x-on:click="open=false" x-show="open" class="text-gray-300 hover:text-blue-300">
                        <x-icon name="hamburger" />
                    </button>
                </div>

                {{-- labels --}}
                <section class="mt-10 text-gray-300">
                    <div>
                        {{-- <h6 class="text-sm">Total Transactions</h6> --}}
                        {{-- @php
                            $transactions = App\Models\Transaction::select('gross_amount')->where('admin_id', auth()->guard('admin')->id())->get();
                        @endphp
                        <div class="font-medium text-xl text-green-600">{{ number_format($transactions->reduce(fn($total, $value) => $total += $value->gross_amount), 0, '.', ',') }}<span class="ml-1 text-gray-300 text-sm font-normal">Kyat</span></div> --}}
                    </div>
                    <ul class="flex flex-col mt-10">
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('admin.dashboard') ? 'text-blue-300' : '' }}">
                            <a href="{{ route('admin.dashboard') }}"><div class="flex items-center"><x-icon name="chart" class="mr-2" />Dashboard</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs(['admin.customers', 'admin.customers.*']) ? 'text-blue-300' : '' }}">
                            <a href="{{ route('admin.customers') }}"><div class="flex items-center"><x-icon name="customer" class="mr-2" />Customers</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('admin.vendors') ? 'text-blue-300' : '' }}">
                            <a href="{{ route('admin.vendors') }}"><div class="flex items-center"><x-icon name="shop" class="mr-2" />Vendors</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('admin.categories') ? 'text-blue-300' : '' }}">
                            <a href="{{ route('admin.categories') }}"><div class="flex items-center"><x-icon name="tag" class="mr-2" />Categories</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('admin.settings') ? 'text-blue-300' : '' }}">
                            <a href="{{ route('admin.settings', $user->username) }}"><div class="flex items-center"><x-icon name="settings" class="mr-2" />Settings</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('logout') ? 'text-blue-300' : '' }}">
                            <form action="/admin/logout" method="POST">
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
        <aside x-show="!open" class="fixed w-14 inset-0 z-40 bg-gray-900" x-transition:enter="transform ease-in-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="px-2 py-4 text-gray-300">
                <button x-on:click="open=true" x-show="!open" class="flex w-full justify-center hover:text-blue-300">
                    <x-icon name="hamburger" />
                </button>
                <div class="flex items-center justify-center mt-6">
                    <div class="h-7 w-7 flex overflow-hidden rounded-full bg-white">
                        <img src="{{ asset('images/no-image.png') }}" alt="" class="object-contain">
                    </div>
                </div>
                <ul class="flex flex-col items-center mt-10">
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('admin.dashboard') ? 'text-blue-300' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><div class="flex items-center"><x-icon name="chart" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs(['admin.customers', 'admin.custmers.*']) ? 'text-blue-300' : '' }}">
                        <a href="{{ route('admin.customers') }}"><div class="flex items-center"><x-icon name="customer" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('admin.vendors') ? 'text-blue-300' : '' }}">
                        <a href="{{ route('admin.vendors') }}"><div class="flex items-center"><x-icon name="shop" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('admin.categories') ? 'text-blue-300' : '' }}">
                        <a href="{{ route('admin.categories') }}"><div class="flex items-center"><x-icon name="tag" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('admin.settings') ? 'text-blue-300' : '' }}">
                        <a href="{{ route('admin.settings', $user->username) }}"><div class="flex items-center"><x-icon name="settings" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('logout') ? 'text-blue-300' : '' }}">
                        <form action="/admin/logout" method="POST">
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
        <div class="px-2 py-2 bg-slate-600 h-screen transition-all duration-300 ease-in-out" x-bind:class="{'ml-[270px]':open, 'ml-14':!open}">
            <nav class="flex justify-between items-center px-3 py-3 h-16 rounded-lg shadow bg-gray-900">
                <div>
                    <ul class="flex gap-x-5">
                        <li class="text-gray-300 hover:text-blue-300"><a href="{{ route('home') }}" target="_blank">Market Place</a></li>
                        <li class="text-gray-300 hover:text-blue-300"><a href="{{ route('admin.show', $user->username) }}">Profile</a></li>
                        <li class="text-gray-300 hover:text-blue-300">Terms and Conditions</li>
                    </ul>
                </div>
                <div class="flex items-center gap-x-4">
                    @php
                        $resultURL = '';
                        if(request()->routeIs('admin.customers')) {
                            $resultURL = route('admin.customers');
                        } elseif (request()->routeIs('admin.vendors')) {
                            $resultURL = route('admin.vendors');
                        } elseif (request()->routeIs('admin.categories')) {
                            $resultURL = route('admin.categories');
                        } else {
                            $resultURL = route('admin.customers');
                        }
                    @endphp
                    @if (!request()->routeIs(['admin.show', 'admin.settings', 'admin.dashboard']))
                    <form action="{{ $resultURL }}" method="GET" class="relative">
                        <div class="absolute top-2 left-3">
                            <button type="submit" class="text-gray-300 hover:text-black">
                                <x-icon name="search" class="text-gray-600"/>
                            </button>
                        </div>
                        <input type="text" name="search" value="{{ request('search') ?? '' }}" class="w-full border-2 text-black bg-slate-200 border-gray-300 pl-10 pr-2.5 py-1 rounded-lg focus:border-gray-100 focus:outline-none" placeholder="Search for products">
                    </form>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-x-1 text-gray-300 hover:text-blue-300">
                            <x-icon name="power" />
                            <span>Logout</span>
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

<script>
    /* Hide the content until AlpineJS is fully loaded */
    document.addEventListener('alpine:init', () => {
        document.querySelector('body').removeAttribute('x-cloak');
    });
</script>