<x-public-layout>
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-20 bg-gradient-to-br from-blue-900 via-blue-800 to-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-500/30 border border-blue-400/30 text-blue-100 text-xs font-bold tracking-wider mb-4 uppercase">
                Platform Pendaftaran Resmi
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-6">
                Temukan Event Lari <br class="hidden md:block"/> Terbaik di Kotamu
            </h1>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Dari 5K Fun Run hingga Full Marathon. Beli tiket dengan aman, dapatkan e-BIB secara instan, dan bersiaplah memecahkan rekor personal Anda!
            </p>
            
            <div class="max-w-3xl mx-auto bg-white p-2 rounded-full shadow-xl flex items-center">
                <div class="flex-grow flex items-center px-4">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <input type="text" placeholder="Cari nama event lari..." class="w-full border-none focus:ring-0 text-sm font-medium text-slate-700 bg-transparent placeholder-slate-400">
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-full px-6 py-3 text-sm font-bold transition">
                    Cari Event
                </button>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Event Mendatang</h2>
                    <p class="text-slate-500 text-sm mt-1">Pendaftaran sedang dibuka, amankan slot Anda!</p>
                </div>
                <a href="#" class="hidden md:inline-block text-sm font-bold text-blue-600 hover:text-blue-700">Lihat Semua <i class="fa-solid fa-arrow-right ml-1 text-xs"></i></a>
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
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>