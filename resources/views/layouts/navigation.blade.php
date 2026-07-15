<div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-black bg-opacity-40 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 h-full transition duration-300 transform bg-white border-r border-gray-200 lg:translate-x-0 lg:static lg:inset-0">
    
    @php
        $dashboardRoute = Auth::user()->role === \App\Enums\UserRole::ADMIN ? route('admin.dashboard') : route('organizer.dashboard');
    @endphp

    <div class="flex items-center justify-between px-6 py-4 border-b bg-gray-50 border-gray-200 min-h-[73px]">
        <a href="{{ $dashboardRoute }}" class="flex items-center space-x-3 text-gray-800">
            <x-application-logo class="w-auto h-8 text-blue-600 fill-current" />
            <div class="flex flex-col leading-tight">
                <span class="text-lg font-black tracking-wider text-blue-600">STRIDETIX</span>
                <span class="text-[9px] font-bold text-gray-400 font-mono tracking-widest uppercase">Event Ticketing</span>
            </div>
        </a>
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden">
            <i class="text-xl fa-solid fa-xmark"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        @php
            $isDashboardActive = request()->routeIs('admin.dashboard') || request()->routeIs('organizer.dashboard') || request()->routeIs('dashboard');
        @endphp
        <a href="{{ $dashboardRoute }}" 
            class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors duration-200 group {{ $isDashboardActive ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fa-solid fa-chart-pie w-5 text-lg transition-colors mr-3 {{ $isDashboardActive ? 'text-white' : 'text-slate-400 group-hover:text-gray-600' }}"></i>
            {{ __('Dashboard') }}
        </a>

        @if(Auth::user()->role === \App\Enums\UserRole::ADMIN)
            <a href="{{ route('admin.users.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors duration-200 group {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fa-solid fa-users w-5 text-lg transition-colors mr-3 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                {{ __('Kelola Pengguna') }}
            </a>

            <a href="{{ route('admin.organizers.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors duration-200 group {{ request()->routeIs('admin.organizers.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fa-solid fa-building w-5 text-lg transition-colors mr-3 {{ request()->routeIs('admin.organizers.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                {{ __('Kelola Organizer (EO)') }}
            </a>

            <a href="{{ route('admin.events.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors duration-200 group {{ request()->routeIs('admin.events.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fa-solid fa-calendar-days w-5 text-lg transition-colors mr-3 {{ request()->routeIs('admin.events.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                {{ __('Kelola Event') }}
            </a>

            <a href="{{ route('admin.race-categories.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors duration-200 group {{ request()->routeIs('admin.race-categories.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fa-solid fa-list w-5 text-lg transition-colors mr-3 {{ request()->routeIs('admin.race-categories.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                {{ __('Kelola Kategori Lomba') }}
            </a>

            <a href="{{ route('admin.ticket-tiers.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors duration-200 group {{ request()->routeIs('admin.ticket-tiers.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fa-solid fa-ticket w-5 text-lg transition-colors mr-3 {{ request()->routeIs('admin.ticket-tiers.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                {{ __('Kelola Tier Tiket') }}
            </a>
        @endif
    </nav>

    <div class="flex items-center p-4 space-x-3 text-sm border-t bg-gray-50 border-gray-200 text-gray-600">
        <div class="flex items-center justify-center w-8 h-8 font-bold text-white bg-blue-600 rounded-full shrink-0">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="flex-1 truncate">
            <p class="text-xs font-semibold leading-none text-gray-800 truncate">{{ Auth::user()->name }}</p>
            <span class="text-[10px] text-gray-500 font-mono block mt-1 uppercase tracking-wider">
                Role: <span class="{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? 'text-amber-600' : 'text-blue-600' }} font-bold">{{ Auth::user()->role->label() }}</span>
            </span>
        </div>
    </div>
</div>