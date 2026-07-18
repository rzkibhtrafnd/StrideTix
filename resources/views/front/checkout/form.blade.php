<x-public-layout>
    <x-slot name="title">Isi Data Diri - {{ $event->title }}</x-slot>

    <div class="pt-24 pb-16 min-h-screen bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 rounded-xl border border-red-200 shadow-sm">
                    <h4 class="text-sm font-bold text-red-600 flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-triangle-exclamation"></i> Gagal Melanjutkan Pendaftaran
                    </h4>
                    <ul class="list-disc list-inside text-xs text-red-500 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex items-center justify-center gap-4 mb-8 text-sm font-bold text-slate-400">
                <span class="text-emerald-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Pilih Tiket</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-blue-600 flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-full">
                    <span class="w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs">2</span> Isi Data Pemesan
                </span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="flex items-center gap-2">
                    <span class="w-5 h-5 bg-slate-300 text-slate-600 rounded-full flex items-center justify-center text-xs">3</span> Pembayaran
                </span>
            </div>

            <form method="POST" action="{{ route('front.checkout.store', $order->invoice_number) }}" 
                class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start"
                x-data="{
                    timeLeft: {{ $secondsLeft }},
                    formatTime() {
                        let minutes = Math.floor(this.timeLeft / 60);
                        let seconds = this.timeLeft % 60;
                        return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    },
                    init() {
                        setInterval(() => {
                            if (this.timeLeft > 0) {
                                this.timeLeft--;
                            } else {
                                window.location.href = '{{ route('front.checkout.ticket', $event->id) }}';
                            }
                        }, 1000);
                    }
                }">
                @csrf

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-2xl flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5 text-xs font-semibold">
                            <i class="fa-solid fa-stopwatch text-base text-amber-600 animate-pulse"></i>
                            <span>Selesaikan pengisian form sebelum slot dilepas kembali:</span>
                        </div>
                        <div class="font-mono font-black text-lg text-amber-700 bg-white px-3 py-1 rounded-xl border border-amber-200" x-text="formatTime()">
                            10:00
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-xs">
                        <h3 class="text-lg font-black text-slate-900 mb-1">Informasi Kontak Pemesan</h3>
                        <p class="text-xs text-slate-500 mb-6">E-ticket beserta invoice akan dikirimkan ke kontak utama di bawah ini.</p>

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="customer_name" :value="__('Nama Lengkap Pemesan')" />
                                <x-text-input id="customer_name" name="customer_name" type="text" class="block w-full mt-1.5 text-sm" value="{{ old('customer_name') }}" required />
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="customer_email" :value="__('Alamat Email')" />
                                    <x-text-input id="customer_email" name="customer_email" type="email" class="block w-full mt-1.5 text-sm" value="{{ old('customer_email') }}" required />
                                </div>
                                <div>
                                    <x-input-label for="customer_phone" :value="__('Nomor WhatsApp')" />
                                    <x-text-input id="customer_phone" name="customer_phone" type="text" class="block w-full mt-1.5 text-sm" placeholder="Contoh: 081234567" value="{{ old('customer_phone') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    @php $pIndex = 0; @endphp
                    @foreach($order->items as $item)
                        @for($i = 1; $i <= $item->quantity; $i++)
                            <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-xs relative overflow-hidden">
                                <div class="absolute top-0 left-0 bg-blue-600 text-white font-mono font-black px-4 py-1 text-[11px] rounded-br-2xl">
                                    PELARI #{{ $pIndex + 1 }}
                                </div>
                                
                                <h3 class="text-base font-black text-slate-900 mb-1 mt-3">
                                    Kategori: {{ $item->ticketTier->raceCategory->category_name }} ({{ $item->ticketTier->tier_name }})
                                </h3>
                                <p class="text-xs text-slate-400 mb-6">Harap isi biodata pelari sesuai tanda pengenal resmi.</p>

                                <div class="space-y-4">
                                    <div>
                                        <x-input-label value="Nama Lengkap Pelari (Sesuai KTP/Paspor)" />
                                        <x-text-input name="participants[{{ $pIndex }}][full_name]" type="text" class="block w-full mt-1.5 text-sm" value="{{ old('participants.' . $pIndex . '.full_name') }}" required />
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label value="Jenis Kelamin" />
                                            <select name="participants[{{ $pIndex }}][gender]" class="w-full mt-1.5 rounded-lg text-sm border-slate-300 shadow-2xs focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="{{ \App\Enums\Gender::MALE->value }}" {{ old("participants.$pIndex.gender") == \App\Enums\Gender::MALE->value ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="{{ \App\Enums\Gender::FEMALE->value }}" {{ old("participants.$pIndex.gender") == \App\Enums\Gender::FEMALE->value ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label value="Tanggal Lahir" />
                                            <x-text-input name="participants[{{ $pIndex }}][date_of_birth]" type="date" class="block w-full mt-1.5 text-sm" value="{{ old('participants.' . $pIndex . '.date_of_birth') }}" required />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label value="Jenis Identitas" />
                                            <select name="participants[{{ $pIndex }}][identity_type]" class="w-full mt-1.5 rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="{{ \App\Enums\IdentityType::KTP->value }}" {{ old("participants.$pIndex.identity_type") == \App\Enums\IdentityType::KTP->value ? 'selected' : '' }}>KTP</option>
                                                <option value="{{ \App\Enums\IdentityType::PASPOR->value }}" {{ old("participants.$pIndex.identity_type") == \App\Enums\IdentityType::PASPOR->value ? 'selected' : '' }}>PASPOR</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label value="Nomor Identitas" />
                                            <x-text-input name="participants[{{ $pIndex }}][identity_number]" type="text" class="block w-full mt-1.5 text-sm" value="{{ old('participants.' . $pIndex . '.identity_number') }}" required />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label value="Golongan Darah" />
                                            <select name="participants[{{ $pIndex }}][blood_type]" class="w-full mt-1.5 rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500" required>
                                                @foreach(['A', 'B', 'AB', 'O'] as $blood)
                                                    <option value="{{ $blood }}" {{ old("participants.$pIndex.blood_type") == $blood ? 'selected' : '' }}>{{ $blood }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label value="Ukuran Jersey" />
                                            <select name="participants[{{ $pIndex }}][jersey_size]" class="w-full mt-1.5 rounded-lg text-sm border-slate-300 focus:ring-blue-500 focus:border-blue-500" required>
                                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                                    <option value="{{ $size }}" {{ old("participants.$pIndex.jersey_size") == $size ? 'selected' : '' }}>{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-2xl mt-4 space-y-3">
                                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2 flex items-center gap-1.5">
                                            <i class="fa-solid fa-circle-exclamation text-amber-500"></i> Kontak Darurat Pelari
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <x-input-label value="Nama Kontak" />
                                                <x-text-input name="participants[{{ $pIndex }}][emergency_contact_name]" type="text" class="block w-full mt-1 text-sm" value="{{ old('participants.' . $pIndex . '.emergency_contact_name') }}" required />
                                            </div>
                                            <div>
                                                <x-input-label value="No. Telepon" />
                                                <x-text-input name="participants[{{ $pIndex }}][emergency_contact_phone]" type="text" class="block w-full mt-1 text-sm" placeholder="08xxxx" value="{{ old('participants.' . $pIndex . '.emergency_contact_phone') }}" required />
                                            </div>
                                            <div>
                                                <x-input-label value="Hubungan" />
                                                <x-text-input name="participants[{{ $pIndex }}][emergency_relation]" type="text" class="block w-full mt-1 text-sm" placeholder="Misal: Ibu, Ayah" value="{{ old('participants.' . $pIndex . '.emergency_relation') }}" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $pIndex++; @endphp
                        @endfor
                    @endforeach
                </div>

                <div class="lg:col-span-1 lg:sticky lg:top-24">
                    <div class="bg-white border border-slate-200/60 shadow-md rounded-3xl p-6">
                        <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 mb-4">Total Pembayaran</h3>
                        
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-sm font-semibold text-slate-600">Total Harga</span>
                            <span class="text-xl font-black text-blue-600 font-mono">Rp{{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                        </div>

                        <x-primary-button 
                            type="submit" 
                            class="w-full !py-3 !rounded-xl justify-center gap-2 text-xs font-bold">
                            <i class="fa-solid fa-shield-halved"></i> Konfirmasi & Bayar
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>