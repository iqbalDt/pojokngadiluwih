@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')
@section('header_title', 'Tambah Berita / Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Formulir Publikasi Berita</h2>
            <p class="text-xs text-slate-500 mt-1">Isi rincian informasi dan pengumuman untuk ditampilkan kepada masyarakat.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul berita yang menarik dan informatif..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                @error('title')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Foto Sampul Berita (Opsional)
                </label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
                @error('image')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="Kegiatan Desa" @selected(old('category') === 'Kegiatan Desa')>Kegiatan Desa</option>
                        <option value="Pengumuman" @selected(old('category') === 'Pengumuman')>Pengumuman Resmi</option>
                        <option value="Pembangunan" @selected(old('category') === 'Pembangunan')>Pembangunan Desa</option>
                        <option value="Sosial & Budaya" @selected(old('category') === 'Sosial & Budaya')>Sosial & Budaya</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="published_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tanggal Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="published_at" name="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                    @error('published_at')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ringkasan
                </label>
                <textarea id="excerpt" name="excerpt" rows="3" maxlength="500" placeholder="Ringkasan singkat untuk kartu berita (opsional)..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Isi Berita / Pengumuman <span class="text-rose-500">*</span>
                </label>
                <textarea id="content" name="content" rows="8" required placeholder="Tuliskan isi berita secara lengkap di sini..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Status <span class="text-rose-500">*</span>
                </label>
                <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status') === 'published')>Terbit</option>
                    <option value="archived" @selected(old('status') === 'archived')>Arsip</option>
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition">Terbitkan Berita</button>
            </div>
        </form>
    </div>
</div>
@endsection
