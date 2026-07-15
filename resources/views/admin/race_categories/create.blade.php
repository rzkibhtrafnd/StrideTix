<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.race-categories.index') }}" class="hover:text-blue-600 text-slate-500 transition-colors flex items-center">
                <i class="fa-solid fa-tags mr-2 text-xs"></i>Kategori Tiket
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                <span class="text-slate-400 font-medium">Buat Kategori</span>
            </div>
        </li>
    </x-slot>

    <div class="mx-auto mt-6 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-slate-900">{{ __('Tambah Kategori Balapan Baru') }}</h3>
            <p class="text-sm text-slate-500">{{ __('Alokasikan kuota ketersediaan tiket pendaftaran sesuai sub-kategori lomba.') }}</p>

            <form method="POST" action="{{ route('admin.race-categories.store') }}" class="space-y-4 mt-6">
                @csrf
                
                <div>
                    <x-input-label for="event_id" :value="__('Hubungkan ke Event Utama')" />
                    <select id="event_id" name="event_id" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm p-2.5 cursor-pointer">
                        <option value="">-- Pilih Kompetisi Lari --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('event_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="category_name" :value="__('Nama Kategori Lomba')" />
                    <x-text-input id="category_name" name="category_name" type="text" class="block w-full mt-1" :value="old('category_name')" placeholder="Contoh: 10K Open, Half Marathon, Full Marathon Master" required />
                    <x-input-error :messages="$errors->get('category_name')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="distance_km" :value="__('Jarak Trek Lintasan (KM)')" />
                        <x-text-input id="distance_km" name="distance_km" type="text" class="block w-full mt-1" :value="old('distance_km')" placeholder="Contoh: 5, 10, 21, atau 42.195" required />
                        <x-input-error :messages="$errors->get('distance_km')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="total_slot" :value="__('Total Kuota Tiket / Slot')" />
                        <x-text-input id="total_slot" name="total_slot" type="number" class="block w-full mt-1" :value="old('total_slot')" placeholder="Contoh: 500" required />
                        <x-input-error :messages="$errors->get('total_slot')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 border-t pt-4">
                    <a href="{{ route('admin.race-categories.index') }}"><x-secondary-button>{{ __('Batal') }}</x-secondary-button></a>
                    <x-primary-button>{{ __('Simpan Kategori') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>