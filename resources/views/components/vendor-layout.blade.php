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
    <section>
        <div x-data="{ open: true }">
            {{-- sidebar --}}
            <nav x-show="open" class="fixed w-72 inset-0 z-40 bg-gray-100" x-transition:enter="transform ease-in-out duration-500" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
                <div class="px-6 py-4">
                    <div class="flex w-full justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 flex overflow-hidden rounded-full bg-white">
                                <img src="{{ asset('images/no-image.png') }}" alt="" class="object-contain">
                            </div>
                            <div class="flex flex-col text-gray-700">
                                <h1 class="font-medium">Nyein Chan Soe</h1>
                                <span class="text-xs">@user_ncs</span>
                            </div>
                        </div>
                        <button x-on:click="open=false" x-show="open">
                            <x-icon name="hamburger" />
                        </button>
                    </div>
                </div>
            </nav>

            {{-- sidebar hidden --}}
            <div x-show="!open" class="fixed w-14 inset-0 z-40 bg-gray-100" x-transition:enter="transform ease-in-out duration-500" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>
                <div class="px-2 py-4">
                    <button x-on:click="open=true" x-show="!open" class="flex w-full justify-center">
                        <x-icon name="hamburger" />
                    </button>
                </div>
            </div>
            
            {{-- dashboard --}}
            <div>
                
            </div>
        </div>

        {{$slot}}
    </section>

    <x-flash />
</body>
</html>