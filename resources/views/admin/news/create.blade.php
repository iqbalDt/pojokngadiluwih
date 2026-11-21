@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('custom_header_title')
    <div class="py-1">
        <h1 class="font-serif-title text-xl sm:text-2xl font-bold text-[#38190C] dark:text-[#F8F1EB] leading-tight">Formulir Publikasi Berita</h1>
        <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5">Tulis dan publikasikan informasi atau pengumuman resmi desa.</p>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] hover:bg-[#F5ECE1] dark:hover:bg-[#221A14] transition bg-[#FAF4ED] dark:bg-[#1E1712]">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Berita
        </a>
    </div>

    <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Masukkan judul berita yang menarik dan informatif..." 
                    class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('title') border-rose-400 @enderror"
                >
                @error('title')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Foto Sampul Berita (Opsional)
                </label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/jpeg,image/png,image/jpg,image/webp" 
                    class="w-full px-4 py-2.5 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] text-stone-700 dark:text-[#F8F1EB] file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#F0E4D5] dark:file:bg-[#2D211A] file:text-[#C07044] hover:file:bg-[#E8D6C3] transition @error('image') border-rose-400 @enderror"
                >
                <p class="text-[11px] text-stone-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
                @error('image')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('category') border-rose-400 @enderror">
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
                    <label for="published_at" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Tanggal Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="published_at" 
                        name="published_at" 
                        value="{{ old('published_at', now()->format('Y-m-d')) }}" 
                        required 
                        class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('published_at') border-rose-400 @enderror"
                    >
                    @error('published_at')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="excerpt" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Ringkasan Berita
                </label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    rows="3" 
                    maxlength="500" 
                    placeholder="Ringkasan singkat untuk kartu berita (opsional)..." 
                    class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('excerpt') border-rose-400 @enderror"
                >{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Isi Berita / Pengumuman <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="8" 
                    required 
                    placeholder="Tuliskan isi berita secara lengkap di sini..." 
                    class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('content') border-rose-400 @enderror"
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                    Status <span class="text-rose-500">*</span>
                </label>
                <select id="status" name="status" required class="w-full px-4 py-3 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs sm:text-sm text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition @error('status') border-rose-400 @enderror">
                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status') === 'published')>Terbit</option>
                    <option value="archived" @selected(old('status') === 'archived')>Arsip</option>
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-[#EADBCC]/80 dark:border-[#2A1E17] flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] hover:bg-[#F5ECE1] dark:hover:bg-[#221A14] transition bg-[#FAF4ED] dark:bg-[#1E1712]">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#C07044] hover:bg-[#B06035] text-white text-xs font-bold shadow-md shadow-[#C07044]/25 transition">Terbitkan Berita</button>
            </div>
        </form>
    </div>
</div>
@endsection
