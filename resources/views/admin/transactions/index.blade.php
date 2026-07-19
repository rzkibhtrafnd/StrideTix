<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <span class="text-slate-700 font-semibold flex items-center">
                <i class="fa-solid fa-receipt mr-2 text-xs text-slate-400"></i>
                {{ request()->is('admin*') ? 'Riwayat Transaksi Global' : 'Riwayat Pendaftaran Event' }}
            </span>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ request()->is('admin*') ? __('Riwayat Transaksi StrideTix') : __('Riwayat Pendaftaran Event Saya') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white border shadow-sm border-slate-200 sm:rounded-lg">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Daftar Invoice & Tiket Masuk') }}</h3>
                <p class="text-sm text-slate-500">
                    {{ request()->is('admin*') ? __('Pantau seluruh alur pembayaran tiket, nomor virtual account, serta singkronisasi status Midtrans.') : __('Pantau data pendaftar kompetisi lari dan total pendapatan pada event yang Anda kelola.') }}
                </p>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="mt-6 p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" action="{{ request()->is('admin*') ? route('admin.transactions.index') : route('organizer.transactions.index') }}" class="w-full flex flex-col sm:flex-row gap-3">
                <div class="w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Invoice / Nama Pemesan..." class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-full sm:w-48">
                    <select name="status" onchange="this.form.submit()" class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="settlement" {{ request('status') == 'settlement' ? 'selected' : '' }}>Settlement (Lunas)</option>
                        <option value="expire" {{ request('status') == 'expire' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <x-primary-button type="submit" class="py-2">
                    <i class="fa-solid fa-filter mr-1.5"></i>{{ __('Filter') }}
                </x-primary-button>
                @if(request('search') || request('status'))
                    <a href="{{ request()->is('admin*') ? route('admin.transactions.index') : route('organizer.transactions.index') }}" class="text-xs text-red-600 font-bold flex items-center px-2 hover:underline">
                        <i class="fa-solid fa-rotate-left mr-1"></i>Reset Filter
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Table Transaksi -->
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="text-sm font-medium text-left text-slate-600">
                        <th class="px-3 py-2" width="60">{{ __('No.') }}</th>
                        <th class="px-3 py-2">{{ __('Invoice / Tanggal') }}</th>
                        <th class="px-3 py-2">{{ __('Pemesan / Pendaftar') }}</th>
                        <th class="px-3 py-2">{{ __('Detail Tiket & Event') }}</th>
                        <th class="px-3 py-2">{{ __('Total Bayar') }}</th>
                        <th class="px-3 py-2 text-center" width="130">{{ __('Status') }}</th>
                        <th class="px-3 py-2 text-center" width="120">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-3 py-3 font-medium text-slate-500">
                                {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-3 py-3">
                                <span class="block font-mono font-bold text-slate-900">{{ $tx->invoice_number }}</span>
                                <span class="text-xs text-slate-400 block mt-0.5">
                                    <i class="fa-regular fa-clock mr-1"></i>{{ $tx->created_at->format('d M Y H:i') }} WIB
                                </span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="block font-semibold text-slate-900">{{ $tx->customer_name ?? 'N/A' }}</span>
                                <span class="text-xs text-slate-500 block mt-0.5">
                                    <i class="fa-solid fa-phone mr-1 text-slate-400"></i>{{ $tx->customer_phone ?? '-' }}
                                </span>
                            </td>
                            <td class="px-3 py-3 space-y-1.5">
                                @foreach($tx->items as $item)
                                    @php $event = $item->ticketTier?->raceCategory?->event; @endphp
                                    <div class="text-xs bg-slate-50 border border-slate-100 rounded-md p-1.5 max-w-xs">
                                        <span class="font-bold text-blue-600 block mb-0.5">[{{ $event->title ?? 'Deleted Event' }}]</span> 
                                        <div class="flex items-center justify-between text-slate-600 font-medium">
                                            <span>{{ $item->ticketTier->raceCategory->category_name }} ({{ $item->ticketTier->tier_name }})</span>
                                            <span class="bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded font-bold">x{{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-3 py-3 font-mono font-bold text-slate-900">
                                Rp{{ number_format($tx->gross_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-center">
                                @if($tx->payment_status === 'settlement')
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Lunas
                                    </span>
                                @elseif($tx->payment_status === 'pending')
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider bg-red-100 text-red-800 border border-red-200">
                                        Expired
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                <a href="{{ route(request()->is('admin*') ? 'admin.transactions.show' : 'organizer.transactions.show', $tx->invoice_number) }}" class="inline-flex items-center text-xs font-medium text-slate-600 bg-slate-50 border border-slate-200 rounded px-2.5 py-1 hover:bg-slate-100 transition-colors">
                                    <i class="mr-1 fa-solid fa-eye"></i>{{ __('Lihat') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-slate-400" colspan="7">{{ __('Belum ada riwayat transaksi terdaftar.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>