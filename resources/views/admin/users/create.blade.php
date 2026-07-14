<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i class="fa-solid fa-users mr-2 text-xs"></i>Kelola Pengguna
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                <span class="text-slate-400 font-medium">Tambah User</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="mx-auto mt-6 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-slate-900">{{ __('User Baru') }}</h3>
            <p class="text-sm text-slate-500">{{ __('Lengkapi data kredensial akses pengguna operasional platform StrideTix.') }}</p>

            <form method="POST" action="{{ route('admin.users.store') }}" class="grid grid-cols-1 gap-4 mt-6 md:grid-cols-2">
                @csrf
                
                <div class="md:col-span-2">
                    <x-input-label for="name" :value="__('Nama Lengkap / Nama Platform EO')" />
                    <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Alamat Email')" />
                    <x-text-input id="email" name="email" type="email" class="block w-full mt-1" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone" :value="__('Nomor Telepon')" />
                    <x-text-input id="phone" name="phone" type="text" class="block w-full mt-1" :value="old('phone')" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="role" :value="__('Hak Akses (Role)')" />
                    <select id="role" name="role" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm p-2.5 cursor-pointer">
                        @foreach(\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}" @selected(old('role') == $role->value)>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="pt-4 mt-2 border-t md:col-span-2">
                    <h4 class="mb-3 text-sm font-bold text-slate-700">{{ __('Konfigurasi Keamanan Kredensial') }}</h4>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="block w-full mt-1" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" required />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-4 md:col-span-2">
                    <a href="{{ route('admin.users.index') }}"><x-secondary-button>{{ __('Batal') }}</x-secondary-button></a>
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>