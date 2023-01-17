<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/css/app.css')
    <title>Home Page</title>
</head>
<body>
    <section>
        <header class="space-y-3 mb-10">
            <div class="flex justify-between items-center px-8 py-4">
                <figure>
                    {{-- temporary logo might change later --}}
                    <a href="/"><img src="/images/logos/main_logo.svg" alt="" width="100" height=""></a>
                </figure>
                {{-- search --}}
                <div class="flex-grow px-36 3xl:px-96">
                    <div class="relative border border-gray-400 rounded-xl">
                        <div class="absolute top-2.5 left-3">
                            <button type="submit">
                                <i class="fa fa-search text-gray-500 z-20 hover:text-gray-700"></i>
                            </button>
                        </div>
                        <input type="text" name="search" class="w-full pl-10 pr-20 py-2 rounded-xl focus:ring-1 focus:ring-gray-800 focus:outline-none" placeholder="Search everything you need">
                    </div>
                </div>
                <div class="flex items-center space-x-8">
                    <div>
                        <select name="lang_preference" id="">
                            <option value="en">EN</option>
                            <option value="mm">MM</option>
                        </select>
                    </div>
                    <a href="" class="hover:text-blue-600" id="cart"><i class="fas fa-shopping-cart"></i></a>
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
            <figure class="h-96 bg-slate-100 flex items-center justify-center mb-20">
                <img src="/images/logos/main_logo.svg" alt="" width="500">
            </figure>
        </section>
        
        <main>
            <div>

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
                            <a href="/"><img src="/images/logos/main_logo.svg" alt="" width="100"></a>
                        </figure>
                        <p class="italic tracking-wider font-semibold">Shop anytime, anywhere with us</p>
                        <div>
                            <div>
                                <i class="fa-solid fa-comment-dots"></i>
                                <a href="tel:+959771637812" class="hover:text-black">+95 9 771 637 812</a>
                            </div>
                            <div>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <a href="mailto:enquiry@ygnmart.com" class="hover:text-black">enquiry@ygnmart.com</a>
                            </div>
                        </div>
                        <p class="text-sm">Copyright &copy; 2023 Yangon Mart</p>
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