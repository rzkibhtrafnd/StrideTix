<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <span class="text-slate-700 font-semibold flex items-center">
                <i class="fa-solid fa-building-user mr-2 text-xs text-slate-400"></i>Manajemen Penyelenggara
            </span>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelola Profil Organizer') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white border shadow-sm border-slate-200 sm:rounded-lg">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Daftar Institusi/EO') }}</h3>
                <p class="text-sm text-slate-500">{{ __('Kelola kelengkapan data korporasi penyelenggara event lari di bawah platform StrideTix.') }}</p>
            </div>

            <div>
                <a href="{{ route('admin.organizers.create') }}">
                    <x-primary-button><i class="mr-2 fa-solid fa-plus"></i>{{ __('Daftarkan Profil EO') }}</x-primary-button>
                </a>
            </div>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="text-sm font-medium text-left text-slate-600">
                        <th class="px-3 py-2" width="60">{{ __('No.') }}</th>
                        <th class="px-3 py-2" width="80">{{ __('Logo') }}</th>
                        <th class="px-3 py-2">{{ __('Nama Perusahaan/EO') }}</th>
                        <th class="px-3 py-2">{{ __('Akun Terautentikasi') }}</th>
                        <th class="px-3 py-2 text-center" width="220">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                    @forelse($organizers as $org)
                        <tr>
                            <td class="px-3 py-3">{{ ($organizers->currentPage() - 1) * $organizers->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-3">
                                @if($org->logo)
                                    <img src="{{ asset('storage/' . $org->logo) }}" class="w-10 h-10 object-cover rounded-lg border border-slate-100 shadow-sm" alt="Logo">
                                @else
                                    <div class="w-10 h-10 bg-slate-100 text-slate-400 rounded-lg flex items-center justify-center border border-slate-100">
                                        <i class="fa-solid fa-image text-xs"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-3 font-semibold text-slate-900">{{ $org->company_name }}</td>
                            <td class="px-3 py-3 text-slate-600">
                                {{ $org->user->name ?? '-' }}
                                <span class="block text-xs text-slate-400 font-mono mt-0.5">{{ $org->user->email ?? '' }}</span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.organizers.show', $org->id) }}" class="inline-flex items-center text-xs font-medium text-slate-600 bg-slate-50 border border-slate-200 rounded px-2.5 py-1 hover:bg-slate-100 transition-colors">
                                        <i class="mr-1 fa-solid fa-eye"></i>{{ __('Detail') }}
                                    </a>
                                    <a href="{{ route('admin.organizers.edit', $org->id) }}" class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 rounded px-2.5 py-1 hover:bg-blue-100 transition-colors">
                                        <i class="mr-1 fa-solid fa-pen"></i>{{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.organizers.destroy', $org->id) }}" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus profil institusi ini?') }}');" class="inline">
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
                            <td class="px-3 py-6 text-center text-slate-400" colspan="5">{{ __('Belum ada profil perusahaan EO terdaftar.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $organizers->links() }}
        </div>
    </div>
</x-app-layout>