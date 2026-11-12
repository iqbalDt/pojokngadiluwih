@extends('layouts.admin')

@section('title', 'Edit Data UMKM')
@section('header_title', 'Perbarui Data Toko UMKM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Perbarui Profil & Katalog UMKM</h2>
            <p class="text-xs text-slate-500 mt-1">Mengedit: <span class="font-semibold text-slate-700">{{ $umkm->name }}</span></p>
        </div>
        <a href="{{ route('admin.umkm.index', ['status' => $umkm->status]) }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Toko & Pemilik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Toko / Usaha <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $umkm->name) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none @error('name') border-rose-400 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="owner_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Pemilik <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="owner_name"
                        name="owner_name"
                        value="{{ old('owner_name', $umkm->owner_name) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none @error('owner_name') border-rose-400 @enderror"
                    >
                    @error('owner_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- WhatsApp & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="whatsapp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor WhatsApp Pesanan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="whatsapp"
                        name="whatsapp"
                        value="{{ old('whatsapp', $umkm->whatsapp) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none @error('whatsapp') border-rose-400 @enderror"
                    >
                    <span class="text-[11px] text-slate-400 mt-1 block">Digunakan untuk tombol "Pesan via WhatsApp".</span>
                    @error('whatsapp')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori Produk <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
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
                    <label for="dusun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Dusun <span class="text-rose-500">*</span>
                    </label>
                    <select id="dusun" name="dusun" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        @foreach(['Krajan', 'Wonorejo', 'Sukorejo', 'Karangrejo'] as $ds)
                            <option value="{{ $ds }}" {{ old('dusun', $umkm->dusun) === $ds ? 'selected' : '' }}>
                                Dusun {{ $ds }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Alamat Lengkap / RT RW <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address', $umkm->address) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>

            <!-- Daftar Barang / Produk yang Dijual -->
            <div>
                <label for="products" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Daftar Barang / Produk yang Dijual
                </label>
                <textarea
                    id="products"
                    name="products"
                    rows="4"
                    placeholder="Tuliskan nama produk/barang yang dijual, satu per baris (tekan Enter untuk produk berikutnya)&#10;Contoh:&#10;Keripik Tempe Original&#10;Keripik Tempe Balado Pedas&#10;Keripik Tempe Daun Jeruk"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                >{{ old('products', $umkm->products_text) }}</textarea>
                <span class="text-[11px] text-slate-400 mt-1 block">Tuliskan setiap nama barang di baris baru (Enter). Daftar ini akan ditampilkan sebagai daftar barang pada halaman detail UMKM publik.</span>
            </div>

            <!-- Foto Produk -->
            <div>
                <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Foto Produk / Logo Usaha
                </label>
                @if($umkm->image_url)
                    <div class="mb-3 flex items-center space-x-3">
                        <img src="{{ $umkm->image_url }}" alt="{{ $umkm->name }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200 shadow-sm">
                        <span class="text-xs text-slate-500">Foto saat ini. Pilih berkas baru di bawah jika ingin menggantinya.</span>
                    </div>
                @endif
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                >
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                @error('image')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Usaha -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Deskripsi Produk & Usaha <span class="text-rose-500">*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none @error('description') border-rose-400 @enderror"
                >{{ old('description', $umkm->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Publikasi -->
            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Status Publikasi Toko <span class="text-rose-500">*</span>
                </label>
                <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="approved" {{ old('status', $umkm->status) === 'approved' ? 'selected' : '' }}>✅ Disetujui (Tayang di Web Publik)</option>
                    <option value="pending"  {{ old('status', $umkm->status) === 'pending'  ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                    <option value="rejected" {{ old('status', $umkm->status) === 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.umkm.index', ['status' => $umkm->status]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

