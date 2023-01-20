<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home Page</title>

    {{-- TODO: add this to the compiled css file in public dir --}}
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

</head>
<body>
    {{-- wrapper for the whole page --}}
    <section>

        {{-- Logos and navigation --}}
        <header class="container mx-auto space-y-4 mb-6">
            <div class="flex flex-col justify-between items-center space-y-5 px-4 py-2 md:flex-row md:space-y-0">

                <div>
                    <a href="/"><img src="/images/logo/logo.svg" alt="" width="100" height="16"></a>
                </div>

                {{-- search --}}
                <div class="w-full order-last md:w-80 lg:w-128 md:order-none">
                    <div class="relative border border-gray-400 rounded-xl">
                        <form action="" method="GET">
                            <div class="absolute top-2.5 left-3">
                                <button type="submit" class="text-slate-500 hover:text-slate-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <input type="text" name="search" class="w-full px-10 py-2 rounded-xl focus:ring-1 focus:ring-gray-800 focus:outline-none" placeholder="Search everything you need">
                        </form>
                    </div>
                </div>

                {{-- lang, cart, login --}}
                <div class="flex items-center space-x-8">
                    <div x-data="{ open: false }" class="relative">
                        <button @@click="open = !open" class="flex items-center">
                            EN
                            <svg class="pl-1 w-5 h-5 inline pointer-events-none right-2" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                        <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-16 mt-1 max-h-56 overflow-auto border z-10" x-cloak x-transition>
                            <a href="" class="block w-full text-sm leading-6 hover:bg-blue-500 hover:text-white pl-1">EN</a>
                            <a href="" class="block w-full text-sm leading-6 hover:bg-blue-500 hover:text-white pl-1">MM</a>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="" class="hover:text-blue-600" id="cart">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>

                            {{-- notification --}}
                            <span class="absolute -bottom-1 -right-2 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-300 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-300 text-xs"></span>
                            </span>
                        </a>
                    </div>
                    <a href="" class="text-lg hover:text-blue-600">Login</a>
                </div>
            </div>

            {{-- TODO: sidebar accordion or hamburger menu in small screens --}}
            <nav class="container mx-auto flex items-start flex-col justify-between px-4 md:flex-row md:items-center">

                {{-- Alpine component drop down --}}
                <div x-data="{ open:false }" class="relative">
                    {{-- hard coded width w-32 --}}
                    <button @@click="open=!open" class="hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
                        Foods
                        <svg class="w-4 h-5 inline absolute pointer-events-none right-6 lg:right-12" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button> 

                    {{-- hidden drop down menu --}}
                    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl z-10" x-cloak x-transition>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fish</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Vegetables</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Meat</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Snacks</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Seafood</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Pantry staples</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Bakery</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fruits</a>
                    </div>
                </div>
                <div x-data="{ open:false }" class="relative">
                    {{-- hard coded width w-32 --}}
                    <button @@click="open=!open" class="hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
                        Foods
                        <svg class="w-4 h-5 inline absolute pointer-events-none right-6 lg:right-12" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button> 

                    {{-- hidden drop down menu --}}
                    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl z-10" x-cloak x-transition>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fish</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Vegetables</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Meat</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Snacks</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Seafood</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Pantry staples</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Bakery</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fruits</a>
                    </div>
                </div>
                <div x-data="{ open:false }" class="relative">
                    {{-- hard coded width w-32 --}}
                    <button @@click="open=!open" class="hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
                        Foods
                        <svg class="w-4 h-5 inline absolute pointer-events-none right-6 lg:right-12" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button> 

                    {{-- hidden drop down menu --}}
                    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl z-10" x-cloak x-transition>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fish</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Vegetables</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Meat</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Snacks</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Seafood</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Pantry staples</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Bakery</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fruits</a>
                    </div>
                </div>
                <div x-data="{ open:false }" class="relative">
                    {{-- hard coded width w-32 --}}
                    <button @@click="open=!open" class="hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
                        Foods
                        <svg class="w-4 h-5 inline absolute pointer-events-none right-6 lg:right-12" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button> 

                    {{-- hidden drop down menu --}}
                    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl z-10" x-cloak x-transition>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fish</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Vegetables</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Meat</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Snacks</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Seafood</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Pantry staples</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Bakery</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fruits</a>
                    </div>
                </div>
                <div x-data="{ open:false }" class="relative">
                    {{-- hard coded width w-32 --}}
                    <button @@click="open=!open" class="hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
                        Foods
                        <svg class="w-4 h-5 inline absolute pointer-events-none right-6 lg:right-12" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button> 

                    {{-- hidden drop down menu --}}
                    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl z-10" x-cloak x-transition>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fish</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Vegetables</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Meat</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Snacks</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Seafood</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Pantry staples</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Bakery</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fruits</a>
                    </div>
                </div>
                <div x-data="{ open:false }" class="relative">
                    {{-- hard coded width w-32 --}}
                    <button @@click="open=!open" class="hover:bg-slate-200 py-2 px-3 text-left text-sm font-semibold w-24 rounded-xl lg:bg-slate-50 lg:w-32" x-bind:class="{ 'bg-slate-200': open }">
                        Foods
                        <svg class="w-4 h-5 inline absolute pointer-events-none right-6 lg:right-12" x-bind:class="{ 'rotate-90 transition-all duration-400':open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button> 

                    {{-- hidden drop down menu --}}
                    <div x-show="open" @@click.outside="open = false" class="absolute py-2 bg-white shadow-lg w-full mt-1 max-h-56 overflow-auto scrollbar rounded-xl z-10" x-cloak x-transition>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fish</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Vegetables</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Meat</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Snacks</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Seafood</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Pantry staples</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Bakery</a>
                        <a href="" class="block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focuse:text-white">Fruits</a>
                    </div>
                </div>
            </nav>
        </header>

        {{-- hero / carousel --}}
        <section>
            <div x-data="{
                    images: ['Promo 1', 'Promo 2', 'Event 1', 'Event 2'],
                    activeImage: null,
        
                    prev() 
                    {
                        let index = this.images.indexOf(this.activeImage);
                        if(index === 0) 
                        {
                            index = this.images.length;
                        }
                        this.activeImage = this.images[index - 1];
                    },
                    next() 
                    {
                        let index = this.images.indexOf(this.activeImage);
                        if(index == this.images.length - 1) 
                        {
                            index = -1;
                        }
                        this.activeImage = this.images[index + 1];
                    },
                    selectItem(item)
                    {
                        this.activeImage = item
                    },
                    init() 
                    {
                        this.activeImage = this.images.length > 0 ? this.images[0] : null
                        var self = this;
                        setInterval(function(){
                            self.next();
                        }, 5000);
                    },
                }" 
                class="relative h-96 bg-slate-100 mb-10"
            >
                <template x-for="image in images">
                    {{-- TODO: add carousel images that are wide enough --}}
                    <div x-show="activeImage === image" class="flex h-full items-center justify-center">
                        {{-- <img x-bind:src="image" alt="" style="width: 100%; height:100%; object-fit:fit"> --}}
                        <p x-text=image class="text-6xl font-bold tracking-widest"></p>
                    </div>
                </template>

                {{-- carousel navigations --}}
                <div>
                    <a href="#" @@click.prevent="prev" class="absolute text-gray-600 cursor-pointer hover:text-gray-900 left-0 top-1/2 -translate-y-1/2 md:left-4">
                        <svg class="h-6 w-6 md:h-10 md:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                    <a href="#" @@click.prevent="next" class="absolute text-gray-600 cursor-pointer hover:text-gray-900 right-0 top-1/2 -translate-y-1/2 md:right-4">
                        <svg class="h-6 w-6 md:h-10 md:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                {{-- carousel indicators --}}
                <div class="absolute flex justify-center left-1/2 bottom-4 -translate-x-1/2 space-x-1 z-10">
                    <template x-for="image in images">
                        <button 
                            class="bg-slate-300 py-[3px] px-2.5 rounded-2xl"
                            x-bind:class="{'bg-slate-600': activeImage === image}"
                            x-on:click = "selectItem(image)"
                        >
                        </button>
                    </template>
                </div>
            </div>
        </section>

        {{-- TODO: divide sections and display related products for each section --}}
        <main>
            <div class="container mx-auto grid grid-cols-2 gap-x-1 gap-y-2 px-2 md:grid-cols-3 lg:grid-cols-4 xl:gird-cols-6 mb-10">

                {{-- card --}}
                <div class="flex flex-col px-3 py-1 border border-gray-300 space-y-3 hover:shadow">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
                <div class="flex flex-col px-3 py-1 border space-y-3 hover:border-slate-300">
                    <div class="self-center h-32 md:h-40">
                        <img src="/images/grocery/banana.jpeg" alt="" style="max-width: 100%; height:100%">
                    </div>
                    
                    {{-- name and stock --}}
                    <div>
                        <h3 class="inline font-semibold hover:text-blue-600">
                            <a href="">Shwe Late Pyar fresh organic Thi Hmwe banana</a>
                        </h3>
                        <span class="text-xs">(128 items left)</span>
                    </div>
                    
                    <div>
                        <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">1,575 <span class="text-sm">MMK</span></h5>
                        <div class="mt-2">
                            <h6 class="inline px-2 py-[3px] text-black line-through decoration-red-600 text-md md:text-lg">1,750</h6>
                            <span class="bg-green-400 rounded-xl px-2 py-px text-sm">save 10%</span>
                        </div>
                    </div>

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
                        <a href="" class="text-sm text-blue-500 hover:text-blue-700 ml-2">104</a>
                    </div>
                    <div class="text-sm flex items-center space-x-2">
                        <span>Delivery Available</span>
                        <svg class="w-4 h-4 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm">By <a href="" class="hover:text-blue-700">Example Co.ltd</a></div>
                </div>
            </div>
        </main>

        <footer class="bg-slate-100">
            <div class="container mx-auto flex flex-col px-4 text-slate-600 py-6">
                <section class="flex justify-center items-center md:justify-between">
                    <div class="space-y-4 text-center md:text-left">
                            <div class="text-center md:text-left">
                                <p class="text-sm">We accept multiple payments</p>
                            </div>
                            <h2 class="text-xl font-bold lg:text-2xl">Start shopping with Yangon Mart today.</h2>
                        <a href="" class="block w-full bg-blue-600 p-2 rounded-xl text-center shadow-lg text-white hover:bg-blue-700">Sign up</a>
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
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-5">
                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                </svg>
                                <a href="tel:+959771637812" class="hover:text-black">+95 9 771 637 812</a>
                            </div>
                            <div class="flex items-center justify-center space-x-2 md:justify-start">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-5">
                                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                </svg>
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
</body>
</html>
