<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home Page</title>
</head>
<body>
    <section>
        <header class="space-y-3 mb-10">
            <div class="flex justify-between items-center px-8 py-4">
                <figure>
                    {{-- temporary logo might change later --}}
                    <a href="/"><img src="/images/logo/main_logo.svg" alt="" width="100" height=""></a>
                </figure>
                {{-- search --}}
                <div class="flex-grow px-36 3xl:px-96">
                    <div class="relative border border-gray-400 rounded-xl">
                        <form action="" method="GET">
                            <div class="absolute top-2.5 left-3">
                                <button type="submit" class="text-slate-500 hover:text-slate-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <input type="text" name="search" class="w-full pl-10 pr-20 py-2 rounded-xl focus:ring-1 focus:ring-gray-800 focus:outline-none" placeholder="Search everything you need">
                        </form>
                    </div>
                </div>
                <div class="flex items-center space-x-8">
                    <div>
                        <select name="lang_preference" id="">
                            <option value="en">EN</option>
                            <option value="mm">MM</option>
                        </select>
                    </div>
                    <a href="" class="hover:text-blue-600" id="cart">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </a>
                    <a href="" class="text-lg hover:text-blue-600">Login</a>
                </div>
            </div>

            <nav class="container mx-auto flex items-center justify-between mb-10 px-4">
                <div class="relative bg-slate-100 rounded-xl">
                    {{-- hard coded width w-32 --}}
                    <button class="bg-transparent py-2 px-3 text-left text-sm font-semibold w-full lg:w-32">
                        Category
                        {{-- svgs are block by default in tailwind --}}
                        <svg class="inline transform -rotate-90 absolute pointer-events-none right-2" width="22" height="22" viewBox="0 0 22 22">
                            <g fill="none" fill-rule="evenodd">
                                <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z"></path>
                                <path fill="#222" d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>
                            </g>
                        </svg>
                    </button> 
                    {{--TODO: toggle visibility with js --}}
                    {{-- position absolute so it won't distrub the page flow --}}
                    <div class="hidden absolute py-2 bg-gray-50 w-full mt-1 max-h-52 overflow-auto rounded-xl z-50">
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Foods</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Foods</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Foods</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Foods</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Foods</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Foods</a>
                    </div>
                </div>
            </nav>
        </header>

        {{-- TODO: set timer with js --}}
        {{-- hero / carousel --}}
        <section>
            <figure class="h-96 bg-slate-100 flex items-center justify-center">
                <img src="/images/logo/main_logo.svg" alt="" width="500">
            </figure>
        </section>
        
        <main>
            <div class="container mx-auto p-10">


                <div class="grid grid-cols-3 gap-x-5">
                    {{-- card --}}
                    <div class="flex flex-col justify-between transition-color duration-200 p-6 shadow-md space-y-3 hover:shadow-2xl">
                        <figure class="self-center h-52">
                            <img src="/images/grocery/watermelon_grocery.jpeg" alt="" width="" style="max-width: 100%; max-height:100%">
                        </figure>

                        {{-- card body --}}
                        <div class="space-y-3 mt-2">
                            {{-- name --}}
                            <h3 class="text-center font-semibold"><a href="">Watermelon</a></h3>
                            <div class="flex flex-col items-center space-y-3">
                                {{-- categories --}}
                                <ul class="flex flex-wrap space-x-2">
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">fruit</a></li>
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">organic</a></li>
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">local</a></li>
                                </ul>
                                {{-- ratings --}}
                                <div>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-slate-200"></i>
                                    <i class="fa-solid fa-star text-slate-200"></i>
                                </div>
                            </div>
                            {{-- price and vendor --}}
                            <div class="flex items-center justify-between border-t py-2">
                                <div>
                                    <h5 class="px-2 py-px my-2 w-24 bg-yellow-300 text-black font-semibold rounded-xl text-center">1.99$</h5>
                                    <span class="text-sm text-slate-700">By Organic Myanmar</span>
                                </div>
                                {{-- purchase quantity --}}
                                <div class="flex items-center text-center border border-slate-400 divide-x divide-slate-400">
                                    <div class="text-2xl w-10">-</div>
                                    <div class="w-10">1</div>
                                    <div class="w-10 text-xl">+</div>
                                </div>
                            </div>
                            <div>
                                <form action="" method="POST">
                                    {{-- bg-blue-600 hover:bg-blue-700 --}}
                                    <button class="w-full text-center bg-lime-500 py-1.5 rounded-lg text-white shadow-md hover:bg-lime-600">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-between transition-color duration-200 p-6 shadow-md space-y-3 hover:shadow-2xl">
                        <figure class="self-center h-52">
                            <img src="/images/grocery/tangerine_grocery.jpeg" alt="" width="" style="max-width: 100%; max-height:100%">
                        </figure>

                        {{-- card body --}}
                        <div class="space-y-3 mt-2">
                            {{-- name --}}
                            <h3 class="text-center font-semibold"><a href="">Tangerine</a></h3>
                            <div class="flex flex-col items-center space-y-3">
                                {{-- categories --}}
                                <ul class="flex flex-wrap space-x-2">
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">fruit</a></li>
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">organic</a></li>
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">local</a></li>
                                </ul>
                                {{-- ratings --}}
                                <div>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-slate-200"></i>
                                    <i class="fa-solid fa-star text-slate-200"></i>
                                </div>
                            </div>
                            {{-- price and vendor --}}
                            <div class="flex items-center justify-between border-t py-2">
                                <div>
                                    <h5 class="px-2 py-px my-2 w-24 bg-yellow-300 text-black font-semibold rounded-xl text-center">1.99$</h5>
                                    <span class="text-sm text-slate-700">By Organic Myanmar</span>
                                </div>
                                {{-- purchase quantity --}}
                                <div class="flex items-center text-center border border-slate-400 divide-x divide-slate-400">
                                    <div class="text-2xl w-10">-</div>
                                    <div class="w-10">1</div>
                                    <div class="w-10 text-xl">+</div>
                                </div>
                            </div>
                            <div>
                                <form action="" method="POST">
                                    {{-- bg-blue-600 hover:bg-blue-700 --}}
                                    <button class="w-full text-center bg-lime-500 py-1.5 rounded-lg text-white shadow-md hover:bg-lime-600">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-between transition-color duration-200 p-6 shadow-md space-y-3 hover:shadow-2xl">
                        <figure class="self-center h-52">
                            <img src="/images/grocery/chicken_eggs_grocery.jpeg" alt="" width="" class="" style="max-width:100%;
                            max-height:100%;">
                        </figure>

                        {{-- card body --}}
                        <div class="space-y-3 mt-2">
                            {{-- name --}}
                            <h3 class="text-center font-semibold"><a href="">Chicken Eggs</a></h3>
                            <div class="flex flex-col items-center space-y-3">
                                {{-- categories --}}
                                <ul class="flex flex-wrap space-x-2">
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">meat</a></li>
                                    <li class="px-2 py-1 bg-sky-100 rounded-xl text-black text-sm"><a href="">egg</a></li>
                                </ul>
                                {{-- ratings --}}
                                <div>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <i class="fa-solid fa-star text-slate-200"></i>
                                </div>
                            </div>
                            {{-- price and vendor --}}
                            <div class="flex items-center justify-between border-t py-2">
                                <div>
                                    <h5 class="px-2 py-px my-2 w-24 bg-yellow-300 text-black font-semibold rounded-xl text-center">1.99$</h5>
                                    <span class="text-sm text-slate-700">By Organic Myanmar</span>
                                </div>
                                {{-- purchase quantity --}}
                                <div class="flex items-center text-center border border-slate-400 divide-x divide-slate-400">
                                    <div class="text-2xl w-10">-</div>
                                    <div class="w-10">1</div>
                                    <div class="w-10 text-xl">+</div>
                                </div>
                            </div>
                            <div>
                                <form action="" method="POST">
                                    {{-- bg-blue-600 hover:bg-blue-700 --}}
                                    <button class="w-full text-center bg-lime-500 py-1.5 rounded-lg text-white shadow-md hover:bg-lime-600">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </main>

        

        <footer class="bg-slate-100">
            <div class="container mx-auto flex flex-col text-slate-600 p-10">
                <section class="flex justify-between items-center mb-4">
                    <div class="space-y-5">
                            <p class="text-sm">We accept multiple payments</p>
                            <h2 class="text-xl font-bold">Start shopping with Yangon Mart today.</h2>
                        <a href="" class="block w-full bg-blue-600 p-2 rounded-xl text-center shadow-lg text-white hover:bg-blue-700">Sign up</a>
                    </div>
                    
                    <figure class="mx-auto">
                        <img src="/images/shopping_cart.png" alt="" width="240">
                    </figure>
                </section>

                <section class="flex justify-between items-end">
                    <div class="space-y-3">
                        <figure>
                            <a href="/"><img src="/images/logo/main_logo.svg" alt="" width="100"></a>
                        </figure>
                        <p class="italic tracking-wider font-semibold">Shop anytime, anywhere with us</p>
                        <div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-5">
                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                </svg>
                                <a href="tel:+959771637812" class="hover:text-black">+95 9 771 637 812</a>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-5">
                                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                </svg>
                                <a href="mailto:enquiry@ygnmart.com" class="hover:text-black">enquiry@ygnmart.com</a>
                            </div>
                        </div>
                        <p class="text-sm">Copyright &copy; <time>2023</time> Yangon Mart</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-semibold mb-2">About</h3>
                        <a href="" class="hover:text-black">Customer Service</a>
                        <a href="" class="hover:text-black">Vendor Guidelines</a>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-semibold mb-2">Terms and Conditions</h3>
                        <a href="" class="hover:text-black">Privacy Policy</a>
                        <a href="" class="hover:text-black">Cookie Policy</a>
                    </div>
                    <div>
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
</body>
</html>