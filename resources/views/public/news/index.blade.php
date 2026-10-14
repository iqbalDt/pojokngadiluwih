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
        <!-- News Card 1 -->
        <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-48 bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-4xl text-white">
                    🌾
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold">Kegiatan</span>
                        <span>•</span>
                        <span>12 Okt 2026</span>
                    </div>
                    <h2 class="font-bold text-base text-slate-900 hover:text-emerald-600 transition">
                        <a href="{{ route('news.show', 'pelatihan-digitalisasi-umkm-desa-ngadiluwih') }}">
                            Pelatihan Digitalisasi & Pemasaran Online bagi UMKM Desa Ngadiluwih
                        </a>
                    </h2>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pemerintah Desa Ngadiluwih bekerja sama dengan dinas terkait menyelenggarakan lokakarya strategi penjualan produk lokal via platform digital.
                    </p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <a href="{{ route('news.show', 'pelatihan-digitalisasi-umkm-desa-ngadiluwih') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                    Baca Selengkapnya
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </article>

        <!-- News Card 2 -->
        <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-48 bg-gradient-to-tr from-teal-600 to-cyan-500 flex items-center justify-center text-4xl text-white">
                    💉
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                        <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 font-semibold">Pengumuman</span>
                        <span>•</span>
                        <span>08 Okt 2026</span>
                    </div>
                    <h2 class="font-bold text-base text-slate-900 hover:text-emerald-600 transition">
                        <a href="{{ route('news.show', 'jadwal-posyandu-dan-pemeriksaan-kesehatan-lansia') }}">
                            Jadwal Posyandu Balita dan Pemeriksaan Kesehatan Lansia Bulan Ini
                        </a>
                    </h2>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Warga dihimbau membawa balita ke Posyandu Dusun Krajan pada hari Selasa pagi untuk penimbangan dan imunisasi dasar.
                    </p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <a href="{{ route('news.show', 'jadwal-posyandu-dan-pemeriksaan-kesehatan-lansia') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                    Baca Selengkapnya
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </article>

        <!-- News Card 3 -->
        <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-48 bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-4xl text-white">
                    🏗️
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold">Pembangunan</span>
                        <span>•</span>
                        <span>01 Okt 2026</span>
                    </div>
                    <h2 class="font-bold text-base text-slate-900 hover:text-emerald-600 transition">
                        <a href="{{ route('news.show', 'peningkatan-irigasi-pertanian-di-dusun-selatan') }}">
                            Peningkatan Saluran Irigasi Pertanian di Wilayah Persawahan Ngadiluwih
                        </a>
                    </h2>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pembangunan saluran irigasi tersier terus digenjot guna memastikan pasokan air lancar selama masa tanam musim ini.
                    </p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <a href="{{ route('news.show', 'peningkatan-irigasi-pertanian-di-dusun-selatan') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center">
                    Baca Selengkapnya
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </article>
    </div>
</div>
@endsection
