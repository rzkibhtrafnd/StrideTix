<x-app-layout>
    <x-slot name="breadcrumbs">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.events.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i class="fa-solid fa-person-running mr-2 text-xs"></i>Manajemen Event Lari
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 mx-2"></i>
                <span class="text-slate-400 font-medium">Ubah Detail Event</span>
            </div>
        </li>
    </x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Ubah Informasi Perlombaan') }}
        </h2>
    </x-slot>

    <div class="mx-auto mt-6 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.events.update', $event->id) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @csrf
                @method('PATCH')
                
                <div class="md:col-span-2">
                    <x-input-label for="organizer_id" :value="__('Penyelenggara Penanggung Jawab')" />
                    <select id="organizer_id" name="organizer_id" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm p-2.5 cursor-pointer">
                        @foreach($organizers as $org)
                            <option value="{{ $org->id }}" @selected(old('organizer_id', $event->organizer_id) == $org->id)>{{ $org->company_name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('organizer_id')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="title" :value="__('Nama Lengkap Event Lari')" />
                    <x-text-input id="title" name="title" type="text" class="block w-full mt-1" :value="old('title', $event->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="description" :value="__('Deskripsi & Ketentuan Aturan Lomba')" />
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm" required>{{ old('description', $event->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="location" :value="__('Nama Lokasi (Venue Start)')" />
                    <x-text-input id="location" name="location" type="text" class="block w-full mt-1" :value="old('location', $event->location)" required />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="google_maps_url" :value="__('Sematkan Tautan Google Maps (URL)')" />
                    <x-text-input id="google_maps_url" name="google_maps_url" type="text" class="block w-full mt-1" :value="old('google_maps_url', $event->google_maps_url)" />
                    <x-input-error :messages="$errors->get('google_maps_url')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="event_date" :value="__('Tanggal & Waktu Flag-Off')" />
                    <x-text-input id="event_date" name="event_date" type="date" class="block w-full mt-1" 
                        :value="old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '')" required />
                    <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" :value="__('Status Urgensi Event')" />
                    <select id="status" name="status" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm p-2.5 cursor-pointer">
                        @foreach(\App\Enums\EventStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $event->status->value) == $status->value)>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 mt-4 md:col-span-2 border-t pt-4">
                    <a href="{{ route('admin.events.index') }}"><x-secondary-button>{{ __('Batal') }}</x-secondary-button></a>
                    <x-primary-button>{{ __('Perbarui Data') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>