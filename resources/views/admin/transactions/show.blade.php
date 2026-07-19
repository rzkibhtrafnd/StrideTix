<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ request()->is('admin*') ? route('admin.transactions.index') : route('organizer.transactions.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i class="fa-solid fa-receipt mr-2 text-xs"></i>Riwayat Transaksi
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-500 mx-2"></i>
                <span class="text-slate-500 font-medium">Detail Invoice</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Rincian Lengkap Transaksi') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mt-6">
        
        <div class="space-y-6 lg:col-span-2">
            
            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        @if($order->payment_status === 'settlement')
                            <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">✓ Lunas (Settlement)</span>
                        @elseif($order->payment_status === 'pending')
                            <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">⏳ Menunggu Pembayaran</span>
                        @else
                            <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider bg-red-100 text-red-800 border border-red-200">✕ Expired / Batal</span>
                        @endif
                        
                        <h3 class="text-xl mt-3 font-bold text-slate-900 font-mono tracking-tight">{{ $order->invoice_number }}</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            <i class="fa-solid fa-user-check mr-1.5 text-slate-400"></i>Terikat Akun Pengguna: <span class="font-semibold text-blue-600">@<span>{{ $order->user->name ?? 'Guest/Deleted' }}</span></span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="flex items-center p-3 border border-slate-50 rounded-xl bg-slate-50/50">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-50 text-blue-600 rounded-xl mr-3 shrink-0">
                            <i class="fa-solid fa-calendar-day text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Waktu Transaksi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $order->created_at->format('d F Y - H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 border border-slate-50 rounded-xl bg-slate-50/50">
                        <div class="flex items-center justify-center w-10 h-10 bg-amber-50 text-amber-600 rounded-xl mr-3 shrink-0">
                            <i class="fa-solid fa-credit-card text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Channel Pembayaran</p>
                            <p class="text-sm font-bold text-slate-800 uppercase">{{ str_replace('_', ' ', $order->payment_method ?? 'Midtrans') }} ({{ $order->payment_provider_channel ?? '-' }})</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center">
                    <i class="fa-solid fa-id-card mr-2 text-slate-500"></i>Data Profil Pemesan Tiket
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm bg-slate-50/50 p-4 border border-slate-100 rounded-xl">
                    <div>
                        <span class="text-xs text-slate-400 block font-medium">Nama Lengkap</span>
                        <span class="font-bold text-slate-800">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium">Alamat Email</span>
                        <span class="font-bold text-slate-800 break-all">{{ $order->customer_email }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium">Nomor WhatsApp/Telepon</span>
                        <span class="font-bold text-slate-800">{{ $order->customer_phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center">
                    <i class="fa-solid fa-running mr-2 text-slate-500"></i>Manifest Data Diri Pelari (Participants)
                </h4>
                
                <div class="space-y-4">
                    @php $participantCount = 1; @endphp
                    @foreach($order->items as $item)
                        @foreach($item->participants as $participant)
                            <div class="border border-slate-200 rounded-xl bg-slate-50/20 overflow-hidden shadow-2xs">
                                <div class="bg-slate-100/80 border-b border-slate-200 px-4 py-2 flex justify-between items-center">
                                    <span class="font-mono font-black text-xs text-slate-700">PELARI #{{ $participantCount++ }}</span>
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                        {{ $item->ticketTier?->raceCategory?->category_name ?? 'Balapan' }}
                                    </span>
                                </div>

                                <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                                    <div class="sm:col-span-2">
                                        <span class="text-slate-400 block font-medium">Nama Lengkap Pelari</span>
                                        <span class="font-bold text-slate-800 text-sm">{{ $participant->full_name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Jenis Kelamin</span>
                                        <span class="font-bold text-slate-800">
                                            {{ $participant->gender === \App\Enums\Gender::MALE->value || $participant->gender === 'M' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Tanggal Lahir</span>
                                        <span class="font-bold text-slate-800 font-mono">
                                            {{ $participant->date_of_birth ? \Carbon\Carbon::parse($participant->date_of_birth)->format('d/m/Y') : '-' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">
                                            Identitas ({{ strtoupper($participant->identity_type->value ?? 'KTP') }})
                                        </span>
                                        <span class="font-bold text-slate-800 font-mono">{{ $participant->identity_number }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Golongan Darah</span>
                                        <span class="font-bold text-slate-800 font-mono">{{ $participant->blood_type ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Ukuran Jersey</span>
                                        <span class="font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded font-mono text-[11px] inline-block mt-0.5">{{ $participant->jersey_size ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="bg-amber-50/40 border-t border-slate-200/60 p-3 text-[11px] text-slate-600 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <div>
                                        <span class="text-slate-400">Kontak Darurat:</span>
                                        <span class="font-semibold text-slate-800 ml-1">{{ $participant->emergency_contact_name ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400">Hubungan:</span>
                                        <span class="font-semibold text-slate-800 ml-1">{{ $participant->emergency_relation ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400">No. Telepon:</span>
                                        <span class="font-mono font-semibold text-slate-800 ml-1">{{ $participant->emergency_contact_phone ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                    @if($order->items->flatMap->participants->isEmpty())
                        <div class="text-center py-6 text-sm text-slate-400 bg-slate-50 border border-dashed rounded-xl">
                            <i class="fa-solid fa-user-slash text-xl mb-1 text-slate-300 block"></i>
                            Belum ada data pelari yang diisi untuk transaksi ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center">
                    <i class="fa-solid fa-ticket mr-2 text-slate-500"></i>Item Tiket Balapan yang Dipesan
                </h4>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        @php $event = $item->ticketTier?->raceCategory?->event; @endphp
                        <div class="border border-slate-100 rounded-xl p-4 bg-slate-50/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <span class="bg-blue-600 text-white font-black text-xs px-2.5 py-1 rounded-md tracking-wide uppercase">
                                    {{ $event->title ?? 'Deleted Event' }}
                                </span>
                                <div class="flex items-center gap-3 mt-2 text-sm font-semibold text-slate-700">
                                    <span><i class="fa-solid fa-person-running mr-1 text-slate-400"></i>{{ $item->ticketTier?->raceCategory?->category_name ?? '-' }}</span>
                                    <span class="text-slate-300">|</span>
                                    <span><i class="fa-solid fa-tags mr-1 text-slate-400"></i>Fase: {{ $item->ticketTier->tier_name }}</span>
                                </div>
                            </div>
                            <div class="text-left sm:text-right border-t sm:border-0 pt-2 sm:pt-0 w-full sm:w-auto flex sm:flex-col justify-between items-center sm:items-end">
                                <span class="text-xs text-slate-400 font-medium">Kuantitas: <b class="text-slate-800 font-mono font-bold">{{ $item->quantity }}x</b></span>
                                <span class="text-sm font-mono font-black text-blue-600 mt-0.5">
                                    Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center">
                    <i class="fa-solid fa-receipt mr-2 text-slate-500"></i>Ikhtisar Finansial
                </h4>
                
                <div class="p-4 border border-slate-100 rounded-xl bg-slate-50/30">
                    @if($order->va_number)
                        <div class="flex flex-col items-center text-center pb-3 border-b border-dashed border-slate-200 mb-3">
                            <span class="text-xs text-slate-400 font-medium mb-1">Nomor Virtual Account (VA)</span>
                            <span class="text-lg font-mono font-black text-blue-600 tracking-widest bg-blue-50/50 border border-blue-100 px-3 py-1 rounded-lg">{{ $order->va_number }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-end pt-1">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Total Nominal Gross</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">*Sudah termasuk pajak/biaya gerbang</span>
                        </div>
                        <span class="text-xl font-mono font-black text-slate-900">Rp{{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center">
                    <i class="fa-solid fa-code-compare mr-2 text-slate-500"></i>Log Transparansi Midtrans
                </h4>
                <div class="divide-y divide-slate-100 text-xs text-slate-600">
                    <div class="py-2.5 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Order Reference ID</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $order->invoice_number }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Sync Status Webhook</span>
                        <span class="font-mono font-bold capitalize {{ $order->payment_status == 'settlement' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $order->payment_status }}</span>
                    </div>
                    <div class="py-2.5 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Terakhir Sinkron</span>
                        <span class="font-mono font-semibold">{{ $order->updated_at->format('d/m/Y H:i') }} WIB</span>
                    </div>
                </div>
                
                @if(!request()->is('admin*'))
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl text-[11px] text-blue-800 leading-relaxed font-medium">
                        <i class="fa-solid fa-circle-info mr-1.5 text-blue-600"></i>
                        @if($order->payment_status === 'settlement')
                            Data peserta sah terdaftar. Kuota sub-kategori dipotong otomatis dan E-Tiket terkirim via email pendaftar.
                        @elseif($order->payment_status === 'pending')
                            Masa tenggang pembayaran aktif. Jangan berikan status check-in fisik sebelum status lunas.
                        @else
                            Invoice kedaluwarsa. Silakan instruksikan pendaftar melakukan checkout ulang di halaman publik.
                        @endif
                    </div>
                @endif

                <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ request()->is('admin*') ? route('admin.transactions.index') : route('organizer.transactions.index') }}" class="w-full">
                        <x-secondary-button class="w-full justify-center py-2.5">
                            <i class="fa-solid fa-arrow-left mr-2"></i>{{ __('Kembali ke Daftar') }}
                        </x-secondary-button>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>