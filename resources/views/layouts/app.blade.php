<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StrideTix') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logo.webp') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <div x-data="{ sidebarOpen: false, profileOpen: false }" class="flex h-screen overflow-hidden">
            
            @include('layouts.navigation')

            <div class="flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm min-h-[73px]">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="mr-4 text-gray-500 focus:outline-none lg:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        @isset($header)
                            <div class="text-xl font-bold leading-tight text-gray-800">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <div class="flex items-center">
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 transition duration-150 ease-in-out bg-white rounded-md hover:text-gray-800 focus:outline-none">
                                <div class="mr-1"><i class="mr-2 text-lg fa-regular fa-circle-user"></i>{{ Auth::user()->name }}</div>
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-cloak x-show="profileOpen" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg focus:outline-none">
                                <div class="py-1">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        <i class="mr-2 text-gray-400 fa-solid fa-user-gear"></i>{{ __('Profile') }}
                                    </x-dropdown-link>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <span class="text-red-600"><i class="mr-2 fa-solid fa-arrow-right-from-bracket"></i>{{ __('Log Out') }}</span>
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-6 bg-gray-50">
                    
                    @isset($breadcrumbs)
                        <nav class="flex mb-4 text-sm font-medium text-slate-500" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                {{ $breadcrumbs }}
                            </ol>
                        </nav>
                    @endisset

                @if (session('success'))
                    <div class="mb-4 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl transition-all duration-300">
                        <div class="p-4 border-l-4 border-green-500 bg-green-50/70 flex items-start gap-3">
                            <div class="text-green-600 mt-0.5 shrink-0">
                                <i class="fa-solid fa-circle-check text-lg"></i>
                            </div>
                            
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-900 leading-none mb-1">Berhasil!</p>
                                <p class="text-xs text-green-700 leading-relaxed">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                    {{ $slot }}
                </main>

                <footer class="mt-auto bg-white border-t border-gray-200">
                    <div class="flex items-center justify-center px-6 py-3 mx-auto max-w-7xl">
                        <p class="text-xs text-center text-gray-500">&copy; {{ date('Y') }} StrideTix. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>