@extends('layouts.admin')

@section('title', 'Insight & Rekomendasi Kebijakan')

@section('custom_header_title')
<div class="py-1">
    <h1 class="font-serif-title text-xl sm:text-2xl lg:text-[26px] font-bold text-[#38190C] dark:text-[#F8F1EB] tracking-tight">
        Insight & Rekomendasi Kebijakan <span class="italic font-normal">Desa</span>
    </h1>
    <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5 font-normal">
        Sintesis data aspirasi warga, tren kebutuhan pelayanan, dan rekomendasi program desa berbasis AI
    </p>
</div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Executive Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Coklat Tua Eksklusif — Tingkat Tindak Lanjut Aspirasi Real-Time -->
        <div class="bg-[#38190C] text-[#FFF8F0] rounded-3xl p-6 border border-[#251007] shadow-md flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-[11px] font-bold text-amber-200/90 uppercase tracking-widest block font-serif-title">
                        Tindak Lanjut Aspirasi
                    </span>
                    <span class="text-xs font-semibold text-emerald-300 bg-emerald-500/20 border border-emerald-500/40 px-2.5 py-0.5 rounded-full whitespace-nowrap">
                        {{ $insights['handledAspirations'] }}/{{ $insights['totalAspirations'] }} Laporan
                    </span>
                </div>
                <div class="mt-4">
                    <p class="font-serif-title text-3xl sm:text-4xl font-extrabold text-[#FFF8F0]">{{ number_format($insights['resolutionRate'], 1) }}%</p>
                </div>
                <p class="text-xs text-stone-300 mt-3 leading-relaxed">
                    Persentase laporan dan aspirasi warga di Firestore yang telah diproses atau tuntas ditangani perangkat desa.
                </p>
            </div>
            <!-- Subtle accent bubble -->
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-[#C07044]/20 pointer-events-none"></div>
        </div>

        <!-- Card 2: Coklat Keorenan Terracotta Kontras -->
        <div class="bg-[#C07044]/15 dark:bg-[#C07044]/25 rounded-3xl p-6 border border-[#C07044]/35 dark:border-[#C07044]/40 shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider block font-serif-title">
                    Aspirasi Terbanyak Warga
                </span>
                <div class="mt-4">
                    <p class="font-serif-title text-2xl font-bold text-[#38190C] dark:text-[#F8F1EB]">Layanan Surat Menyurat</p>
                </div>
            </div>
            <p class="text-xs text-[#765F50] dark:text-[#D1C2B8] mt-3 leading-relaxed">
                Mayoritas kebutuhan warga berfokus pada kemudahan pengurusan surat administrasi desa, baik secara online melalui portal maupun offline di balai desa.
            </p>
        </div>

        <!-- Card 3: Coklat Tua Transparan Bergradasi Kontras -->
        <div class="bg-[#38190C]/10 dark:bg-[#38190C]/35 rounded-3xl p-6 border border-[#38190C]/25 dark:border-[#2A1E17] shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider block font-serif-title">
                    Potensi UMKM Berkembang
                </span>
                <div class="mt-4">
                    <p class="font-serif-title text-2xl font-bold text-[#C07044] dark:text-[#E08A58]">Hasil Tani &amp; Olahan Lokal</p>
                </div>
            </div>
            <p class="text-xs text-[#765F50] dark:text-[#D1C2B8] mt-3 leading-relaxed">
                Selaras dengan mata pencaharian utama warga sebagai petani serta dukungan SDM dominan lulusan SLTA ke atas di 3 dusun (Ngadiluwih, Ngadiloyo, Kandang Sapi).
            </p>
        </div>

    </div>

    <!-- AI Policy Recommendations Section -->
    <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center space-x-3.5 border-b border-[#EADBCC]/80 dark:border-[#2A1E17] pb-4">
            <div class="w-10 h-10 rounded-2xl bg-[#38190C] text-amber-200 flex items-center justify-center font-bold text-lg shadow-sm shrink-0">
                💡
            </div>
            <div>
                <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB]">
                    Rekomendasi Kebijakan Prioritas (AI Data Science)
                </h3>
                <p class="text-xs text-[#765F50] dark:text-[#BCAAA0]">
                    Rangkuman saran kebijakan berbasis pola aspirasi dan kebutuhan riil warga Ngadiluwih.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Rekomendasi 1 (Coklat Keorenan Terracotta Tint Kontras) -->
            <div class="p-6 rounded-2xl bg-[#C07044]/10 dark:bg-[#C07044]/20 border border-[#C07044]/30 dark:border-[#C07044]/40 space-y-3 shadow-sm hover:border-[#C07044] hover:bg-[#C07044]/15 dark:hover:bg-[#C07044]/25 transition">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-[#38190C] text-white text-[11px] font-bold">
                        Pelayanan Administrasi
                    </span>
                    <span class="text-xs font-semibold text-[#059669]">Prioritas Utama</span>
                </div>
                <h4 class="font-serif-title font-bold text-sm sm:text-base text-[#38190C] dark:text-[#F8F1EB]">
                    Optimalisasi Layanan Surat Menyurat Terpadu (Online &amp; Offline)
                </h4>
                <p class="text-xs text-stone-700 dark:text-[#D1C2B8] leading-relaxed">
                    Aspirasi terbanyak warga menyoroti kemudahan akses pengurusan surat. Rekomendasi: sinkronisasi loket tatap muka di Balai Desa (Dusun Ngadiluwih) dengan panduan syarat surat dan pengajuan online melalui portal.
                </p>
            </div>

            <!-- Rekomendasi 2 (Coklat Tua Tint Kontras) -->
            <div class="p-6 rounded-2xl bg-[#38190C]/[0.08] dark:bg-[#38190C]/[0.30] border border-[#38190C]/25 dark:border-[#2A1E17] space-y-3 shadow-sm hover:border-[#C07044] hover:bg-[#38190C]/[0.12] dark:hover:bg-[#38190C]/[0.38] transition">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-[#C07044] text-white text-[11px] font-bold">
                        Ekonomi &amp; UMKM
                    </span>
                    <span class="text-xs font-semibold text-[#059669]">Fokus Ekonomi Desa</span>
                </div>
                <h4 class="font-serif-title font-bold text-sm sm:text-base text-[#38190C] dark:text-[#F8F1EB]">
                    Penguatan UMKM Berbasis Hasil Tani &amp; Digitalisasi Pemasaran
                </h4>
                <p class="text-xs text-stone-700 dark:text-[#D1C2B8] leading-relaxed">
                    Mayoritas warga bermata pencaharian petani dengan tingkat pendidikan dominan SLTA ke atas. Rekomendasi: fasilitasi pemasaran digital produk hasil tani, olahan pangan, dan kerajinan warga dari Dusun Ngadiluwih, Ngadiloyo, dan Kandang Sapi.
                </p>
            </div>
        </div>
    </div>

    <!-- Rekap Status Penanganan Aspirasi Warga (Real-Time Firestore) -->
    <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
            <div>
                <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB]">
                    Rekap Status Penanganan Aspirasi Warga
                </h3>
                <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5">
                    Data dihitung langsung secara real-time dari total {{ $insights['totalAspirations'] }} aspirasi masuk di Firestore.
                </p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-[#C07044] hover:underline self-start sm:self-auto">
                Kelola Arsip Aspirasi &rarr;
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            
            <!-- Menunggu Tindak Lanjut -->
            <div class="p-5 rounded-2xl bg-[#FEF9EE] dark:bg-amber-950/25 border border-[#FDE68A] dark:border-amber-800/50 shadow-sm">
                <span class="text-xs font-semibold text-[#B45309] dark:text-amber-300 font-serif-title">Menunggu Tindak Lanjut</span>
                <p class="font-serif-title text-3xl font-extrabold text-[#B45309] dark:text-amber-300 mt-2">{{ $insights['pendingAspirations'] }}</p>
                <span class="text-[11px] text-[#765F50] dark:text-[#D1C2B8] mt-1 block">Perlu peninjauan &amp; respons awal petugas</span>
            </div>

            <!-- Sedang Diproses -->
            <div class="p-5 rounded-2xl bg-[#C07044]/15 dark:bg-[#C07044]/25 border border-[#C07044]/35 shadow-sm">
                <span class="text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] font-serif-title">Sedang Diproses</span>
                <p class="font-serif-title text-3xl font-extrabold text-[#C07044] dark:text-[#E08A58] mt-2">{{ $insights['processedAspirations'] }}</p>
                <span class="text-[11px] text-[#765F50] dark:text-[#D1C2B8] mt-1 block">Dalam penanganan perangkat desa</span>
            </div>

            <!-- Selesai Ditangani -->
            <div class="p-5 rounded-2xl bg-[#059669]/10 dark:bg-[#059669]/20 border border-[#059669]/30 shadow-sm">
                <span class="text-xs font-semibold text-[#065F46] dark:text-[#34D399] font-serif-title">Selesai Ditangani</span>
                <p class="font-serif-title text-3xl font-extrabold text-[#059669] dark:text-[#34D399] mt-2">{{ $insights['completedAspirations'] }}</p>
                <span class="text-[11px] text-[#047857] dark:text-[#6EE7B7] mt-1 block">Aspirasi warga telah tuntas diselesaikan</span>
            </div>

        </div>
    </div>

</div>
@endsection
