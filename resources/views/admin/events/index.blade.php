<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <span class="text-slate-700 font-semibold flex items-center">
                <i class="fa-solid fa-person-running mr-2 text-xs text-slate-400"></i>Manajemen Event Lari
            </span>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelola Event StrideTix') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white border shadow-sm border-slate-200 sm:rounded-lg">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Daftar Kompetisi Lari') }}</h3>
                <p class="text-sm text-slate-500">{{ __('Pantau status publikasi jadwal marathon, manajemen lokasi rute, dan penyelenggara.') }}</p>
            </div>

            <div>
                <a href="{{ route('admin.events.create') }}">
                    <x-primary-button><i class="mr-2 fa-solid fa-calendar-plus"></i>{{ __('Buat Event Baru') }}</x-primary-button>
                </a>
            </div>
        </div>

        <div class="mt-6 p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" action="{{ route('admin.events.index') }}" class="w-full flex flex-col sm:flex-row flex-wrap gap-3 items-center">
                
                <!-- Input Pencarian -->
                <div class="w-full sm:w-64">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari Nama Event / Rute..." class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Dropdown Provinsi -->
                <div class="w-full sm:w-48">
                    <select id="province_filter" name="province_id" class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Provinsi</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov['id'] }}" @selected(($filters['province_id'] ?? '') == $prov['id'])>{{ $prov['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Kabupaten (Tetap sinkron dengan JavaScript select wilayah) -->
                <div class="w-full sm:w-48">
                    <select id="regency_filter" name="regency_id" disabled class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50">
                        <option value="">Pilih Kota...</option>
                    </select>
                </div>

                <!-- Tombol Submit -->
                <x-primary-button type="submit" class="py-2">
                    <i class="fa-solid fa-filter mr-1.5"></i>{{ __('Filter') }}
                </x-primary-button>

                <!-- Link Reset -->
                @if(!empty($filters['search']) || !empty($filters['province_id']) || !empty($filters['regency_id']))
                    <a href="{{ route('admin.events.index') }}" class="text-xs text-red-600 font-bold flex items-center px-2 hover:underline">
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
                        <th class="px-3 py-2">{{ __('Nama Event') }}</th>
                        <th class="px-3 py-2">{{ __('Penyelenggara') }}</th>
                        <th class="px-3 py-2">{{ __('Jadwal Pelaksanaan') }}</th>
                        <th class="px-3 py-2 text-center" width="130">{{ __('Status') }}</th>
                        <th class="px-3 py-2 text-center" width="180">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                    @forelse($events as $event)
                        <tr>
                            <td class="px-3 py-3">{{ ($events->currentPage() - 1) * $events->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-3">
                                <span class="block font-semibold text-slate-900">{{ $event->title }}</span>
                                
                                <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 text-xs text-slate-400 font-normal mt-1">
                                    <span class="inline-flex items-center mt-0.5">
                                        <i class="fa-solid fa-map mr-1 text-slate-400"></i>{{ $event->province_name ?? '-' }} (ID: {{ $event->province_id ?? '-' }})
                                    </span>
                                    <span class="inline-flex items-center mt-0.5">
                                        <i class="fa-solid fa-city mr-1 text-slate-400"></i>{{ $event->regency_name ?? '-' }} (ID: {{ $event->regency_id ?? '-' }})
                                    </span>
                                    <span class="inline-flex items-center mt-0.5">
                                        <i class="fa-solid fa-location-dot mr-1 text-slate-400"></i>{{ $event->location }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-slate-600">{{ $event->organizer->company_name ?? 'Tidak Terikat' }}</td>
                            <td class="px-3 py-3 text-slate-600 font-mono">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}</td>
                            <td class="px-3 py-3 text-center">
                                <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider {{ $event->status->badgeClass() }}">
                                    {{ $event->status->label() }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="inline-flex items-center text-xs font-medium text-slate-600 bg-slate-50 border border-slate-200 rounded px-2.5 py-1 hover:bg-slate-100 transition-colors">
                                        <i class="mr-1 fa-solid fa-eye"></i>{{ __('Lihat') }}
                                    </a>

                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 rounded px-2.5 py-1 hover:bg-blue-100 transition-colors">
                                        <i class="mr-1 fa-solid fa-pen"></i>{{ __('Edit') }}
                                    </a>

                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus event kompetisi lari ini?') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-xs font-medium text-red-600 bg-red-50 border border-red-100 rounded px-2.5 py-1 hover:bg-red-100 focus:outline-none transition-colors">
                                            <i class="mr-1 fa-solid fa-trash"></i>{{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-slate-400" colspan="6">
                                @if(request()->anyFilled(['search', 'province_id', 'regency_id']))
                                    {{ __('Tidak ditemukan event lari yang cocok dengan kriteria filter Anda.') }}
                                @else
                                    {{ __('Belum ada agenda kompetisi lari terdaftar.') }}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>