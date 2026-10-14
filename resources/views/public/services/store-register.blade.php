@extends('layouts.app')

@section('title', 'Pendaftaran Toko & Produk UMKM')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Pemberdayaan UMKM</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Formulir Pendaftaran Toko UMKM Desa</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Promosikan usaha Anda ke seluruh masyarakat melalui katalog digital PojokNgadiluwih dengan direct order WhatsApp secara gratis.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('services.store-register.submit') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Usaha -->
            <div>
                <label for="store_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Toko / Usaha UMKM <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="store_name" name="store_name" required placeholder="Contoh: Madu Randu Berkah Bu Siti" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
            </div>

            <!-- Nama Pemilik & NIK -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="owner_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Pemilik <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="owner_name" name="owner_name" required placeholder="Nama lengkap sesuai KTP" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label for="nik" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        NIK Pemilik <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nik" name="nik" required placeholder="16 digit NIK warga Ngadiluwih" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Nomor WhatsApp & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="whatsapp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor WhatsApp Pesanan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="whatsapp" name="whatsapp" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Nomor aktif yang menerima pesanan pembeli.</span>
                </div>
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori Produk <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="">Pilih Kategori...</option>
                        <option value="Kuliner & Camilan">Kuliner & Camilan</option>
                        <option value="Pertanian & Hasil Alam">Pertanian & Hasil Alam</option>
                        <option value="Kerajinan Tangan">Kerajinan Tangan</option>
                        <option value="Jasa & Servis Lokal">Jasa & Servis Lokal</option>
                    </select>
                </div>
            </div>

            <!-- Dusun & Alamat -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="dusun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Dusun <span class="text-rose-500">*</span>
                    </label>
                    <select id="dusun" name="dusun" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="">Pilih Dusun...</option>
                        <option value="Krajan">Dusun Krajan</option>
                        <option value="Wonorejo">Dusun Wonorejo</option>
                        <option value="Sukorejo">Dusun Sukorejo</option>
                        <option value="Karangrejo">Dusun Karangrejo</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Alamat Lengkap / RT RW <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="address" name="address" required placeholder="Contoh: RT 03 RW 02 Jl. Mawar No. 12" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Deskripsi Usaha & Daftar Produk Utama <span class="text-rose-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required placeholder="Jelaskan produk apa saja yang Anda jual, kisaran harga, dan keunggulan produk Anda..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none"></textarea>
            </div>

            <!-- Syarat & Ketentuan -->
            <div class="p-4 bg-emerald-50/70 border border-emerald-200 rounded-xl text-xs text-emerald-800 space-y-1">
                <p class="font-bold">Ketentuan Verifikasi:</p>
                <p>Data yang dikirim akan diverifikasi oleh Admin Pemerintah Desa Ngadiluwih dalam 1x24 jam sebelum tayang di katalog publik.</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/25 transition">
                    Kirim Pengajuan Toko UMKM
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
