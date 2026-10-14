<footer class="bg-slate-900 text-slate-300 mt-20 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Kolom Profil -->
            <div class="md:col-span-1 space-y-4">
                <div class="flex items-center space-x-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold text-sm">
                        PN
                    </span>
                    <span class="font-bold text-lg text-white">
                        Pojok<span class="text-emerald-400">Ngadiluwih</span>
                    </span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Portal Informasi Digital, Layanan Masyarakat, dan Katalog UMKM Desa Ngadiluwih, Kecamatan Ngadiluwih, Kabupaten Kediri, Jawa Timur.
                </p>
            </div>

            <!-- Tautan Cepat -->
            <div>
                <h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-3">Tautan Cepat</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda Utama</a></li>
                    <li><a href="{{ route('profile') }}" class="hover:text-emerald-400 transition">Profil & Struktur Desa</a></li>
                    <li><a href="{{ route('news.index') }}" class="hover:text-emerald-400 transition">Kabar & Berita Desa</a></li>
                    <li><a href="{{ route('umkm.index') }}" class="hover:text-emerald-400 transition">Sentra UMKM Lokal</a></li>
                    <li><a href="{{ route('demographics') }}" class="hover:text-emerald-400 transition">Statistik & Demografi</a></li>
                </ul>
            </div>

            <!-- Layanan Publik -->
            <div>
                <h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-3">Layanan Warga</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('services.guides') }}" class="hover:text-emerald-400 transition">Panduan Permohonan Surat</a></li>
                    <li><a href="{{ route('services.store-register') }}" class="hover:text-emerald-400 transition">Pendaftaran Toko UMKM</a></li>
                    <li><a href="{{ route('services.feedback') }}" class="hover:text-emerald-400 transition">Kanal Aspirasi & Pengaduan</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 transition">Masuk Panel Petugas</a></li>
                </ul>
            </div>

            <!-- Kontak & Kantor -->
            <div>
                <h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-3">Kontak & Lokasi</h4>
                <div class="space-y-2 text-xs text-slate-400">
                    <p class="flex items-start">
                        <span class="font-semibold text-slate-300 mr-2">Alamat:</span>
                        Jl. Raya Ngadiluwih, Kec. Ngadiluwih, Kab. Kediri, Jawa Timur 64171
                    </p>
                    <p><span class="font-semibold text-slate-300">Jam Layanan:</span> Senin - Jumat (08.00 - 15.00 WIB)</p>
                    <p><span class="font-semibold text-slate-300">Email:</span> pemdes@ngadiluwih.desa.id</p>
                    <p><span class="font-semibold text-slate-300">WhatsApp:</span> +62 812-3456-7890</p>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} Pemerintah Desa Ngadiluwih. Hak cipta dilindungi.</p>
            <p class="mt-2 sm:mt-0">Didukung oleh PojokNgadiluwih AI & Data Science Portal</p>
        </div>
    </div>
</footer>
