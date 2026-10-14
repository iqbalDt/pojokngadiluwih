@extends('layouts.admin')

@section('title', 'Overview Dashboard')
@section('header_title', 'Dashboard Administrasi Desa')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="rounded-3xl bg-gradient-to-r from-emerald-800 to-teal-900 text-white p-6 sm:p-8 relative overflow-hidden shadow-sm">
        <div class="relative z-10 max-w-2xl">
            <span class="px-2.5 py-1 rounded-full bg-white/20 text-[11px] font-semibold">Selamat Datang di PojokNgadiluwih Command Center</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold mt-3">Panel Manajemen & Data Desa</h2>
            <p class="text-xs sm:text-sm text-emerald-100 mt-2 leading-relaxed">
                Kelola konten pengumuman warga, verifikasi pendaftaran UMKM baru, arsipkan dokumen layanan, serta pantau rekomendasi analitik berbasis AI.
            </p>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">UMKM Terverifikasi</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">🛍️</span>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-2">85</p>
            <span class="text-[11px] text-emerald-600 font-medium mt-1 block">+4 toko minggu ini</span>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengajuan Baru</span>
                <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs">⏳</span>
            </div>
            <p class="text-2xl font-black text-amber-600 mt-2">6</p>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Menunggu verifikasi admin</span>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Aspirasi Warga</span>
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">📢</span>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-2">18</p>
            <span class="text-[11px] text-indigo-600 font-medium mt-1 block">14 ditindaklanjuti</span>
        </div>

        <!-- Stat 4 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Interaksi Chatbot AI</span>
                <span class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs">🤖</span>
            </div>
            <p class="text-2xl font-black text-teal-700 mt-2">342</p>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">Pertanyaan terjawab otomatis</span>
        </div>
    </div>

    <!-- Actions & Overview Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Submissions -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900">Pengajuan UMKM Masuk Terbaru</h3>
                <a href="{{ route('admin.umkm.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-medium">
                            <th class="pb-2.5">Nama Toko</th>
                            <th class="pb-2.5">Pemilik</th>
                            <th class="pb-2.5">Kategori</th>
                            <th class="pb-2.5">Status</th>
                            <th class="pb-2.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr>
                            <td class="py-3 font-semibold text-slate-900">Madu Randu Berkah</td>
                            <td class="py-3">Bu Siti Sumarni</td>
                            <td class="py-3">Hasil Alam</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-50 text-amber-700 font-bold">Menunggu</span></td>
                            <td class="py-3 text-right">
                                <a href="{{ route('admin.umkm.index') }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold">Tinjau</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 font-semibold text-slate-900">Keripik Tempe Renyah</td>
                            <td class="py-3">Pak Sukardi</td>
                            <td class="py-3">Kuliner</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-50 text-amber-700 font-bold">Menunggu</span></td>
                            <td class="py-3 text-right">
                                <a href="{{ route('admin.umkm.index') }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold">Tinjau</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 font-semibold text-slate-900">Anyaman Bambu Berkah</td>
                            <td class="py-3">Pak Bambang</td>
                            <td class="py-3">Kerajinan</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-50 text-emerald-700 font-bold">Disetujui</span></td>
                            <td class="py-3 text-right">
                                <span class="text-slate-400 text-[11px]">Selesai</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Shortcuts -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
            <h3 class="text-sm font-bold text-slate-900">Aksi Pintas</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.news.create') }}" class="flex items-center p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition text-xs font-semibold text-slate-700">
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 font-bold text-sm">✍️</span>
                    Tulis Pengumuman / Berita
                </a>
                <a href="{{ route('admin.ai-knowledge.index') }}" class="flex items-center p-3 rounded-xl border border-slate-200 hover:border-teal-300 hover:bg-teal-50/50 transition text-xs font-semibold text-slate-700">
                    <span class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center mr-3 font-bold text-sm">🧠</span>
                    Update Knowledge Base AI
                </a>
                <a href="{{ route('admin.insights') }}" class="flex items-center p-3 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 transition text-xs font-semibold text-slate-700">
                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mr-3 font-bold text-sm">📊</span>
                    Lihat Rekomendasi Data Science
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
