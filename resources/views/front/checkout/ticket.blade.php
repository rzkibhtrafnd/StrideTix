<x-public-layout>
    <x-slot name="title">Pilih Tiket - {{ $event->title }}</x-slot>

    <div class="pt-24 pb-16 min-h-screen bg-slate-50" 
        x-data="{ 
            selectedTickets: {}, 
            prices: {},
            
            init() {
                @foreach($event->raceCategories as $category)
                    @foreach($category->ticketTiers as $tier)
                        // Inisialisasi semua tier agar object state tidak bernilai undefined saat render input
                        this.selectedTickets[{{ $tier->id }}] = 0;
                        this.prices[{{ $tier->id }}] = {{ $tier->price }};
                    @endforeach
                @endforeach
            },

            calculateGrandTotal() {
                let total = 0;
                for (let id in this.selectedTickets) {
                    total += this.selectedTickets[id] * this.prices[id];
                }
                return total;
            },

            hasSelection() {
                for (let id in this.selectedTickets) {
                    if (this.selectedTickets[id] > 0) return true;
                }
                return false;
            }
        }">
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-center gap-4 mb-8 text-sm font-bold text-slate-400">
                <span class="text-blue-600 flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-full">
                    <span class="w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs">1</span> Pilih Tiket
                </span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="flex items-center gap-2">
                    <span class="w-5 h-5 bg-slate-300 text-slate-600 rounded-full flex items-center justify-center text-xs">2</span> Isi Data
                </span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="flex items-center gap-2">
                    <span class="w-5 h-5 bg-slate-300 text-slate-600 rounded-full flex items-center justify-center text-xs">3</span> Pembayaran
                </span>
            </div>

            <!-- Menampilkan Flash Error Jika Input Kosong dari Validasi Controller -->
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 text-sm font-bold rounded-xl flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('front.checkout.form', $event->id) }}">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-xs">
                            <h2 class="text-xl font-black text-slate-900 mb-1">Kategori Tiket Tersedia</h2>
                            <p class="text-xs text-slate-500 mb-6">Pilih kuantitas tiket lomba lari yang ingin Anda pesan.</p>

                            <div class="space-y-6">
                                @foreach($event->raceCategories as $category)
                                    <div class="border border-slate-200/60 rounded-2xl bg-slate-50/50 p-5">
                                        <div class="flex justify-between items-center border-b border-slate-200 pb-3 mb-4">
                                            <span class="font-black text-slate-800 text-sm">{{ $category->category_name }}</span>
                                            <span class="text-xs font-mono bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-md font-bold">{{ $category->distance_km }} KM</span>
                                        </div>

                                        <div class="space-y-3">
                                            @foreach($category->ticketTiers as $tier)
                                                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-2xs flex justify-between items-center gap-4">
                                                    <div>
                                                        <h4 class="font-bold text-slate-900 text-sm">{{ $tier->tier_name }}</h4>
                                                        <p class="text-[11px] text-slate-400 mt-0.5">Penjualan: {{ $tier->start_date->format('d M') }} - {{ $tier->end_date->format('d M Y') }}</p>
                                                        <p class="text-blue-600 font-black text-base mt-1.5">Rp{{ number_format($tier->price, 0, ',', '.') }}</p>
                                                    </div>

                                                    @if($tier->status_label === 'tersedia')
                                                        <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white shadow-2xs">
                                                            <button type="button" 
                                                                    @click="if(selectedTickets[{{ $tier->id }}] > 0) selectedTickets[{{ $tier->id }}]--" 
                                                                    class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 font-bold text-slate-600 border-r border-slate-200 text-sm transition">-</button>
                                                            
                                                            <!-- PENTING: Hilangkan readonly agar sinkronisasi value binding x-model berjalan sempurna -->
                                                            <input type="number" 
                                                                name="tickets[{{ $tier->id }}]" 
                                                                x-model.number="selectedTickets[{{ $tier->id }}]"
                                                                min="0"
                                                                max="{{ min(5, $tier->slot_limit) }}"
                                                                class="w-12 text-center border-none focus:ring-0 text-sm font-bold text-slate-800 p-1"
                                                            >
                                                            
                                                            <button type="button" 
                                                                    @click="if(selectedTickets[{{ $tier->id }}] < {{ min(5, $tier->slot_limit) }}) selectedTickets[{{ $tier->id }}]++" 
                                                                    class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 font-bold text-slate-600 border-l border-slate-200 text-sm transition">+</button>
                                                        </div>
                                                    @elseif($tier->status_label === 'habis')
                                                        <span class="px-3 py-1 rounded-md bg-red-50 text-red-600 font-black text-[10px] uppercase tracking-wide border border-red-200">Slot Habis</span>
                                                    @else
                                                        <span class="px-3 py-1 rounded-md bg-slate-100 text-slate-400 font-black text-[10px] uppercase tracking-wide">Tutup</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 lg:sticky lg:top-24">
                        <div class="bg-white border border-slate-200/60 shadow-md rounded-3xl p-6">
                            <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 mb-4">Ringkasan Pemesanan</h3>
                            
                            <div class="space-y-3 text-sm text-slate-600">
                                <div class="flex justify-between gap-4">
                                    <span class="shrink-0">Event</span>
                                    <span class="font-bold text-slate-900 truncate max-w-[180px]">{{ $event->title }}</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-100 pt-3">
                                    <span>Subtotal Tiket</span>
                                    <span class="font-mono font-bold text-slate-900" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(calculateGrandTotal())">Rp0</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                        :disabled="!hasSelection()"
                                        :class="hasSelection() ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md cursor-pointer' : 'bg-slate-100 text-slate-400 cursor-not-allowed'" 
                                        class="w-full font-bold py-3 px-4 rounded-xl transition flex justify-center items-center gap-2 text-sm"
                                    >
                                    Lanjutkan Pengisian Data <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-public-layout>