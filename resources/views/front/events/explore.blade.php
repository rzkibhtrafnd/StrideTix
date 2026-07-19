<x-public-layout>
    @slot('title', 'Jelajahi - StrideTix')
    <section class="relative pt-24 pb-12 bg-gradient-to-br from-blue-900 via-blue-800 to-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-4">
                Jelajah Event Lari
            </h1>
            <p class="text-blue-100 mb-8 max-w-2xl mx-auto text-sm md:text-base">
                Temukan event lari yang cocok untuk Anda, dari Fun Run hingga Full Marathon di berbagai kota.
            </p>
            
            <form action="{{ route('front.event.explore') }}" method="GET" class="max-w-5xl mx-auto bg-white p-3 md:rounded-full rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-4 items-center gap-3">
                
                <!-- Input Nama Event -->
                <div class="flex items-center px-4 py-2 bg-white border border-slate-300 rounded-full shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs mr-2"></i>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama event..." class="w-full border-none focus:ring-0 text-xs font-medium text-slate-700 bg-transparent placeholder-slate-400 p-0">
                </div>

                <!-- Dropdown Provinsi -->
                <div class="flex items-center px-4 py-1.5 bg-white border border-slate-300 rounded-full shadow-sm">
                    <i class="fa-solid fa-map text-slate-400 text-xs mr-2"></i>
                    <select id="province_filter" name="province_id" class="w-full border-none focus:ring-0 text-xs font-medium text-slate-700 bg-transparent cursor-pointer p-0">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov['id'] }}" @selected(($filters['province_id'] ?? '') == $prov['id'])>{{ $prov['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Kota/Kabupaten -->
                <div class="flex items-center px-4 py-1.5 bg-white border border-slate-300 rounded-full shadow-sm">
                    <i class="fa-solid fa-location-dot text-slate-400 text-xs mr-2"></i>
                    <select id="regency_filter" name="regency_id" disabled class="w-full border-none focus:ring-0 text-xs font-medium text-slate-700 bg-transparent cursor-pointer p-0 disabled:opacity-50">
                        <option value="">-- Pilih Kota/Kabupaten --</option>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-2 pl-2 w-full">
                    @if(!empty($filters['search']) || !empty($filters['province_id']) || !empty($filters['regency_id']))
                        <a href="{{ route('front.event.explore') }}" class="text-slate-400 hover:text-slate-600 text-sm font-bold px-3 transition">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-full px-6 py-2.5 text-xs font-bold transition whitespace-nowrap shadow-sm shadow-blue-200">
                        Cari Event
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Hasil Pencarian dan Forelse Tetap Sama Sesuai Kode Asli Anda -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Hasil Pencarian</h2>
                    <p class="text-slate-500 text-sm mt-1">Menampilkan daftar event yang tersedia.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($events as $event)
                    <a href="{{ route('front.event.show', $event->id) }}" class="group flex flex-col bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden h-full">
                        <div class="relative aspect-[4/3] bg-gradient-to-tr from-slate-200 to-slate-100 overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                <i class="fa-solid fa-person-running text-7xl text-slate-400"></i>
                            </div>
                            <div class="absolute top-3 left-3 bg-white/95 backdrop-blur shadow-sm rounded-lg text-center px-3 py-1.5 border border-slate-100/50">
                                <span class="block text-xs font-bold text-red-500 uppercase">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('M') }}</span>
                                <span class="block text-xl font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-[17px] font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <div class="mt-3 space-y-2 text-sm text-slate-500 flex-grow">
                                <p class="flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot mt-1 text-slate-400 w-4 text-center"></i>
                                    <span class="line-clamp-1">{{ $event->location }}</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <i class="fa-solid fa-building-user mt-1 text-slate-400 w-4 text-center"></i>
                                    <span class="line-clamp-1">{{ $event->organizer->company_name ?? 'Penyelenggara Mandiri' }}</span>
                                </p>
                            </div>
                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Mulai Dari</p>
                                    <p class="text-blue-600 font-black text-lg">
                                        @if($event->min_price)
                                            Rp{{ number_format($event->min_price, 0, ',', '.') }}
                                        @else
                                            <span class="text-sm text-slate-400">Belum ada harga</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <!-- Bagian Empty State -->
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-magnifying-glass text-slate-300 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Event tidak ditemukan</h3>
                        <p class="text-slate-500 text-sm mt-1 max-w-sm">Maaf, kami tidak menemukan event yang sesuai dengan kriteria pencarian Anda.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $events->appends(request()->query())->links() }}
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.initRegionSelector({
                provinceSelectId: 'province_filter',
                regencySelectId: 'regency_filter',
                isPublicForm: true,
                oldProvinceId: "{{ $filters['province_id'] ?? '' }}",
                oldRegencyId: "{{ $filters['regency_id'] ?? '' }}"
            });
        });
    </script>
</x-public-layout>