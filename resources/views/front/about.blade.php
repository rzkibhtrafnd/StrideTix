<x-public-layout>
    @slot('title', 'Tentang Kami - StrideTix')

    <!-- Hero Section -->
    <section class="relative pt-24 pb-12 bg-gradient-to-br from-blue-900 via-blue-800 to-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-4">
                Tentang StrideTix
            </h1>
            <p class="text-blue-100 mb-8 max-w-2xl mx-auto text-sm md:text-base">
                Mengenal lebih dekat platform manajemen pendaftaran dan penjualan tiket event lari terbaik di Indonesia.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Baris Pertama: Visi Misi & Komitmen -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">
                
                <!-- Kolom Kiri: Visi Misi (Porsi 7 Kolom) -->
                <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8 space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">Menyediakan Pengalaman War Tiket yang Lancar</h3>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed font-medium">
                        StrideTix hadir sebagai solusi digital terintegrasi khusus untuk komunitas olahraga lari. Dari kategori Fun Run santai sejauh 5K hingga tantangan berat Full Marathon sepanjang 42K, platform kami dirancang tangguh untuk melayani transaksi bervolume tinggi secara *real-time*.
                    </p>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed font-medium">
                        Kami bekerja sama dengan berbagai promotor profesional untuk memberikan kepastian, keamanan, dan transparansi data manifes peserta sejak proses pembelian tiket hingga hari perlombaan.
                    </p>
                </div>

                <!-- Kolom Kanan: Komitmen Layanan (Porsi 5 Kolom) -->
                <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8 space-y-5">
                    <h3 class="text-sm font-black uppercase tracking-wider border-b border-slate-50 pb-3">Komitmen Layanan</h3>
                    <ul class="space-y-4 text-sm font-bold text-slate-700">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                <i class="fa-solid fa-bolt text-blue-600 text-xs"></i>
                            </div>
                            <span class="flex-1 leading-relaxed">Infrastruktur Server Anti-Crash</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                <i class="fa-solid fa-shield-halved text-blue-600 text-xs"></i>
                            </div>
                            <span class="flex-1 leading-relaxed">Proteksi Tiket & QR Validasi</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                <i class="fa-solid fa-users text-blue-600 text-xs"></i>
                            </div>
                            <span class="flex-1 leading-relaxed">Pendataan Manifes Peserta Akurat</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Baris Kedua: Pencapaian 3 Kolom -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg mb-4">
                        <i class="fa-solid fa-person-running"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-900 mb-2">500+ Event Terdaftar</h4>
                    <p class="text-slate-500 text-xs font-medium leading-relaxed">Menjadi mitra terpercaya bagi ratusan kompetisi lari resmi nasional di Indonesia.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg mb-4">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-900 mb-2">80+ Kota Jangkauan</h4>
                    <p class="text-slate-500 text-xs font-medium leading-relaxed">Memudahkan pelari daerah menemukan kompetisi terdekat di wilayah mereka.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg mb-4">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <h4 class="text-base font-bold text-slate-900 mb-2">1M+ Tiket Terjual</h4>
                    <p class="text-slate-500 text-xs font-medium leading-relaxed">Memproses jutaan transaksi tiket digital dengan tingkat keberhasilan tinggi.</p>
                </div>
                
            </div>

        </div>
    </section>
</x-public-layout>