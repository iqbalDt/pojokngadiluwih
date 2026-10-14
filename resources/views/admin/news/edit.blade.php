@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('header_title', 'Perbarui Berita / Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Perbarui Konten Berita</h2>
            <p class="text-xs text-slate-500 mt-1">Mengedit berita ID #{{ $id }}</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.news.update', $id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="Pelatihan Digitalisasi & Pemasaran Online bagi UMKM Desa Ngadiluwih" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="Kegiatan Desa" selected>Kegiatan Desa</option>
                        <option value="Pengumuman">Pengumuman Resmi</option>
                        <option value="Pembangunan">Pembangunan Desa</option>
                        <option value="Sosial & Budaya">Sosial & Budaya</option>
                    </select>
                </div>
                <div>
                    <label for="published_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tanggal Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="published_at" name="published_at" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Isi Berita / Pengumuman <span class="text-rose-500">*</span>
                </label>
                <textarea id="content" name="content" rows="8" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">Pemerintah Desa Ngadiluwih bekerja sama dengan dinas terkait menyelenggarakan lokakarya strategi penjualan produk lokal via platform digital bagi seluruh pelaku UMKM desa.</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
