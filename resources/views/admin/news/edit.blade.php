@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('header_title', 'Perbarui Berita / Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Perbarui Konten Berita</h2>
            <p class="text-xs text-slate-500 mt-1">Mengedit: <span class="font-semibold text-slate-700">{{ $news->title }}</span></p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $news->title) }}"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none @error('title') border-rose-400 @enderror"
                >
                @error('title')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Foto Sampul Berita
                </label>
                @if($news->image_url)
                    <div class="mb-3 flex items-center space-x-3">
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200 shadow-sm">
                        <span class="text-xs text-slate-500">Foto sampul saat ini. Unggah file baru di bawah untuk menggantinya.</span>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        @foreach(['Kegiatan Desa', 'Pengumuman', 'Pembangunan', 'Sosial & Budaya'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $news->category) === $cat ? 'selected' : '' }}>
                                {{ $cat === 'Pengumuman' ? 'Pengumuman Resmi' : $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="published_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tanggal Terbit
                    </label>
                    <input
                        type="date"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : date('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                    >
                </div>
            </div>

            <div>
                <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ringkasan / Excerpt
                </label>
                <input
                    type="text"
                    id="excerpt"
                    name="excerpt"
                    value="{{ old('excerpt', $news->excerpt) }}"
                    placeholder="Ringkasan singkat berita (opsional, maks. 500 karakter)..."
                    maxlength="500"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                >
            </div>

            <div>
                <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Isi Berita / Pengumuman <span class="text-rose-500">*</span>
                </label>
                <textarea
                    id="content"
                    name="content"
                    rows="10"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none @error('content') border-rose-400 @enderror"
                >{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Status Publikasi <span class="text-rose-500">*</span>
                </label>
                <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>✅ Terbit (Publik)</option>
                    <option value="draft"     {{ old('status', $news->status) === 'draft'     ? 'selected' : '' }}>📝 Draft (Tersimpan)</option>
                    <option value="archived"  {{ old('status', $news->status) === 'archived'  ? 'selected' : '' }}>📦 Arsip</option>
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
