@extends('layouts.admin')

@section('title', 'Edit Data UMKM')

@section('custom_header_title')
    <div class="py-1">
        <h1 class="font-serif-title text-xl sm:text-2xl font-bold text-[#38190C] dark:text-[#F8F1EB] leading-tight">Perbarui Profil & Data UMKM</h1>
        <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5">Mengedit toko: <span class="font-semibold text-[#BD6E37]">{{ $umkm->name }}</span></p>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.umkm.index', ['status' => $umkm->status]) }}" class="inline-flex items-center px-4 py-2 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] hover:bg-[#F5ECE1] dark:hover:bg-[#221A14] transition bg-[#FAF4ED] dark:bg-[#1E1712]">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Kurasi UMKM
        </a>
    </div>

    <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Toko & Pemilik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Nama Toko / Usaha <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $umkm->name) }}"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('name') border-rose-400 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="owner_name" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Nama Pemilik <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="owner_name"
                        name="owner_name"
                        value="{{ old('owner_name', $umkm->owner_name) }}"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('owner_name') border-rose-400 @enderror"
                    >
                    @error('owner_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- WhatsApp & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="whatsapp" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Nomor WhatsApp Pesanan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="whatsapp"
                        name="whatsapp"
                        value="{{ old('whatsapp', $umkm->whatsapp) }}"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('whatsapp') border-rose-400 @enderror"
                    >
                    <span class="text-[11px] text-[#765F50] dark:text-[#BCAAA0] mt-1 block">Digunakan untuk tombol "Pesan via WhatsApp".</span>
                    @error('whatsapp')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="category" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Kategori Produk <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition">
                        @foreach(['Kuliner & Camilan', 'Pertanian & Hasil Alam', 'Kerajinan Tangan', 'Jasa & Servis Lokal'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $umkm->category) === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Dusun & Alamat -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="dusun" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Dusun <span class="text-rose-500">*</span>
                    </label>
                    <select id="dusun" name="dusun" required class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition">
                        @foreach(['Krajan', 'Wonorejo', 'Sukorejo', 'Karangrejo'] as $ds)
                            <option value="{{ $ds }}" {{ old('dusun', $umkm->dusun) === $ds ? 'selected' : '' }}>
                                Dusun {{ $ds }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Alamat Lengkap / RT RW <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address', $umkm->address) }}"
                        required
                        class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('address') border-rose-400 @enderror"
                    >
                </div>
            </div>

            <!-- Daftar Barang / Produk yang Dijual -->
            <div>
                <label for="products" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Daftar Barang / Produk yang Dijual
                </label>
                <textarea
                    id="products"
                    name="products"
                    rows="4"
                    placeholder="Tuliskan nama produk/barang yang dijual, satu per baris (tekan Enter untuk produk berikutnya)..."
                    class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition"
                >{{ old('products', $umkm->products_text) }}</textarea>
                <span class="text-[11px] text-[#765F50] dark:text-[#BCAAA0] mt-1 block">Tuliskan setiap nama barang di baris baru. Daftar ini akan tampil di katalog publik.</span>
            </div>

            <!-- Foto Produk -->
            <div>
                <label for="image" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Foto Produk / Logo Usaha
                </label>
                @if($umkm->image_url)
                    <div class="mb-3 flex items-center space-x-3">
                        <img src="{{ $umkm->image_url }}" alt="{{ $umkm->name }}" class="w-24 h-24 object-cover rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm">
                        <span class="text-xs text-[#765F50] dark:text-[#BCAAA0]">Foto saat ini. Pilih berkas baru di bawah jika ingin menggantinya.</span>
                    </div>
                @endif
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full px-4 py-2.5 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] text-stone-700 dark:text-[#F8F1EB] file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#F0E4D5] dark:file:bg-[#2D211A] file:text-[#C07044] hover:file:bg-[#E8D6C3] transition"
                >
                <p class="text-[11px] text-stone-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                @error('image')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Usaha -->
            <div>
                <label for="description" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Deskripsi Produk & Usaha <span class="text-rose-500">*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    required
                    class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('description') border-rose-400 @enderror"
                >{{ old('description', $umkm->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Publikasi -->
            <div>
                <label for="status" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Status Publikasi Toko <span class="text-rose-500">*</span>
                </label>
                <select id="status" name="status" required class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition">
                    <option value="approved" {{ old('status', $umkm->status) === 'approved' ? 'selected' : '' }}>✅ Disetujui (Tayang di Web Publik)</option>
                    <option value="pending"  {{ old('status', $umkm->status) === 'pending'  ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                    <option value="rejected" {{ old('status', $umkm->status) === 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="pt-4 border-t border-[#EADBCC]/80 dark:border-[#2A1E17] flex justify-end space-x-3">
                <a href="{{ route('admin.umkm.index', ['status' => $umkm->status]) }}" class="px-5 py-2.5 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] hover:bg-[#F5ECE1] dark:hover:bg-[#221A14] transition bg-[#FAF4ED] dark:bg-[#1E1712]">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#C07044] hover:bg-[#B06035] text-white text-xs font-bold shadow-md shadow-[#C07044]/25 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
