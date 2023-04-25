@if (!request()->routeIs(['login', 'register', 'vendor.login', 'vendor.register']))
@php
    $categories = App\Models\Category::all();
    $cartItemsCount = App\Models\Cart::where('user_id', auth()->id())->count();
@endphp
@endif

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
    <title>{{ $title ?? 'YangonMart.com - Shop anytime, anywhere with us' }}</title>

    <!-- Dark Mode -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="antialiased bg-white dark:bg-gray-800">
    <section x-data="notification" class="relative">

        {{-- hamburger menu for small screen sizes --}}
        @if (!request()->routeIs(['login', 'register', 'vendor.*']))
        <div class="block absolute top-6 w-full px-2 z-30 sm:hidden">
            <div 
                x-data="{ open:false }" 
                class="relative"
                @@click.outside="open=false"
            >
                <button type="button" @@click="open=!open" class="absolute right-3">
                    <x-icon name="hamburger" x-show="!open" />
                    <x-icon name="close" x-show="open" />
                </button>
                <div x-show="open" class="absolute top-6 w-full rounded drop-shadow-xl bg-white" x-cloak x-transition>
                    @foreach ($categories->pluck('type')->unique() as $type)
                    <x-category-menu :categories="$categories" :type="$type" />
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Logos and navigation --}}
        <header class="container text-gray-700 dark:text-gray-300 mx-auto space-y-3 mb-4 px-3 py-1 lg:px-8">
            <nav class="flex flex-col justify-between items-center space-y-5 py-2 md:flex-row md:space-y-0">

                <div>
                    <a href="/"><img src="/images/logo/logo.svg" alt="" width="100" height="16"></a>
                </div>

                {{-- search --}}
                <div class="w-full order-last md:w-80 lg:w-96 xl:w-128 md:order-none">
                    <div class="relative border-2 border-gray-400 dark:border-none rounded-xl">
                        <form action="{{ route('home') }}" method="GET">
                            <div class="absolute top-2.5 left-3">
                                <button type="submit" class="text-slate-500 hover:text-slate-800">
                                    <x-icon name="search"/>
                                </button>
                            </div>
                            @if (request()->has('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <input type="text" name="search" class="w-full text-black dark:text-black bg-white dark:bg-slate-200 px-10 py-2 rounded-xl focus:ring-2 focus:outline-none focus:ring-gray-400 dark:focus:ring-blue-300" placeholder="Search everything you need" value="{{request('search') ?? ''}}">
                        </form>
                    </div>
                </div>

                {{-- dark, lang, cart, login --}}
                <div class="flex text-gray-700 dark:text-gray-300 items-center justify-center h-9 space-x-6 xl:space-x-8">
                    <div class="">
                        <button id="theme-toggle" type="button" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5">
                            <x-icon id="theme-toggle-dark-icon" class="hidden" name="day" />
                            <x-icon id="theme-toggle-light-icon" class="hidden" name="night" />
                        </button>
                    </div>
                    <div x-data="{ open: false }" class="relative">
                        <button @@click="open = !open" class="flex items-center lg:text-base hover:text-gray-600 dark:hover:text-gray-100">
                            EN
                            <x-icon name="chevron-right" class="inline pointer-events-none pl-1" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                        </button>
                        <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-16 mt-1 max-h-56 text-sm md:text-base overflow-auto border rounded z-10" x-cloak x-transition>
                            <a href="" class="block w-full text-sm leading-6 hover:bg-blue-500 hover:text-white pl-1">EN</a>
                            {{-- <a href="" class="block w-full text-sm leading-6 hover:bg-blue-500 hover:text-white pl-1">MM</a> --}}
                        </div>
                    </div>
                    <div class="relative">
                        <a href="{{ route('carts.index') }}" class="hover:text-blue-600 dark:hover:text-gray-100" id="cart">
                            <x-icon name="cart" />

                            {{-- notification --}}
                            @if (!request()->routeIs(['login', 'register', 'vendor.login', 'vendor.register']))
                            <div x-show="cartItemCounter" x-text="cartItemCounter" class="absolute -top-3.5 -right-3 inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-sky-400 border-2 border-white rounded-full md:-top-3 md:-right-3" x-cloak x-transition>
                            </div>
                            @endif
                        </a>
                    </div>
                    @auth
                    {{-- profile --}}
                    <x-profile-dropdown />
                    @else
                    <a href="/register" class="text-sm font-semibold hover:text-blue-600 dark:hover:text-gray-100 lg:text-base">Register</a>
                    <a href="/login" class="text-sm font-semibold hover:text-blue-600 dark:hover:text-gray-100 lg:text-base">Sign in</a>
                    @endauth
                </div>
            </nav>

            {{-- Navigation --}}
            @if (!request()->routeIs(['login', 'register', 'vendor.*']))
            <nav class="hidden container mx-auto flex-row justify-between items-center sm:flex">
                @foreach ($categories->pluck('type')->unique() as $type)
                <x-category-dropdown :categories="$categories" :type="$type" />
                @endforeach
            </nav>
            @endif
        </header>

        <main>
            {{$slot}}
        </main>

        <footer class="bg-neutral-800 dark:bg-slate-700 text-slate-300">
            <div class="container mx-auto flex flex-col px-8 py-6 md:px-12">
                <section class="flex justify-center items-center md:justify-between">
                    <div class="space-y-4 text-center md:text-left">
                        <div class="text-center md:text-left">
                            <p class="text-sm">We accept multiple payments</p>
                        </div>
                        <h2 class="text-xl font-bold lg:text-2xl">Start shopping with Yangon Mart today.</h2>
                        <a href="/register" class="block w-full bg-blue-600 p-2 rounded-xl text-center shadow-lg text-white hover:bg-blue-700">Sign up</a>
                    </div>

                    <div class="hidden mx-auto md:block">
                        <img src="/images/shopping_cart.png" alt="" width="240">
                    </div>
                </section>

                <section class="flex flex-col items-center space-y-10 md:m-0 md:flex-row md:justify-between md:items-end md:space-y-0">
                    <div class="w-full space-y-3 order-1 mt-8 text-center md:w-auto md:text-left md:order-first md:mt-0">
                        <div>
                            <img src="/images/logo/logo_w.svg" alt="" width="100" class="mx-auto md:mx-0">
                        </div>
                        <p class="italic tracking-wider font-semibold">Shop anytime, anywhere with us</p>
                        <div>
                            <div class="flex items-center justify-center space-x-2 md:justify-start">
                                <x-icon name="telephone" />
                                <a href="tel:+959771637812" class="hover:text-slate-400">+95 9 771 637 812</a>
                            </div>
                            <div class="flex items-center justify-center space-x-2 md:justify-start">
                                <x-icon name="mail" />
                                <a href="mailto:enquiry@ygnmart.com" class="hover:text-slate-400">enquiry@ygnmart.com</a>
                            </div>
                        </div>
                        <p class="text-sm">Copyright &copy; <time>2023</time> Yangon Mart</p>
                    </div>
                    <div class="flex w-full flex-col text-center md:w-auto md:text-left">
                        <h3 class="font-semibold mb-2">About</h3>
                        <a href="" class="hover:text-slate-400">Customer Service</a>
                        <a href="" class="hover:text-slate-400">Vendor Guidelines</a>
                    </div>
                    <div class="flex w-full flex-col text-center md:w-auto md:text-left">
                        <h3 class="font-semibold mb-2">Terms and Conditions</h3>
                        <a href="" class="hover:text-slate-400">Privacy Policy</a>
                        <a href="" class="hover:text-slate-400">Cookie Policy</a>
                    </div>
                    <div class="w-full text-center md:w-auto md:text-left">
                        <h3 class="font-semibold mb-2">Platforms</h3>
                        <div class="space-x-3 text-xl">
                            <a href="#" class="hover:text-slate-400"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="hover:text-slate-400"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="hover:text-slate-400"><i class="fa-brands fa-viber"></i></a>
                        </div>
                    </div>
                </section>
            </div>
        </footer>
    </section>

    <x-flash />
</body>
</html>

@if (!request()->routeIs(['login', 'register', 'vendor.login', 'vendor.register']))
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notification', () => ({
            cartItemCounter: {{ $cartItemsCount }},
            addToCart() {
                this.cartItemCounter = {{ $cartItemsCount }};
                console.log(this.cartItemCounter);
            }
        }))
    });
</script>
@endif

<script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {

        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

        // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }

    });
</script>