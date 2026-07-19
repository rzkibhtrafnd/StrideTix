<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <span class="text-slate-700 font-semibold flex items-center">
                <i class="fa-solid fa-tags mr-2 text-xs text-slate-400"></i>Kategori Tiket Balapan
            </span>
        </li>
    </x-slot>
    
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelola Kategori & Slot Lomba') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white border shadow-sm border-slate-200 sm:rounded-lg">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Daftar Sub-Kategori Lari') }}</h3>
                <p class="text-sm text-slate-500">{{ __('Tentukan variasi jarak tempuh lintasan dan alokasi batas kuota tiket untuk setiap event StrideTix.') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.race-categories.create') }}">
                    <x-primary-button><i class="mr-2 fa-solid fa-plus"></i>{{ __('Tambah Kategori Baru') }}</x-primary-button>
                </a>
            </div>
        </div>

        <div class="mt-6 p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" action="{{ route('admin.race-categories.index') }}" class="w-full flex flex-col sm:flex-row gap-3 items-center">
                
                <div class="w-full sm:w-64">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari Kategori / Event..." class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="w-full sm:w-64">
                    <select name="event_id" onchange="this.form.submit()" class="w-full rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kompetisi/Event</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" @selected(($filters['event_id'] ?? '') == $event->id)>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-primary-button type="submit" class="py-2">
                    <i class="fa-solid fa-filter mr-1.5"></i>{{ __('Filter') }}
                </x-primary-button>

                @if(!empty($filters['search']) || !empty($filters['event_id']))
                    <a href="{{ route('admin.race-categories.index') }}" class="text-xs text-red-600 font-bold flex items-center px-2 hover:underline whitespace-nowrap">
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
                        <th class="px-3 py-2">{{ __('Event Utama') }}</th>
                        <th class="px-3 py-2">{{ __('Kategori') }}</th>
                        <th class="px-3 py-2 text-center">{{ __('Jarak') }}</th>
                        <th class="px-3 py-2 text-center">{{ __('Sisa Slot / Total Kuota') }}</th>
                        <th class="px-3 py-2 text-center" width="180">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                    @forelse($categories as $category)
                        <tr>
                            <td class="px-3 py-3">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-3 font-medium text-slate-900">{{ $category->event->title ?? '-' }}</td>
                            <td class="px-3 py-3"><span class="font-bold text-blue-600 bg-blue-50/60 px-2 py-1 rounded">{{ $category->category_name }}</span></td>
                            <td class="px-3 py-3 text-center font-mono font-bold text-slate-700">{{ $category->distance_km }} KM</td>
                            <td class="px-3 py-3 text-center">
                                <span class="text-emerald-600 font-bold">{{ $category->available_slot }}</span> 
                                <span class="text-slate-400">/ {{ $category->total_slot }}</span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.race-categories.edit', $category->id) }}" class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 rounded px-2.5 py-1 hover:bg-blue-100 transition-colors">
                                        <i class="mr-1 fa-solid fa-pen"></i>{{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.race-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori lomba ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-xs font-medium text-red-600 bg-red-50 border border-red-100 rounded px-2.5 py-1 hover:bg-red-100 transition-colors">
                                            <i class="mr-1 fa-solid fa-trash"></i>{{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-slate-400" colspan="6">{{ __('Belum ada data kategori balapan yang terdaftar.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>