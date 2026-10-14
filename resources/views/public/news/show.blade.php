@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('news.index') }}" class="hover:text-emerald-600">Berita</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold truncate">{{ Str::headline($slug) }}</span>
    </nav>

    <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm">
        <div class="flex items-center space-x-3 text-xs text-slate-400 mb-4">
            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">Pengumuman & Berita</span>
            <span>•</span>
            <span>Dipublikasikan: 12 Oktober 2026</span>
            <span>•</span>
            <span>Oleh: Redaksi Desa</span>
        </div>

        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
            {{ Str::headline($slug) }}
        </h1>

        <div class="my-8 w-full h-72 sm:h-96 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white text-6xl shadow-inner">
            📰
        </div>

        <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
            <p>
                <strong>Ngadiluwih</strong> — Pemerintah Desa Ngadiluwih terus berkomitmen memperkuat pelayanan dan pembangunan desa yang inklusif serta berkelanjutan. Dalam rangka merealisasikan program prioritas tahun anggaran berjalan, berbagai inisiatif strategis terus digulirkan untuk memberikan dampak langsung bagi warga masyarakat.
            </p>
            <p>
                Kepala Desa Ngadiluwih menyampaikan bahwa sinergi antara pamong desa, tokoh masyarakat, kelompok pemuda, dan para pelaku UMKM merupakan pondasi utama dalam menciptakan ekosistem desa yang mandiri dan berdaya saing.
            </p>
            <blockquote class="p-4 my-4 border-l-4 border-emerald-500 bg-slate-50 italic text-slate-800 text-xs">
                "Partisipasi aktif seluruh elemen masyarakat adalah kunci keberhasilan program desa kita. Kami mengundang seluruh warga untuk terus memberikan masukan konstruktif demi kemajuan bersama."
            </blockquote>
            <p>
                Bagi masyarakat yang membutuhkan informasi lebih lanjut mengenai pengumuman ini atau ingin menyampaikan pertanyaan terkait, dapat memanfaatkan fitur Chatbot AI di pojok kanan bawah atau mengunjungi kantor balai desa pada hari kerja.
            </p>
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
