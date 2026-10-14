@extends('layouts.app')

@section('title', 'Katalog UMKM Desa Ngadiluwih')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Pemberdayaan Ekonomi</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Sentra & Katalog UMKM Ngadiluwih</h1>
                <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                    Dukung produk karya warga desa. Pesan langsung ke penjual via WhatsApp tanpa perantara.
                </p>
            </div>
            <div>
                <a href="{{ route('services.store-register') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Daftarkan Usaha Anda
                </a>
            </div>
        </div>

        <!-- Filter bar -->
        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" placeholder="Cari produk UMKM, nama toko, atau dusun..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="flex gap-2 overflow-x-auto text-xs">
                <button class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold whitespace-nowrap">Semua Kategori</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Kuliner</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Pertanian & Bibit</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Kerajinan Tangan</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Jasa Lokal</button>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Item 1 -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
            <div>
                <div class="w-full h-40 bg-amber-50 rounded-xl flex items-center justify-center text-5xl mb-4">
                    🥜
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">Kuliner</span>
                    <span class="text-[11px] text-slate-400">Dusun Wonorejo</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base mt-2">Kacang Oven Gurih Bu Sumi</h3>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">Kacang tanah pilihan diolah secara higienis tanpa minyak goreng berlebih.</p>
                <p class="text-emerald-700 font-extrabold text-base mt-2">Rp 15.000 <span class="text-xs text-slate-400 font-normal">/ bks</span></p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('umkm.show', 'kacang-oven-bu-sumi') }}" class="text-xs text-slate-600 hover:text-emerald-600 font-medium">Detail Produk</a>
                <a href="https://wa.me/6281234567890?text=Halo%20Bu%20Sumi,%20saya%20melihat%20toko%20Anda%20di%20PojokNgadiluwih%20dan%20ingin%20memesan%20Kacang%20Oven" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                    Pesan via WA
                </a>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
            <div>
                <div class="w-full h-40 bg-emerald-50 rounded-xl flex items-center justify-center text-5xl mb-4">
                    🍯
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">Hasil Alam</span>
                    <span class="text-[11px] text-slate-400">Dusun Krajan</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base mt-2">Madu Murni Randu Ngadiluwih</h3>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">Madu asli ternak bunga randu dengan kemurnian 100% tanpa bahan pengawet.</p>
                <p class="text-emerald-700 font-extrabold text-base mt-2">Rp 75.000 <span class="text-xs text-slate-400 font-normal">/ botol</span></p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('umkm.show', 'madu-murni-randu') }}" class="text-xs text-slate-600 hover:text-emerald-600 font-medium">Detail Produk</a>
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20Madu%20Murni%20Randu%20di%20PojokNgadiluwih" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                    Pesan via WA
                </a>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
            <div>
                <div class="w-full h-40 bg-teal-50 rounded-xl flex items-center justify-center text-5xl mb-4">
                    🧺
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 text-[10px] font-bold">Kerajinan</span>
                    <span class="text-[11px] text-slate-400">Dusun Karangrejo</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base mt-2">Anyaman Bambu Berkah Jaya</h3>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">Keranjang anyaman bambu kokoh untuk souvenir hajatan dan wadah makanan ramah lingkungan.</p>
                <p class="text-emerald-700 font-extrabold text-base mt-2">Rp 12.000 <span class="text-xs text-slate-400 font-normal">/ pcs</span></p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('umkm.show', 'anyaman-bambu-berkah') }}" class="text-xs text-slate-600 hover:text-emerald-600 font-medium">Detail Produk</a>
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20memesan%20Anyaman%20Bambu%20Berkah%20Jaya" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                    Pesan via WA
                </a>
            </div>
        </div>

        <!-- Item 4 -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
            <div>
                <div class="w-full h-40 bg-rose-50 rounded-xl flex items-center justify-center text-5xl mb-4">
                    🌶️
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold">Kuliner Olahan</span>
                    <span class="text-[11px] text-slate-400">Dusun Sukorejo</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base mt-2">Sambal Pecel Khas Kediri</h3>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">Bumbu pecel otentik gurih pedas siap seduh air hangat, awet disimpan hingga 3 bulan.</p>
                <p class="text-emerald-700 font-extrabold text-base mt-2">Rp 25.000 <span class="text-xs text-slate-400 font-normal">/ 500gr</span></p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('umkm.show', 'sambal-pecel-khas-kediri') }}" class="text-xs text-slate-600 hover:text-emerald-600 font-medium">Detail Produk</a>
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20mau%20pesan%20Sambal%20Pecel%20Khas%20Kediri" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                    Pesan via WA
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
