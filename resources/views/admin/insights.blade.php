@extends('layouts.admin')

@section('title', 'Insights & Rekomendasi Kebijakan')
@section('header_title', 'Data Science & Rekomendasi Kebijakan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Analisis Data & Rekomendasi Kebijakan Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Sintesis berbasis model data science dari aspirasi warga, transaksi UMKM, dan demografi.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-800 text-xs font-semibold">
                🤖 AI Data Engine v1.0
            </span>
        </div>
    </div>

    <!-- Executive Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Indeks Kepuasan Layanan</span>
            <div class="flex items-baseline space-x-3 mt-2">
                <p class="text-3xl font-black text-emerald-600">89.4%</p>
                <span class="text-xs font-semibold text-emerald-600">Sangat Baik (+2.3%)</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">Berdasarkan umpan balik warga dan kecepatan penyelesaian surat pengantar.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Aspirasi Terbanyak</span>
            <div class="flex items-baseline space-x-3 mt-2">
                <p class="text-2xl font-bold text-slate-900">Irigasi Pertanian</p>
            </div>
            <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">42% topik aduan berkaitan dengan pasokan air sawah di musim tanam.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Potensi UMKM Berkembang</span>
            <div class="flex items-baseline space-x-3 mt-2">
                <p class="text-2xl font-bold text-teal-700">Kuliner Kering & Madu</p>
            </div>
            <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">Mencatat rasio klik WhatsApp tertinggi (64% dari total klik katalog).</p>
        </div>
    </div>

    <!-- AI Policy Recommendations Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center font-bold text-lg">
                💡
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Rekomendasi Kebijakan Prioritas (AI Insights)</h3>
                <p class="text-xs text-slate-500">Rangkuman saran berbasis pola aspirasi dan kebutuhan riil warga Ngadiluwih.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Rekomendasi 1 -->
            <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200/80 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-200 text-emerald-900 text-[10px] font-bold">Infrastruktur Tani</span>
                    <span class="text-[11px] font-semibold text-emerald-800">Skor Dampak: 9.2/10</span>
                </div>
                <h4 class="font-bold text-sm text-slate-900">Alokasi Dana Desa untuk Normalisasi Saluran Sekunder Dusun Sukorejo</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Data histori pengaduan menunjukkan frekuensi keluhan irigasi meningkat setiap menjelang musim tanam II. Rekomendasi: memasukkan agenda pengerukan sedimen pada APBDes perubahan.
                </p>
            </div>

            <!-- Rekomendasi 2 -->
            <div class="p-5 rounded-2xl bg-teal-50/60 border border-teal-200/80 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full bg-teal-200 text-teal-900 text-[10px] font-bold">Ekonomi & UMKM</span>
                    <span class="text-[11px] font-semibold text-teal-800">Skor Dampak: 8.8/10</span>
                </div>
                <h4 class="font-bold text-sm text-slate-900">Fasilitasi Sertifikasi Halal & P-IRT Kolektif</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Lebih dari 60% UMKM olahan pangan di Dusun Wonorejo belum memiliki izin P-IRT resmi. Rekomendasi: Pemdes menjalin kerja sama pendampingan dengan Kemenag dan Dinas Kesehatan Kediri.
                </p>
            </div>
        </div>
    </div>

    <!-- Sentimen Analisis Warga -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <h3 class="text-base font-bold text-slate-900 mb-4">Distribusi Sentimen Aspirasi Warga (Natural Language Processing)</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-xs font-semibold text-slate-500">Sentimen Positif / Apresiasi</span>
                <p class="text-2xl font-black text-emerald-600 mt-1">68%</p>
                <span class="text-[11px] text-slate-400 mt-1 block">Pelayanan surat & respons cepat</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-xs font-semibold text-slate-500">Sentimen Netral / Usulan Umum</span>
                <p class="text-2xl font-black text-teal-600 mt-1">22%</p>
                <span class="text-[11px] text-slate-400 mt-1 block">Pertanyaan jadwal & prosedur</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-xs font-semibold text-slate-500">Sentimen Mendesak / Keluhan</span>
                <p class="text-2xl font-black text-amber-600 mt-1">10%</p>
                <span class="text-[11px] text-slate-400 mt-1 block">Fasilitas lampu jalan & irigasi</span>
            </div>
        </div>
    </div>
</div>
@endsection
