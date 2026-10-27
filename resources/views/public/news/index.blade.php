@extends('layouts.app')

@section('title', 'Kabar & Berita Desa')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Informasi Publik</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Berita & Pengumuman Desa Ngadiluwih</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Ikuti informasi terbaru seputar program pembangunan, agenda posyandu, bantuan sosial, dan kegiatan kemasyarakatan.
        </p>

        <!-- Search and Category Filters -->
        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" placeholder="Cari berita atau pengumuman..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="flex gap-2 overflow-x-auto text-xs">
                <button class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold whitespace-nowrap">Semua</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Pengumuman</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Kegiatan Desa</button>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 whitespace-nowrap">Pembangunan</button>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- LOOPING DATA DARI DATABASE -->
        @forelse($news as $item)
        <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-48 bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-4xl text-white">
                    📰 <!-- Ikon default, sementara -->
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                        <!-- Menampilkan Kategori dari Database -->
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold">{{ $item->category ?? 'Umum' }}</span>
                        <span>•</span>
                        <!-- Menampilkan Tanggal (format: 12 Okt 2026) -->
                        <span>{{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</span>
                    </div>
                    <h2 class="font-bold text-base text-slate-900 hover:text-emerald-600 transition">
                        <!-- Link menggunakan slug dari database -->
                        <a href="{{ route('news.show', $item->slug) }}">
                            {{ $item->title }}
                        </a>
                    </h2>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        <!-- Menampilkan excerpt/ringkasan -->
                        {{ $item->excerpt }}
                    </p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <a href="{{ route('news.show', $item->slug) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                    Baca Selengkapnya
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </article>
        @empty
        <!-- Tampilan Jika Database Kosong -->
        <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-500 text-sm">Belum ada berita atau pengumuman yang dipublikasikan.</p>
        </div>
        @endforelse
        <!-- LOOPING SELESAI -->

    </div>

    <!-- Navigasi Halaman (Pagination) -->
    <div class="mt-10">
        {{ $news->links() }}
    </div>
</div>
@endsection