<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.organizers.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i class="fa-solid fa-building-user mr-2 text-xs"></i>Manajemen Penyelenggara
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                <span class="text-slate-400 font-medium">Ubah Profil EO</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Ubah Informasi Korporasi EO') }}
        </h2>
    </x-slot>

    <div class="mx-auto mt-6 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.organizers.update', $organizer->id) }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 mt-6">
                @csrf
                @method('PATCH')
                
                <div class="md:col-span-2">
                    <x-input-label for="user_id" :value="__('Akun Pengguna Terkait')" />
                    <select id="user_id" name="user_id" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm p-2.5 bg-slate-50 cursor-not-allowed" disabled>
                        <option value="{{ $organizer->user_id }}">{{ $organizer->user->name }} ({{ $organizer->user->email }})</option>
                    </select>
                    
                    <input type="hidden" name="user_id" value="{{ $organizer->user_id }}">
                </div>

                <div>
                    <x-input-label for="company_name" :value="__('Nama Perusahaan / Nama Brand EO')" />
                    <x-text-input id="company_name" name="company_name" type="text" class="block w-full mt-1" :value="old('company_name', $organizer->company_name)" required />
                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="logo" :value="__('Perbarui Logo Perusahaan')" />
                    <div class="flex items-center gap-4 mt-2 mb-2">
                        @if($organizer->logo)
                            <img src="{{ asset('storage/' . $organizer->logo) }}" class="w-16 h-16 object-cover rounded-xl border" alt="Logo">
                        @endif
                        <input type="file" id="logo" name="logo" class="block text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer" />
                    </div>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 mt-4 border-t pt-4">
                    <a href="{{ route('admin.organizers.index') }}"><x-secondary-button>{{ __('Batal') }}</x-secondary-button></a>
                    <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>