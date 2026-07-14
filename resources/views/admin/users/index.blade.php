<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <span class="text-slate-700 font-semibold flex items-center">
                <i class="fa-solid fa-users mr-2 text-xs text-slate-400"></i>Kelola Pengguna
            </span>
        </li>
    </x-slot>
    
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelola Pengguna Sistem') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white border shadow-sm border-slate-200 sm:rounded-lg">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Daftar Pengguna StrideTix') }}</h3>
                <p class="text-sm text-slate-500">{{ __('Kelola akun pengguna, hak akses admin utama, dan operator organizer event.') }}</p>
            </div>

            <div>
                <a href="{{ route('admin.users.create') }}">
                    <x-primary-button><i class="mr-2 fa-solid fa-user-plus"></i>{{ __('Tambah User Baru') }}</x-primary-button>
                </a>
            </div>
        </div>
        
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="text-sm font-medium text-left text-slate-600">
                        <th class="px-3 py-2">{{ __('No.') }}</th>
                        <th class="px-3 py-2">{{ __('Nama Pengguna') }}</th>
                        <th class="px-3 py-2">{{ __('Email') }}</th>
                        <th class="px-3 py-2">{{ __('Nomor Telepon') }}</th>
                        <th class="px-3 py-2 text-center" width="180">{{ __('Hak Akses (Role)') }}</th>
                        <th class="px-3 py-2 text-center" width="180">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-3 py-3">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-3 font-semibold text-slate-900">{{ $user->name }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $user->email }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $user->phone }}</td>
                            <td class="px-3 py-3 text-center">
                                <span class="inline-block px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider {{ $user->role->badgeClass() }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 rounded px-2.5 py-1 hover:bg-blue-100 focus:outline-none transition-colors">
                                        <i class="mr-1 fa-solid fa-pen"></i>{{ __('Edit') }}
                                    </a>

                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus user ini?') }}');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center text-xs font-medium text-red-600 bg-red-50 border border-red-100 rounded px-2.5 py-1 hover:bg-red-100 focus:outline-none transition-colors">
                                                <i class="mr-1 fa-solid fa-trash"></i>{{ __('Hapus') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-slate-400" colspan="6">{{ __('Belum ada pengguna sistem terdaftar.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>