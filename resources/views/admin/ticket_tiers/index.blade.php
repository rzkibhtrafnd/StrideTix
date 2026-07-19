<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <span class="text-slate-700 font-semibold flex items-center">
                <i class="fa-solid fa-ticket mr-2 text-xs text-slate-400"></i>Tiering Tiket Lomba
            </span>
        </li>
    </x-slot>

    <div class="p-6 bg-white border shadow-sm border-slate-200 sm:rounded-lg">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Manajemen Tiering Harga Tiket') }}</h3>
                <p class="text-sm text-slate-500">{{ __('Kelola fase penjualan harga tiket (Early Bird, Normal, dll) berdasarkan kategori sub-event.') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.ticket-tiers.create') }}">
                    <x-primary-button><i class="mr-2 fa-solid fa-plus"></i>{{ __('Tambah Tier Tiket') }}</x-primary-button>
                </a>
            </div>
        </div>

        <div class="mt-6 p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" action="{{ route('admin.ticket-tiers.index') }}" class="w-full flex flex-col sm:flex-row gap-3 items-center">
                
                <div class="w-full sm:w-64">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari Nama Tier / Kategori..." class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="w-full sm:w-64">
                    <select name="race_category_id" onchange="this.form.submit()" class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori Kompetisi</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(($filters['race_category_id'] ?? '') == $category->id)>
                                {{ $category->event->title ?? 'N/A' }} - {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-primary-button type="submit" class="py-2">
                    <i class="fa-solid fa-filter mr-1.5"></i>{{ __('Filter') }}
                </x-primary-button>

                @if(!empty($filters['search']) || !empty($filters['race_category_id']))
                    <a href="{{ route('admin.ticket-tiers.index') }}" class="text-xs text-red-600 font-bold flex items-center px-2 hover:underline whitespace-nowrap">
                        <i class="fa-solid fa-rotate-left mr-1"></i>Reset Filter
                    </a>
                @endif
            </form>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="text-sm font-medium text-left text-slate-600">
                        <th class="px-3 py-2">{{ __('No.') }}</th>
                        <th class="px-3 py-2">{{ __('Event / Kategori') }}</th>
                        <th class="px-3 py-2">{{ __('Nama Tier') }}</th>
                        <th class="px-3 py-2 text-right">{{ __('Harga') }}</th>
                        <th class="px-3 py-2 text-center">{{ __('Periode Penjualan') }}</th>
                        <th class="px-3 py-2 text-center">{{ __('Kuota Alokasi') }}</th>
                        <th class="px-3 py-2 text-center" width="150">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                    @forelse($tiers as $tier)
                        <tr>
                            <td class="px-3 py-3">{{ ($tiers->currentPage() - 1) * $tiers->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-3">
                                <div class="font-semibold text-slate-900">{{ $tier->raceCategory->event->title ?? '-' }}</div>
                                <div class="text-xs text-blue-600 font-medium">{{ $tier->raceCategory->category_name }} ({{ $tier->raceCategory->distance_km }}K)</div>
                            </td>
                            <td class="px-3 py-3"><span class="bg-slate-100 border text-slate-700 font-medium px-2 py-0.5 rounded text-xs">{{ $tier->tier_name }}</span></td>
                            <td class="px-3 py-3 text-right font-mono font-bold text-slate-900">Rp {{ number_format($tier->price, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-center text-xs text-slate-600">
                                {{ $tier->start_date->format('d M Y') }} <span class="text-slate-400">s/d</span> {{ $tier->end_date->format('d M Y') }}
                            </td>
                            <td class="px-3 py-3 text-center font-mono font-semibold">{{ $tier->slot_limit }} <span class="text-slate-400 text-xs">Slot</span></td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.ticket-tiers.edit', $tier->id) }}" class="text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 rounded px-2.5 py-1 hover:bg-blue-100">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.ticket-tiers.destroy', $tier->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin? Menghapus akan mengembalikan kuota ke kategori.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 bg-red-50 border border-red-100 rounded px-2.5 py-1 hover:bg-red-100">
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-slate-400" colspan="7">{{ __('Belum ada tingkatan tiket terdaftar.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $tiers->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>