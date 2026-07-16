<x-public-layout>
    <x-slot name="title">Pendaftaran Berhasil - StrideTix</x-slot>

    <div class="pt-28 pb-20 min-h-screen bg-slate-50 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4">
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-center text-white relative">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                    
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto text-3xl mb-4 backdrop-blur-xs animate-bounce">
                        <i class="fa-solid fa-check text-white"></i>
                    </div>
                    
                    <h2 class="text-2xl font-black tracking-wide">Pemesanan Tiket Berhasil!</h2>
                    <p class="text-emerald-100 text-xs mt-1 font-medium">Silakan lakukan pembayaran untuk mengamankan slot BIB lintasan Anda.</p>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    
                    <div class="bg-slate-50 rounded-2xl p-4 flex flex-wrap justify-between items-center gap-4 border border-slate-100">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Nomor Invoice</p>
                            <p class="text-sm font-mono font-black text-slate-800 tracking-wide">{{ $order->invoice_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Status Tagihan</p>
                            <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wide rounded-md bg-amber-50 text-amber-600 border border-amber-200">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Detail Pembelian Tiket</h4>
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-2xl px-4 bg-white shadow-xs">
                            @foreach($order->items as $item)
                                <div class="py-3.5 flex justify-between items-center text-sm">
                                    <div>
                                        <p class="font-bold text-slate-800">
                                            {{ $item->ticketTier->raceCategory->category_name }} 
                                            <span class="text-xs font-mono font-bold bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded ml-1">{{ $item->ticketTier->raceCategory->distance_km }}K</span>
                                        </p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Fase: {{ $item->ticketTier->tier_name }} &bull; Kuantitas: {{ $item->quantity }}x</p>
                                    </div>
                                    <span class="font-mono font-bold text-slate-900">
                                        Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                            
                            <div class="py-4 flex justify-between items-center text-base border-t border-slate-200 font-black">
                                <span class="text-slate-800">Total Pembayaran</span>
                                <span class="text-blue-600 font-mono text-lg">Rp{{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-2xl flex gap-3 items-start">
                        <i class="fa-solid fa-circle-info text-blue-500 mt-0.5 text-sm"></i>
                        <div class="text-xs text-slate-600 leading-relaxed">
                            <p class="font-bold text-slate-800 mb-0.5">Petunjuk Pembayaran:</p>
                            Sistem pembayaran otomatis menggunakan Payment Gateway sedang dikonfigurasi. E-ticket resmi beserta nomor dada lintasan (BIB) otomatis dikirim ke email <strong class="text-slate-900">{{ $order->customer_email }}</strong> segera setelah status invoice dikonfirmasi lunas oleh panitia.
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('home') }}" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded-xl transition shadow-md flex justify-center items-center gap-2 text-xs">
                            <i class="fa-solid fa-house"></i> Kembali ke Beranda
                        </a>
                        <button onclick="window.print()" class="w-full bg-white hover:bg-slate-50 text-slate-700 font-bold py-3 px-4 rounded-xl transition border border-slate-200 shadow-sm flex justify-center items-center gap-2 text-xs">
                            <i class="fa-solid fa-print"></i> Cetak Bukti Pendaftaran
                        </button>
                    </div>

                </div>

            </div>
            
            <p class="text-center text-[11px] text-slate-400 mt-6 tracking-wide">&copy; {{ date('Y') }} StrideTix Automation System. All rights reserved.</p>
        </div>
    </div>
</x-public-layout>