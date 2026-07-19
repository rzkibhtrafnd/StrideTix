<x-public-layout>
    @slot('title', 'Hubungi Kami - StrideTix')

    <!-- Hero Section -->
    <section class="relative pt-24 pb-12 bg-gradient-to-br from-blue-900 via-blue-800 to-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-4">
                Pusat Hubungan Kami
            </h1>
            <p class="text-blue-100 mb-8 max-w-2xl mx-auto text-sm md:text-base">
                Punya kendala validasi e-tiket atau berminat mendaftarkan ajang perlombaan lari Anda di StrideTix?
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid 3 Kolom untuk Proporsi 1:2 yang Lebih Stabil -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
                
                <!-- Sisi Kiri: Informasi Kontak (Satu Kartu Gabungan) -->
                <div class="lg:col-span-1 space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Hubungi Langsung</h2>
                        <p class="text-slate-500 text-sm mt-1">
                            Gunakan jalur cepat di bawah ini untuk terhubung langsung dengan tim kami.
                        </p>
                    </div>

                    <!-- Single Combined Card -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col gap-6 shadow-sm">
                        <!-- Bagian 1: Bantuan Layanan Pembeli -->
                        <div class="space-y-3">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Bantuan Layanan Pembeli</h3>
                                <p class="text-slate-500 text-xs font-medium mt-1">Urusan kendala e-tiket salah nama / gagal bayar.</p>
                            </div>
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-3 self-start group">
                                <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors shrink-0">
                                    <i class="fa-brands fa-whatsapp text-base"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">+62 812-3456-7890</span>
                            </a>
                        </div>

                        <!-- Garis Pembatas Antar Kontak -->
                        <div class="border-t border-slate-100"></div>

                        <!-- Bagian 2: Kerjasama Kemitraan (Warna disesuaikan untuk kartu putih) -->
                        <div class="space-y-3">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Kerjasama Kemitraan</h3>
                                <p class="text-slate-500 text-xs font-medium mt-1">Integrasi sistem penjualan kuota tiket promotor.</p>
                            </div>
                            <a href="mailto:partnership@stridetix.id" class="inline-flex items-center gap-3 self-start group">
                                <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-sm group-hover:bg-blue-600 group-hover:text-white transition-colors shrink-0">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">partnership@stridetix.id</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Form Card (Porsi 2 Kolom) -->
                <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm p-6 md:p-8 space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Kirim Pesan Bantuan</h2>
                        <p class="text-slate-500 text-sm mt-1">
                            Pilih jenis bantuan resmi untuk respon cepat berdurasi 1x24 jam.
                        </p>
                    </div>

                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Input Kapsul -->
                            <div class="flex items-center px-4 py-2.5 bg-white border border-slate-300 rounded-full shadow-sm">
                                <i class="fa-solid fa-user text-slate-400 text-xs mr-2"></i>
                                <input type="text" name="name" required placeholder="Nama lengkap..." class="w-full border-none focus:ring-0 text-xs font-medium text-slate-700 bg-transparent placeholder-slate-400 p-0">
                            </div>

                            <div class="flex items-center px-4 py-2.5 bg-white border border-slate-300 rounded-full shadow-sm">
                                <i class="fa-solid fa-envelope text-slate-400 text-xs mr-2"></i>
                                <input type="email" name="email" required placeholder="Alamat email..." class="w-full border-none focus:ring-0 text-xs font-medium text-slate-700 bg-transparent placeholder-slate-400 p-0">
                            </div>
                        </div>

                        <!-- Dropdown Kategori Kapsul -->
                        <div class="flex items-center px-4 py-2.5 bg-white border border-slate-300 rounded-full shadow-sm">
                            <i class="fa-solid fa-circle-info text-slate-400 text-xs mr-2"></i>
                            <select name="category" class="w-full border-none focus:ring-0 text-xs font-bold text-slate-600 bg-transparent p-0 outline-none">
                                <option>Kendala E-Ticket / Pembayaran</option>
                                <option>Kemitraan Penyelenggara Event</option>
                                <option>Pertanyaan Umum</option>
                            </select>
                        </div>

                        <!-- Textarea Kotak -->
                        <div class="bg-white border border-slate-300 rounded-2xl shadow-sm p-3">
                            <textarea name="message" rows="5" required placeholder="Tuliskan rincian keluhan atau detail pesan Anda di sini..." class="w-full border-none focus:ring-0 text-xs font-medium text-slate-700 bg-transparent placeholder-slate-400 p-0 resize-none outline-none"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white rounded-full px-8 py-2.5 text-xs font-bold transition shadow-sm">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</x-public-layout>