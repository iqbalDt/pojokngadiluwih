@extends('layouts.admin')

@section('title', 'Overview Dashboard')

@section('content')
<div class="space-y-6">

    <!-- 4 Stat Cards di Baris Atas (Persis Desain Screenshot) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: UMKM Terverifikasi -->
        <div class="bg-[#FBF4EC] dark:bg-[#1E1712] rounded-3xl p-5 border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#FAF3EB] tracking-wide uppercase">UMKM TERVERIFIKASI</span>
                <span class="text-stone-400 dark:text-stone-500">
                    <svg class="w-4 h-4 text-[#C47247]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <p class="font-serif-title text-3xl font-bold text-[#38190C] dark:text-[#FAF3EB]">{{ $approvedUmkmCount }}</p>
                <span class="text-xs text-stone-600 dark:text-[#D4C3B5] mt-1 block">Toko Aktif di Katalog</span>
            </div>
        </div>

        <!-- Card 2: Pengajuan Baru -->
        <div class="bg-[#FBF4EC] dark:bg-[#1E1712] rounded-3xl p-5 border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#FAF3EB] tracking-wide uppercase">PENGAJUAN BARU</span>
                <span class="text-stone-400 dark:text-stone-500">
                    <svg class="w-4 h-4 text-[#C47247]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <p class="font-serif-title text-3xl font-bold text-[#38190C] dark:text-[#FAF3EB]">{{ $pendingUmkmCount }}</p>
                <span class="text-xs text-stone-600 dark:text-[#D4C3B5] mt-1 block">Menunggu Verifikasi</span>
            </div>
        </div>

        <!-- Card 3: Aspirasi Warga -->
        <div class="bg-[#FBF4EC] dark:bg-[#1E1712] rounded-3xl p-5 border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#FAF3EB] tracking-wide uppercase">ASPIRASI WARGA</span>
                <span class="text-stone-400 dark:text-stone-500">
                    <svg class="w-4 h-4 text-[#C47247]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <p class="font-serif-title text-3xl font-bold text-[#38190C] dark:text-[#FAF3EB]">{{ $aspirationCount }}</p>
                <span class="text-xs text-stone-600 dark:text-[#D4C3B5] mt-1 block">Total pesan masuk</span>
            </div>
        </div>

        <!-- Card 4: Berita dan Publikasi -->
        <div class="bg-[#FBF4EC] dark:bg-[#1E1712] rounded-3xl p-5 border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-[#38190C] dark:text-[#FAF3EB] tracking-wide uppercase">BERITA DAN PUBLIKASI</span>
                <span class="text-stone-400 dark:text-stone-500">
                    <svg class="w-4 h-4 text-[#C47247]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <p class="font-serif-title text-3xl font-bold text-[#38190C] dark:text-[#FAF3EB]">{{ $newsCount }}</p>
                <span class="text-xs text-stone-600 dark:text-[#D4C3B5] mt-1 block">Total Berita di CMS</span>
            </div>
        </div>

    </div>

    <!-- Konten Utama: 2 Kolom (Tabel Pengajuan UMKM & Aksi Pintas + Jam Real-time) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Tabel Pengajuan UMKM Masuk Terbaru -->
        <div class="lg:col-span-2 bg-[#FDF8F3] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-5 sm:p-6">
            <div class="border-b border-[#EADBCC]/80 dark:border-[#2A1E17] pb-3 mb-4">
                <h3 class="font-serif-title text-sm sm:text-base font-bold text-[#38190C] dark:text-[#FAF3EB] uppercase tracking-wide">
                    PENGAJUAN UMKM MASUK TERBARU
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-[#EADBCC] dark:border-[#3E2E23] text-[#38190C] dark:text-[#FAF3EB] font-semibold">
                            <th class="pb-3 pr-3 text-[#38190C] dark:text-[#FAF3EB]">Nama Toko</th>
                            <th class="pb-3 px-3 text-[#38190C] dark:text-[#FAF3EB]">Pemilik</th>
                            <th class="pb-3 px-3 text-[#38190C] dark:text-[#FAF3EB]">Kategori</th>
                            <th class="pb-3 px-3 text-center text-[#38190C] dark:text-[#FAF3EB]">Status</th>
                            <th class="pb-3 pl-3 text-right text-[#38190C] dark:text-[#FAF3EB]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADBCC]/60 dark:divide-[#3E2E23] text-stone-700 dark:text-[#D4C3B5]">
                        @forelse($recentUmkms as $umkm)
                        <tr class="hover:bg-white/40 dark:hover:bg-[#251D17]/60 transition">
                            <td class="py-3.5 pr-3 font-semibold text-[#38190C] dark:text-[#FAF3EB] whitespace-nowrap">{{ $umkm->name }}</td>
                            <td class="py-3.5 px-3 whitespace-nowrap text-stone-700 dark:text-[#D4C3B5]">{{ $umkm->owner_name }}</td>
                            <td class="py-3.5 px-3 whitespace-nowrap text-stone-700 dark:text-[#D4C3B5]">{{ $umkm->category }}</td>
                            <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                @if($umkm->status === 'approved')
                                    <span class="px-2.5 py-1 rounded-md text-[11px] bg-[#D1FAE5] text-[#065F46] border border-[#A7F3D0] font-semibold">
                                        Disetujui
                                    </span>
                                @elseif($umkm->status === 'rejected')
                                    <span class="px-2.5 py-1 rounded-md text-[11px] bg-[#FEE2E2] text-[#991B1B] border border-[#FECACA] font-semibold">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md text-[11px] bg-[#FDE8D3] text-[#B45309] border border-[#FCD34D] font-semibold">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 pl-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.umkm.index') }}" class="px-3 py-1 rounded-lg bg-[#E8F5E9] hover:bg-[#C8E6C9] text-[#2E7D32] border border-[#C8E6C9] font-semibold text-xs transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-stone-400 dark:text-stone-500 text-xs">
                                Belum ada pengajuan UMKM masuk saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi Pintas & Waktu Real-Time -->
        <div class="space-y-6">
            
            <!-- Card Aksi Pintas -->
            <div class="bg-[#FDF8F3] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-5 sm:p-6">
                <h3 class="font-serif-title text-base font-bold text-[#38190C] dark:text-[#FAF3EB] mb-4">
                    Aksi Pintas
                </h3>

                <div class="space-y-3">
                    <!-- Tombol Tulis Berita -->
                    <a href="{{ route('admin.news.create') }}" class="flex items-center p-3 rounded-2xl bg-[#FAF4ED] dark:bg-[#1E1712] border border-[#EADBCC] dark:border-[#2A1E17] hover:border-[#C47247] hover:bg-[#F3E7DA] dark:hover:bg-[#281F18] transition text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] shadow-sm group">
                        <span class="w-8 h-8 rounded-xl bg-[#F0E4D5] dark:bg-[#2B2019] text-[#C47247] border border-[#EADBCC] dark:border-[#2A1E17] flex items-center justify-center mr-3 shrink-0 group-hover:scale-105 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </span>
                        <span>Tulis Pengumuman Berita</span>
                    </a>

                    <!-- Tombol Verifikasi UMKM -->
                    <a href="{{ route('admin.umkm.index') }}" class="flex items-center p-3 rounded-2xl bg-[#FAF4ED] dark:bg-[#1E1712] border border-[#EADBCC] dark:border-[#2A1E17] hover:border-[#C47247] hover:bg-[#F3E7DA] dark:hover:bg-[#281F18] transition text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] shadow-sm group">
                        <span class="w-8 h-8 rounded-xl bg-[#F0E4D5] dark:bg-[#2B2019] text-[#C47247] border border-[#EADBCC] dark:border-[#2A1E17] flex items-center justify-center mr-3 shrink-0 group-hover:scale-105 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <span>Verifikasi Pendaftaran UMKM</span>
                    </a>

                    <!-- Tombol Kelola Aspirasi & Layanan -->
                    <a href="{{ route('admin.services.index') }}" class="flex items-center p-3 rounded-2xl bg-[#FAF4ED] dark:bg-[#1E1712] border border-[#EADBCC] dark:border-[#2A1E17] hover:border-[#C47247] hover:bg-[#F3E7DA] dark:hover:bg-[#281F18] transition text-xs font-semibold text-[#38190C] dark:text-[#F8F1EB] shadow-sm group">
                        <span class="w-8 h-8 rounded-xl bg-[#F0E4D5] dark:bg-[#2B2019] text-[#C47247] border border-[#EADBCC] dark:border-[#2A1E17] flex items-center justify-center mr-3 shrink-0 group-hover:scale-105 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </span>
                        <span>Kelola Aspirasi & Layanan Warga</span>
                    </a>
                </div>
            </div>

            <!-- Card Waktu Real-Time (Coklat Gelap Eksklusif Sesuai Screenshot) -->
            <div class="bg-[#38190C] text-[#FFF8F0] rounded-3xl p-5 sm:p-6 shadow-md relative overflow-hidden">
                <div class="relative z-10">
                    <span class="text-[11px] font-bold tracking-widest text-amber-200/90 uppercase block mb-1">
                        WAKTU REAL-TIME
                    </span>
                    
                    <!-- Jam Digital Berdetik Real-time -->
                    <div id="live-clock" class="text-3xl sm:text-4xl font-mono font-bold tracking-widest text-[#FFF8F0] my-2">
                        -- : -- : --
                    </div>

                    <!-- Tanggal Dinamis Real-time -->
                    <div class="flex items-center text-xs text-amber-100/90 mt-2 space-x-2">
                        <svg class="w-4 h-4 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="live-date">Memuat tanggal...</span>
                    </div>
                </div>

                <!-- Subtle Decorative glow -->
                <div class="absolute -right-10 -bottom-10 w-36 h-36 rounded-full bg-[#C47247]/20 blur-2xl pointer-events-none"></div>
            </div>

        </div>

    </div>

</div>

<!-- Script Jam & Tanggal Real-time -->
@push('scripts')
<script>
    function updateLiveDateTime() {
        const now = new Date();

        // Format Waktu: HH : MM : SS
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockEl = document.getElementById('live-clock');
        if (clockEl) {
            clockEl.textContent = `${hours} : ${minutes} : ${seconds}`;
        }

        // Format Tanggal Bahasa Indonesia: Hari, DD Bulan YYYY
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = days[now.getDay()];
        const dayNumber = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();

        const dateEl = document.getElementById('live-date');
        if (dateEl) {
            dateEl.textContent = `${dayName}, ${dayNumber} ${monthName} ${year}`;
        }
    }

    updateLiveDateTime();
    setInterval(updateLiveDateTime, 1000);
</script>
@endpush
@endsection
