<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.ticket-tiers.index') }}" class="hover:text-blue-600 text-slate-500 flex items-center">
                <i class="fa-solid fa-ticket mr-2 text-xs"></i>Tiering Tiket
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                <span class="text-slate-400 font-medium">Ubah Tier</span>
            </div>
        </li>
    </x-slot>

    <div class="mx-auto mt-6 bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-slate-900">{{ __('Ubah Konfigurasi Tingkatan Tiket') }}</h3>
            <p class="text-sm text-slate-500">{{ __('Perbarui harga, masa aktif, atau batas limit alokasi kuota penjualan.') }}</p>

            <form method="POST" action="{{ route('admin.ticket-tiers.update', $ticketTier->id) }}" class="space-y-4 mt-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <x-input-label for="race_category_id" :value="__('Kaitan Kategori Kompetisi Lari')" />
                    <select id="race_category_id" name="race_category_id" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm p-2.5 cursor-pointer">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('race_category_id', $ticketTier->race_category_id) == $cat->id)>
                                {{ $cat->event->title ?? '-' }} | {{ $cat->category_name }} (Sisa Slot Kategori: {{ $cat->available_slot }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('race_category_id')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="tier_name" :value="__('Nama Tingkatan (Tier Name)')" />
                        <x-text-input id="tier_name" name="tier_name" type="text" class="block w-full mt-1" :value="old('tier_name', $ticketTier->tier_name)" required />
                        <x-input-error :messages="$errors->get('tier_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="price" :value="__('Nominal Harga Tiket (Rupiah)')" />
                        <x-text-input id="price" name="price" type="number" class="block w-full mt-1" :value="old('price', $ticketTier->price)" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label for="start_date" :value="__('Tanggal Pembukaan Penjualan')" />
                        <x-text-input id="start_date" name="start_date" type="date" class="block w-full mt-1" 
                            :value="old('start_date', $ticketTier->start_date ? $ticketTier->start_date->format('Y-m-d') : '')" required />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="end_date" :value="__('Tanggal Penutupan Penjualan')" />
                        <x-text-input id="end_date" name="end_date" type="date" class="block w-full mt-1" 
                            :value="old('end_date', $ticketTier->end_date ? $ticketTier->end_date->format('Y-m-d') : '')" required />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="slot_limit" :value="__('Batas Kuota Slot Tiket')" />
                    <x-text-input id="slot_limit" name="slot_limit" type="number" class="block w-full mt-1" :value="old('slot_limit', $ticketTier->slot_limit)" required />
                    <x-input-error :messages="$errors->get('slot_limit')" class="mt-2" />
                </div>

                <div class="p-4 border bg-amber-50/60 border-amber-100 rounded-xl flex items-start gap-2.5 text-xs text-amber-700">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                    <div>
                        <span class="font-bold">Informasi Batasan Slot:</span> Menambah kuota alokasi slot tier akan langsung memotong sisa kuota aktif milik kategori balapan, begitu juga sebaliknya jika Anda menurunkannya.
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 border-t pt-4">
                    <a href="{{ route('admin.ticket-tiers.index') }}"><x-secondary-button>{{ __('Batal') }}</x-secondary-button></a>
                    <x-primary-button>{{ __('Perbarui Konfigurasi') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>