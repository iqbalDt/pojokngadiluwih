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
        
        <!-- Card 1: Coklat Tua Eksklusif (Kontras Tinggi seperti Jam Real-Time Dashboard) -->
        <div class="bg-[#38190C] text-[#FFF8F0] rounded-3xl p-6 border border-[#251007] shadow-md flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-amber-200/90 uppercase tracking-widest block font-serif-title">
                        Indeks Kepuasan Layanan
                    </span>
                    <span class="text-xs font-semibold text-emerald-300 bg-emerald-500/20 border border-emerald-500/40 px-2.5 py-0.5 rounded-full">
                        +2.3% Naik
                    </span>
                </div>
                <div class="mt-4">
                    <p class="font-serif-title text-3xl sm:text-4xl font-extrabold text-[#FFF8F0]">89.4%</p>
                </div>
                <p class="text-xs text-stone-300 mt-3 leading-relaxed">
                    Berdasarkan rekap umpan balik warga dan kecepatan penyelesaian proses surat pengantar desa.
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
                    <p class="font-serif-title text-2xl font-bold text-[#38190C] dark:text-[#F8F1EB]">Irigasi Pertanian</p>
                </div>
            </div>
            <p class="text-xs text-[#765F50] dark:text-[#D1C2B8] mt-3 leading-relaxed">
                42% topik aduan masyarakat berkaitan dengan ketersediaan pasokan air sawah menjelang musim tanam.
            </p>
        </div>

        <!-- Card 3: Coklat Tua Transparan Bergradasi Kontras -->
        <div class="bg-[#38190C]/10 dark:bg-[#38190C]/35 rounded-3xl p-6 border border-[#38190C]/25 dark:border-[#2A1E17] shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider block font-serif-title">
                    Potensi UMKM Berkembang
                </span>
                <div class="mt-4">
                    <p class="font-serif-title text-2xl font-bold text-[#C07044] dark:text-[#E08A58]">Kuliner Kering & Madu</p>
                </div>
            </div>
            <p class="text-xs text-[#765F50] dark:text-[#D1C2B8] mt-3 leading-relaxed">
                Mencatat rasio pemesanan WhatsApp tertinggi di katalog UMKM (64% dari total klik transaksi warga).
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
                        Infrastruktur Tani
                    </span>
                    <span class="text-xs font-semibold text-[#059669]">Skor Dampak: 9.2/10</span>
                </div>
                <h4 class="font-serif-title font-bold text-sm sm:text-base text-[#38190C] dark:text-[#F8F1EB]">
                    Alokasi Dana Desa untuk Normalisasi Saluran Sekunder Dusun Sukorejo
                </h4>
                <p class="text-xs text-stone-700 dark:text-[#D1C2B8] leading-relaxed">
                    Data histori pengaduan menunjukkan frekuensi keluhan irigasi meningkat setiap menjelang musim tanam II. Rekomendasi: memasukkan agenda pengerukan sedimen pada APBDes perubahan.
                </p>
            </div>

            <!-- Rekomendasi 2 (Coklat Tua Tint Kontras) -->
            <div class="p-6 rounded-2xl bg-[#38190C]/[0.08] dark:bg-[#38190C]/[0.30] border border-[#38190C]/25 dark:border-[#2A1E17] space-y-3 shadow-sm hover:border-[#C07044] hover:bg-[#38190C]/[0.12] dark:hover:bg-[#38190C]/[0.38] transition">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-[#C07044] text-white text-[11px] font-bold">
                        Ekonomi & UMKM
                    </span>
                    <span class="text-xs font-semibold text-[#059669]">Skor Dampak: 8.8/10</span>
                </div>
                <h4 class="font-serif-title font-bold text-sm sm:text-base text-[#38190C] dark:text-[#F8F1EB]">
                    Fasilitasi Sertifikasi Halal & P-IRT Kolektif bagi Pelaku UMKM
                </h4>
                <p class="text-xs text-stone-700 dark:text-[#D1C2B8] leading-relaxed">
                    Lebih dari 60% UMKM olahan pangan di desa belum memiliki izin P-IRT resmi. Rekomendasi: Pemdes menjalin kerja sama pendampingan dengan Kemenag dan Dinas Kesehatan Kabupaten Kediri.
                </p>
            </div>
        </div>
    </div>

    <!-- Sentimen Analisis Warga -->
    <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8">
        <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB] mb-4">
            Distribusi Sentimen Aspirasi Warga (Natural Language Processing)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            
            <!-- Positif -->
            <div class="p-5 rounded-2xl bg-[#059669]/10 dark:bg-[#059669]/20 border border-[#059669]/30 shadow-sm">
                <span class="text-xs font-semibold text-[#065F46] dark:text-[#34D399] font-serif-title">Sentimen Positif / Apresiasi</span>
                <p class="font-serif-title text-3xl font-extrabold text-[#059669] mt-2">68%</p>
                <span class="text-[11px] text-[#047857] dark:text-[#6EE7B7] mt-1 block">Pelayanan surat & respons cepat</span>
            </div>

            <!-- Netral (Coklat Keorenan Terracotta Tint Kontras) -->
            <div class="p-5 rounded-2xl bg-[#C07044]/15 dark:bg-[#C07044]/25 border border-[#C07044]/35 shadow-sm">
                <span class="text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] font-serif-title">Sentimen Netral / Usulan Umum</span>
                <p class="font-serif-title text-3xl font-extrabold text-[#C07044] dark:text-[#E08A58] mt-2">22%</p>
                <span class="text-[11px] text-[#765F50] dark:text-[#D1C2B8] mt-1 block">Pertanyaan jadwal & prosedur desa</span>
            </div>

            <!-- Mendesak (Coklat Tua Solid Kontras) -->
            <div class="p-5 rounded-2xl bg-[#38190C] text-[#FFF8F0] border border-[#251007] shadow-sm">
                <span class="text-xs font-semibold text-amber-200/90 font-serif-title">Sentimen Mendesak / Keluhan</span>
                <p class="font-serif-title text-3xl font-extrabold text-[#E08A58] mt-2">10%</p>
                <span class="text-[11px] text-stone-300 mt-1 block">Fasilitas lampu jalan & irigasi</span>
            </div>

        </div>
    </div>

</div>
@endsection
