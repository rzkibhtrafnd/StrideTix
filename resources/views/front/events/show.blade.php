<x-public-layout>
    <x-slot name="title">{{ $event->title }} - StrideTix</x-slot>

    <!-- Hero Banner (Poster Image Placeholder) -->
    <div class="pt-16"> <!-- Padding atas sebesar navbar -->
        <div class="w-full h-[40vh] md:h-[60vh] bg-gradient-to-r from-slate-900 to-blue-900 relative flex items-center justify-center">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            <!-- Ganti dengan tag <img> jika sudah ada fitur upload poster -->
            <i class="fa-solid fa-person-running text-white opacity-20 text-[150px]"></i>
            
            <div class="absolute bottom-0 w-full h-32 bg-gradient-to-t from-slate-50 to-transparent"></div>
        </div>
    </div>

    <!-- Konten Event Layout (Kiri: Info, Kanan: Tiket Sticky) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Detail & Deskripsi -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Judul -->
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h1 class="text-2xl md:text-4xl font-black text-slate-900 leading-tight">{{ $event->title }}</h1>
                    
                    <div class="flex flex-wrap gap-4 mt-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <i class="fa-solid fa-calendar-day"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pelaksanaan</p>
                                <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lokasi</p>
                                <p class="font-bold text-slate-800">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Deskripsi -->
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Informasi Perlombaan</h3>
                    <div class="prose prose-slate max-w-none text-slate-600 text-sm whitespace-pre-line leading-loose">
                        {{ $event->description }}
                    </div>

                    @if($event->google_maps_url)
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Peta Lokasi Area</h3>
                            <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition">
                                <i class="fa-solid fa-map-location-dot text-red-500 mr-2"></i> Buka di Google Maps
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Penyelenggara -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 text-xl border border-slate-200">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Diselenggarakan oleh</p>
                        <p class="text-lg font-bold text-slate-900">{{ $event->organizer->company_name ?? 'Penyelenggara Mandiri' }}</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Pilihan Tiket (Sticky) -->
            <div class="lg:col-span-1">
                <!-- Class 'sticky top-24' membuat elemen ini mengambang saat discroll ke bawah -->
                <div class="bg-white border border-slate-200 shadow-xl rounded-2xl p-6 lg:sticky lg:top-24">
                    <h3 class="text-lg font-black text-slate-900 mb-1">Pilih Tiket Anda</h3>
                    <p class="text-xs text-slate-500 mb-6 border-b border-slate-100 pb-4">Tentukan kategori lari dan harga sesuai fase ketersediaan saat ini.</p>

                    <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($event->raceCategories as $category)
                            <div class="border border-slate-200 rounded-xl overflow-hidden">
                                <div class="bg-slate-50 px-4 py-3 flex justify-between items-center border-b border-slate-200">
                                    <div class="font-bold text-slate-800 text-sm">{{ $category->category_name }} <span class="text-blue-600 bg-blue-100 px-1.5 py-0.5 rounded text-[10px] ml-1">{{ $category->distance_km }}K</span></div>
                                </div>
                                
                                <div class="p-3 divide-y divide-slate-100">
                                    @forelse($category->ticketTiers as $tier)
                                        <div class="py-3 first:pt-1 last:pb-1">
                                            <div class="flex justify-between items-start mb-1">
                                                <span class="text-xs font-semibold text-slate-700">{{ $tier->tier_name }}</span>
                                                <span class="text-sm font-black text-blue-600">Rp{{ number_format($tier->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between items-end mt-2">
                                                <div class="text-[10px] text-slate-400">
                                                    Penjualan: <br> {{ $tier->start_date->format('d M') }} - {{ $tier->end_date->format('d M Y') }}
                                                </div>
                                                <!-- Logika Tombol Sederhana -->
                                                @if(now()->isBetween($tier->start_date, $tier->end_date) && $category->available_slot > 0)
                                                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-3 rounded transition">
                                                        Pilih
                                                    </button>
                                                @else
                                                    <button disabled class="bg-slate-100 text-slate-400 text-xs font-bold py-1.5 px-3 rounded cursor-not-allowed">
                                                        Tutup
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400 text-center py-2">Tiket belum tersedia</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 text-center py-6">Kategori lari belum dikonfigurasi.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <button class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg flex justify-center items-center gap-2">
                            Lanjutkan Pendaftaran <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>