<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.organizers.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i class="fa-solid fa-building-user mr-2 text-xs"></i>Manajemen Penyelenggara
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-500 mx-2"></i>
                <span class="text-slate-500 font-medium">Detail Profil EO</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Profil Penyelenggara') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mt-6">
        <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6 lg:col-span-2">
            <div class="flex items-center gap-4 border-b pb-4 border-slate-100">
                @if($organizer->logo)
                    <img src="{{ asset('storage/' . $organizer->logo) }}" class="w-20 h-20 object-cover rounded-2xl border border-slate-200 shadow-sm" alt="Logo">
                @else
                    <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center border border-slate-100 shadow-inner">
                        <i class="fa-solid fa-building text-3xl"></i>
                    </div>
                @endif
                <div>
                    <h3 class="text-xl font-black text-slate-900">{{ $organizer->company_name }}</h3>
                    <p class="text-xs text-slate-500 mt-1 font-mono uppercase tracking-wider">ID Organizer: #{{ $organizer->id }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                <div class="p-4 border border-slate-100 bg-slate-50/50 rounded-xl">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Penanggung Jawab Akun</p>
                    <p class="text-sm font-bold text-slate-800 mt-1">
                        <i class="fa-regular fa-circle-user mr-2 text-slate-500"></i>{{ $organizer->user->name }}
                    </p>
                    <span class="mt-2 inline-block px-2 py-0.5 text-[10px] font-bold rounded uppercase {{ $organizer->user->role->badgeClass() }}">
                        {{ $organizer->user->role->label() }}
                    </span>
                </div>
                <div class="p-4 border border-slate-100 bg-slate-50/50 rounded-xl">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Saluran Kontak Email</p>
                    <p class="text-sm font-bold text-slate-800 mt-1"><i class="fa-regular fa-envelope mr-2 text-slate-500"></i>{{ $organizer->user->email }}</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
            <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center">
                <i class="fa-solid fa-clock-rotate-left mr-2 text-slate-500"></i>Log Transparansi Sistem
            </h4>
            <div class="divide-y divide-slate-100 text-xs text-slate-600">
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Tanggal Registrasi</span>
                    <span class="font-mono font-semibold">{{ $organizer->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Pembaruan Terakhir</span>
                    <span class="font-mono font-semibold">{{ $organizer->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col gap-2">
                <a href="{{ route('admin.organizers.edit', $organizer->id) }}" class="w-full">
                    <x-primary-button class="w-full justify-center py-2.5">
                        {{ __('Ubah Profil') }}
                    </x-primary-button>
                </a>
                
                <a href="{{ route('admin.organizers.index') }}" class="w-full">
                    <x-secondary-button class="w-full justify-center py-2.5">
                        {{ __('Kembali ke Daftar') }}
                    </x-secondary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>