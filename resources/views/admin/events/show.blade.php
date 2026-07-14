<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.events.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i class="fa-solid fa-person-running mr-2 text-xs"></i>Manajemen Event Lari
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                <span class="text-slate-400 font-medium">Detail Event</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Informasi Lengkap Event') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mt-6">
        
        <div class="space-y-6 lg:col-span-2">
            
            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider {{ $event->status->badgeClass() }}">
                            {{ $event->status->label() }}
                        </span>
                        <h3 class="text-xl mt-3 font-bold text-slate-900 leading-snug">{{ $event->title }}</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            <i class="fa-solid fa-building-user mr-1.5 text-slate-400"></i>Penyelenggara: <span class="font-semibold text-slate-700">{{ $event->organizer->company_name ?? 'Tidak Terikat' }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="flex items-center p-3 border border-slate-50 rounded-xl bg-slate-50/50">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-50 text-blue-600 rounded-xl mr-3 shrink-0">
                            <i class="fa-solid fa-calendar-check text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Tanggal Balapan</p>
                            <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 border border-slate-50 rounded-xl bg-slate-50/50">
                        <div class="flex items-center justify-center w-10 h-10 bg-amber-50 text-amber-600 rounded-xl mr-3 shrink-0">
                            <i class="fa-solid fa-map-location-dot text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Lokasi Venue</p>
                            <p class="text-sm font-bold text-slate-800 truncate max-w-[200px]">{{ $event->location }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center">
                    <i class="fa-solid fa-file-invoice mr-2 text-slate-400"></i>Deskripsi & Regulasi Perlombaan
                </h4>
                <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line bg-gray-50/40 p-4 rounded-xl border border-gray-100">
                    {{ $event->description }}
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center">
                    <i class="fa-solid fa-map-pin mr-2 text-slate-400"></i>Titik Kumpul (Assembly Area)
                </h4>
                
                <div class="p-4 border border-slate-100 rounded-xl bg-slate-50/30 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center shadow-sm mb-3">
                        <i class="fa-solid fa-location-dot text-xl"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">{{ $event->location }}</p>
                    <p class="text-xs text-slate-400 mt-1">Pastikan pelari berada di area *Corral Start* 30 menit sebelum jadwal *Flag-Off*.</p>
                    
                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="w-full mt-4 inline-flex items-center justify-center text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 border border-transparent rounded-lg px-4 py-2.5 shadow-sm transition-colors group">
                            <i class="fa-solid fa-route mr-2 text-red-400 group-hover:animate-pulse"></i>{{ __('Buka Rute Google Maps') }}
                        </a>
                    @else
                        <span class="w-full mt-4 inline-flex items-center justify-center text-xs font-medium text-slate-400 bg-slate-100 rounded-lg px-4 py-2.5 cursor-not-allowed">
                            <i class="fa-solid fa-link-slash mr-2"></i>{{ __('Tautan Peta Belum Tersedia') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center">
                    <i class="fa-solid fa-clock-rotate-left mr-2 text-slate-400"></i>Log Transparansi Sistem
                </h4>
                <div class="divide-y divide-slate-100 text-xs text-slate-600">
                    <div class="py-2.5 flex justify-between items-center">
                        <span class="text-slate-400 font-medium">Tanggal Dibuat</span>
                        <span class="font-mono font-semibold">{{ $event->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-center">
                        <span class="text-slate-400 font-medium">Pembaruan Terakhir</span>
                        <span class="font-mono font-semibold">{{ $event->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="w-full">
                        <x-primary-button class="w-full justify-center py-2.5">
                            {{ __('Ubah Events') }}
                        </x-primary-button>
                    </a>
                    
                    <a href="{{ route('admin.events.index') }}" class="w-full">
                        <x-secondary-button class="w-full justify-center py-2.5">
                            {{ __('Kembali ke Daftar') }}
                        </x-secondary-button>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>