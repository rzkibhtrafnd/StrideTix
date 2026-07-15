<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'StrideTix - Platform Tiket Event Lari' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-blue-600 selection:text-white">
    <header x-data="{ open: false }" class="fixed top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                        <i class="fa-solid fa-person-running"></i>
                    </div>
                    <span class="text-xl font-black tracking-wider text-blue-600">STRIDETIX</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors {{ request()->is('/') ? 'text-blue-600' : '' }}">Beranda</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Jelajah</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Tentang Kami</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Kontak</a>
                </nav>

                <div class="flex items-center gap-2 shrink-0">
                    @if (Route::has('login'))
                        <div class="hidden sm:flex items-center gap-2 mr-2">
                            @auth
                                <a href="{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? route('admin.dashboard') : route('organizer.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">
                                    <i class="fa-solid fa-chart-pie mr-1"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition shadow-sm">Masuk</a>
                            @endauth
                        </div>
                    @endif

                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden transition-colors" aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <svg :class="{'hidden': open, 'block': ! open }" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg :class="{'block': open, 'hidden': ! open }" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white border-b border-slate-200 absolute w-full left-0 shadow-lg" 
            style="display: none;">
            <div class="px-4 pt-2 pb-4 space-y-1.5 sm:px-6">
                <a href="{{ url('/') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold transition-colors {{ request()->is('/') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:bg-slate-50' }}">Beranda</a>
                <a href="#" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Jelajah</a>
                <a href="#" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Tentang Kami</a>
                <a href="#" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Kontak</a>
                
                @if (Route::has('login'))
                    <div class="pt-4 mt-2 border-t border-slate-100 sm:hidden">
                        @auth
                            <a href="{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? route('admin.dashboard') : route('organizer.dashboard') }}" class="flex w-full items-center justify-center px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 bg-slate-50 transition">
                                <i class="fa-solid fa-chart-pie mr-2"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex w-full items-center justify-center px-3 py-2.5 rounded-xl text-base font-bold text-white bg-blue-600 hover:bg-blue-700 transition shadow-sm">
                                Masuk
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-slate-200 py-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
            <div>
                <span class="font-black text-blue-600 tracking-wider">STRIDETIX</span> &copy; {{ date('Y') }}. Hak Cipta Dilindungi.
            </div>
            <div class="flex gap-6 font-medium">
                <a href="#" class="hover:text-blue-600 transition">Tentang Kami</a>
                <a href="#" class="hover:text-blue-600 transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-blue-600 transition">Kontak</a>
            </div>
        </div>
    </footer>
</body>
</html>