<x-public-layout>
    <x-slot name="title">Pembayaran - {{ $order->invoice_number }}</x-slot>
    
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <div class="pt-24 pb-16 min-h-screen bg-slate-50 flex flex-col items-center justify-center">
        <div class="max-w-6xl w-full mx-auto px-4">
            
            <div class="flex items-center justify-center gap-4 mb-8 text-sm font-bold text-slate-400">
                <span class="text-emerald-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Pilih Tiket</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-emerald-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Isi Data</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-blue-600 flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-full">
                    <span class="w-5 h-5 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs">3</span> Pembayaran
                </span>
            </div>

            <div class="bg-white border border-slate-200/60 shadow-md rounded-3xl p-6 md:p-8">
                <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3 mb-6">Selesaikan Pembayaran</h3>

                <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-2xl flex items-center justify-between shadow-2xs mb-6"
                    x-data="{
                        expiryTime: new Date('{{ \Carbon\Carbon::parse($order->updated_at)->addMinutes(7)->toIso8601String() }}').getTime(),
                        timeLeft: 0,
                        formatTime() {
                            let m = Math.floor(this.timeLeft / 60);
                            let s = this.timeLeft % 60;
                            return `${m}:${s < 10 ? '0' : ''}${s}`;
                        },
                        init() {
                            setInterval(() => {
                                let now = new Date().getTime();
                                let distance = this.expiryTime - now;
                                if (distance < 0) {
                                    window.location.reload(); 
                                } else {
                                    this.timeLeft = Math.floor(distance / 1000);
                                }
                            }, 1000);
                        }
                    }">
                    <div class="flex items-center gap-2.5 text-xs font-semibold">
                        <i class="fa-solid fa-stopwatch text-base text-amber-600 animate-pulse"></i>
                        <span>Batas Waktu Pembayaran:</span>
                    </div>
                    <div class="font-mono font-black text-lg text-amber-700 bg-white px-3 py-1 rounded-xl border border-amber-200" x-text="formatTime()">
                        07:00
                    </div>
                </div>

                <div class="space-y-4 text-sm text-slate-600 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-slate-500">Nomor Invoice</span>
                        <span class="font-mono font-bold text-slate-800">{{ $order->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                        <span class="font-semibold text-slate-600">Total Harga</span>
                        <span class="text-2xl font-black text-blue-600 font-mono">Rp{{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <x-primary-button 
                    id="pay-button" 
                    type="button" 
                    class="w-full !py-3 !rounded-xl justify-center gap-2 text-xs font-bold shadow-md">
                    <i class="fa-solid fa-credit-card"></i> Pilih Metode Pembayaran
                </x-primary-button>
                
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = "{{ route('front.checkout.success', $order->invoice_number) }}";
                },
                onPending: function (result) {
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function (result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function () {
                    console.log('User menutup popup tanpa membayar');
                }
            });
        };
    </script>
</x-public-layout>