<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home Page</title>
</head>
<body>
    <section x-data="notification">

        {{-- Logos and navigation --}}
        <header class="container mx-auto space-y-4 mb-6 px-3 py-1 lg:px-8">
            <div class="flex flex-col justify-between items-center space-y-5 py-2 md:flex-row md:space-y-0">

                <div>
                    <a href="/"><img src="/images/logo/logo.svg" alt="" width="100" height="16"></a>
                </div>

                {{-- search --}}
                <div class="w-full order-last md:w-80 lg:w-128 md:order-none">
                    <div class="relative border border-gray-400 rounded-xl">
                        <form action="" method="GET">
                            <div class="absolute top-2.5 left-3">
                                <button type="submit" class="text-slate-500 hover:text-slate-800">
                                    <x-icon name="search"/>
                                </button>
                            </div>
                            <input type="text" name="search" class="w-full px-10 py-2 rounded-xl focus:ring-1 focus:ring-gray-800 focus:outline-none" placeholder="Search everything you need">
                        </form>
                    </div>
                </div>

                {{-- lang, cart, login --}}
                <div class="flex items-center h-9 space-x-6 xl:space-x-8">
                    <div x-data="{ open: false }" class="relative">
                        <button @@click="open = !open" class="flex items-center text-sm lg:text-base hover:text-gray-600">
                            EN
                            <x-icon name="chevron-right" class="inline pointer-events-none pl-1" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" />
                        </button>
                        <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-16 mt-1 max-h-56 text-sm md:text-base overflow-auto border rounded z-10" x-cloak x-transition>
                            <a href="" class="block w-full text-sm leading-6 hover:bg-blue-500 hover:text-white pl-1">EN</a>
                            <a href="" class="block w-full text-sm leading-6 hover:bg-blue-500 hover:text-white pl-1">MM</a>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="{{ route('carts.index') }}" class="hover:text-blue-600" id="cart">
                            <x-icon name="cart" />

                            {{-- notification --}}
                            <div x-show="cartItemCounter" x-text="cartItemCounter" class="absolute -top-3.5 -right-3 inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-sky-400 border-2 border-white rounded-full md:-top-3 md:-right-3" x-cloak x-transition>
                            </div>
                        </a>
                    </div>
                    @auth
                    {{-- profile --}}
                    <x-profile-dropdown />
                    @else
                    <a href="/register" class="text-sm font-semibold hover:text-blue-600 lg:text-base">Register</a>
                    <a href="/login" class="text-sm font-semibold hover:text-blue-600 lg:text-base">Sign in</a>
                    @endauth
                </div>
            </div>

            {{-- TODO: sidebar accordion or hamburger menu in small screens --}}
            <nav class="container mx-auto flex items-start flex-col justify-between md:flex-row md:items-center">
                @foreach (App\Models\CategoryType::all() as $categoryType)
                <x-category-dropdown
                    type="{{$categoryType->type}}"
                    :id="$categoryType->id"
                />
                @endforeach
            </nav>
        </header>

        {{$slot}}

        <footer class="bg-slate-100">
            <div class="container mx-auto flex flex-col px-8 py-6 text-slate-600 md:px-12">
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
                            <img src="/images/logo/logo.svg" alt="" width="100" class="mx-auto md:mx-0">
                        </div>
                        <p class="italic tracking-wider font-semibold">Shop anytime, anywhere with us</p>
                        <div>
                            <div class="flex items-center justify-center space-x-2 md:justify-start">
                                <x-icon name="telephone" />
                                <a href="tel:+959771637812" class="hover:text-black">+95 9 771 637 812</a>
                            </div>
                            <div class="flex items-center justify-center space-x-2 md:justify-start">
                                <x-icon name="mail" />
                                <a href="mailto:enquiry@ygnmart.com" class="hover:text-black">enquiry@ygnmart.com</a>
                            </div>
                        </div>
                        <p class="text-sm">Copyright &copy; <time>2023</time> Yangon Mart</p>
                    </div>
                    <div class="flex w-full flex-col text-center md:w-auto md:text-left">
                        <h3 class="font-semibold mb-2">About</h3>
                        <a href="" class="hover:text-black">Customer Service</a>
                        <a href="" class="hover:text-black">Vendor Guidelines</a>
                    </div>
                    <div class="flex w-full flex-col text-center md:w-auto md:text-left">
                        <h3 class="font-semibold mb-2">Terms and Conditions</h3>
                        <a href="" class="hover:text-black">Privacy Policy</a>
                        <a href="" class="hover:text-black">Cookie Policy</a>
                    </div>
                    <div class="w-full text-center md:w-auto md:text-left">
                        <h3 class="font-semibold mb-2">Platforms</h3>
                        <div class="space-x-3 text-xl">
                            <a href="#" class="hover:text-black"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="hover:text-black"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="hover:text-black"><i class="fa-brands fa-viber"></i></a>
                        </div>
                    </div>
                </section>
            </div>
        </footer>
    </section>

    <x-flash />
</body>
</html>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notification', () => ({
            cartItemCounter: {{ App\Models\Cart::where('user_id', auth()->id())->count() }},
            addToCart() {
                this.cartItemCounter = {{ App\Models\Cart::where('user_id', auth()->id())->count() }};
                console.log(this.counter);
            }
        }))
    });
</script>