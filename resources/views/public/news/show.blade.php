@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('news.index') }}" class="hover:text-emerald-600">Berita</a>
        <span>/</span>
        <!-- Mengambil judul dari database -->
        <span class="text-slate-800 font-semibold truncate">{{ $news->title }}</span>
    </nav>

    <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm">
        <div class="flex items-center space-x-3 text-xs text-slate-400 mb-4">
            <!-- Mengambil Kategori dari database -->
            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">{{ $news->category }}</span>
            <span>•</span>
            <!-- Mengambil Tanggal dari database (format tanggal Indonesia) -->
            <span>Dipublikasikan: {{ \Carbon\Carbon::parse($news->published_at)->translatedFormat('d F Y') }}</span>
            <span>•</span>
            <!-- Mengambil Nama Penulis dari relasi tabel users -->
            <span>Oleh: {{ $news->author->name ?? 'Admin Desa' }}</span>
        </div>

        <!-- Mengambil Judul dari database -->
        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
            {{ $news->title }}
        </h1>

        <div class="my-8 w-full h-72 sm:h-96 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white text-6xl shadow-inner">
            📰
        </div>

        <!-- Mengambil Isi Berita dari database. -->
        <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
            {!! nl2br(e($news->content)) !!}
        </div>

        <div class="mt-10 pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Berita
            </a>
            <div class="flex items-center space-x-2 text-xs text-slate-500">
                <span>Bagikan:</span>
                <button class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition font-medium">WhatsApp</button>
                <button class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition font-medium">Salin Tautan</button>
            </div>
        </div>
    </article>
</div>
@endsection