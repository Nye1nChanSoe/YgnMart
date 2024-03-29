@php
    $user = auth()->guard('vendor')->user();
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
        <aside x-show="open" class="fixed w-[270px] inset-0 z-40 bg-gray-100" x-transition:enter="transform ease-in-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="pl-8 pr-4 py-4">
                <div class="flex w-full items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-8 h-8 overflow-hidden rounded-full bg-white">
                            @if ($user->image)
                            <img src="{{ asset('storage/images/'.$user->image) }}" alt="" class="w-full h-full object-cover shrink-0 rounded-full">
                            @else
                            <img src="https://placehold.co/32/png" alt="" class="w-full h-full object-cover rounded-full">
                            @endif
                        </div>
                        <div class="flex flex-col text-gray-700">
                            <h1 class="font-medium"><a href="{{ route('vendor.show', $user->username) }}" class="hover:text-blue-700">{{ $user->brand }}</a></h1>
                            <span class="text-xs">@<span>{{ $user->username }}</span> </span>
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
                        @php
                            $transactions = App\Models\Transaction::select('gross_amount')->where('vendor_id', auth()->guard('vendor')->id())->get();
                        @endphp
                        <div class="font-medium text-xl text-green-600">{{ number_format($transactions->reduce(fn($total, $value) => $total += $value->gross_amount) ?? 0, 0, '.', ',') }}<span class="ml-1 text-gray-500 text-sm font-normal">Kyat</span></div>
                    </div>
                    <ul class="flex flex-col mt-10">
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.dashboard') }}"><div class="flex items-center"><x-icon name="chart" class="mr-2" />Dashboard</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs(['vendor.products', 'vendor.products.*', 'vendor.inventories']) ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.products') }}"><div class="flex items-center"><x-icon name="listings" class="mr-2" />Product Listing</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('vendor.transactions') ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.transactions') }}"><div class="flex items-center"><x-icon name="card" class="mr-2" />Transactions</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('vendor.orders') ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.orders') }}"><div class="flex items-center"><x-icon name="orders" class="mr-2" />Orders</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('vendor.settings') ? 'text-blue-700' : '' }}">
                            <a href="{{ route('vendor.settings', $user->username) }}"><div class="flex items-center"><x-icon name="settings" class="mr-2" />Settings</div></a>
                        </li>
                        <li class="py-2.5 w-fit transition-all duration-300 hover:translate-x-3 hover:text-green-600 {{ request()->routeIs('vendor.logout') ? 'text-blue-700' : '' }}">
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
        <aside x-show="!open" class="fixed w-14 inset-0 z-40 bg-gray-100" x-transition:enter="transform ease-in-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="px-2 py-4">
                <button x-on:click="open=true" x-show="!open" class="flex w-full justify-center hover:text-blue-700">
                    <x-icon name="hamburger" />
                </button>
                <div class="flex items-center justify-center mt-6">
                    <div class="flex items-center justify-center w-7 h-7 overflow-hidden rounded-full bg-white">
                        @if ($user->image)
                        <img src="{{ asset('storage/images/'.$user->image) }}" alt="" class="w-full h-full object-cover shrink-0 rounded-full">
                        @else
                        <img src="https://placehold.co/32/png" alt="" class="w-full h-full object-cover rounded-full">
                        @endif
                    </div>
                </div>
                <ul class="flex flex-col items-center mt-10">
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.dashboard') ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.dashboard') }}"><div class="flex items-center"><x-icon name="chart" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs(['vendor.products', 'vendor.products.*', 'vendor.inventories']) ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.products') }}"><div class="flex items-center"><x-icon name="listings" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.transactions') ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.transactions') }}"><div class="flex items-center"><x-icon name="card" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.orders') ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.orders') }}"><div class="flex items-center"><x-icon name="orders" /></div></a>
                    </li>
                    <li class="py-2.5 w-fit transition-all duration-300 hover:text-green-600 {{ request()->routeIs('vendor.settings') ? 'text-blue-700' : '' }}">
                        <a href="{{ route('vendor.settings', $user->username) }}"><div class="flex items-center"><x-icon name="settings" /></div></a>
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
        <div class="px-2 py-2 transition-all duration-300 ease-in-out" x-bind:class="{'ml-[270px]':open, 'ml-16':!open}">
            <nav class="flex justify-between items-center px-3 py-3 h-16 rounded-lg shadow">
                <div>
                    <ul class="flex gap-x-5">
                        <li class="text-gray-700 hover:text-blue-600"><a href="{{ route('home') }}" target="_blank">Market Place</a></li>
                        <li class="text-gray-700 hover:text-blue-600"><a href="{{ route('vendor.show', $user->username) }}">Profile</a></li>
                        <li class="text-gray-700 hover:text-blue-600">Terms and Conditions</li>
                    </ul>
                </div>
                <div class="flex items-center gap-x-4">
                    @php
                        $resultURL = '';
                        if(request()->routeIs('vendor.products')) {
                            $resultURL = route('vendor.products');
                        } elseif (request()->routeIs('vendor.inventories')) {
                            $resultURL = route('vendor.inventories');
                        } elseif (request()->routeIs('vendor.transactions')) {
                            $resultURL = route('vendor.transactions');
                        } elseif (request()->routeIs('vendor.orders')) {
                            $resultURL = route('vendor.orders');
                        } else {
                            $resultURL = route('vendor.products');
                        }
                    @endphp
                    @if (!request()->routeIs(['vendor.show', 'vendor.settings', 'vendor.dashboard']))
                    <form action="{{ $resultURL }}" method="GET" class="relative">
                        <div class="absolute top-2 left-3">
                            <button type="submit" class="text-gray-700 hover:text-black">
                                <x-icon name="search" class="text-gray-700"/>
                            </button>
                        </div>
                        <input type="text" name="search" value="{{ request('search') ?? '' }}" class="w-full border-2 border-gray-400 pl-10 pr-2.5 py-1 rounded-lg focus:border-gray-600 focus:outline-none" placeholder="Search for products">
                    </form>
                    @endif
                    <form action="{{ route('vendor.logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-x-1 text-gray-700 hover:text-blue-600">
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