@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-emerald-900 via-teal-900 to-slate-900 text-white py-20 lg:py-28 overflow-hidden">
    <!-- Glow Effect -->
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/20 text-emerald-300 text-xs font-semibold mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Portal Resmi Desa Ngadiluwih, Kab. Kediri</span>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                Membangun Desa Cerdas, Mandiri, & Sejahtera.
            </h1>
            <p class="mt-6 text-base sm:text-lg text-slate-300 leading-relaxed">
                Selamat datang di <strong class="text-emerald-400">PojokNgadiluwih</strong>. Akses layanan administrasi desa, temukan produk UMKM lokal terbaik dengan pesan langsung via WhatsApp, dan manfaatkan asisten AI kami.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('services.guides') }}" class="px-6 py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm shadow-lg shadow-emerald-500/25 transition">
                    Panduan Surat Desa
                </a>
                <a href="{{ route('umkm.index') }}" class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-sm backdrop-blur-sm border border-white/10 transition">
                    Jelajahi Produk UMKM
                </a>
                <button type="button" onclick="toggleChatbot()" class="px-6 py-3.5 rounded-xl bg-teal-600/80 hover:bg-teal-600 text-white font-semibold text-sm border border-teal-400/30 transition flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Tanya Asisten AI</span>
                </button>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5">
                <span class="text-xs uppercase text-slate-400 font-semibold tracking-wider">Penduduk</span>
                <p class="text-2xl sm:text-3xl font-extrabold text-white mt-1">6.420+</p>
                <span class="text-[11px] text-emerald-400 mt-1 block">Jiwa terdata</span>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5">
                <span class="text-xs uppercase text-slate-400 font-semibold tracking-wider">UMKM Binaan</span>
                <p class="text-2xl sm:text-3xl font-extrabold text-white mt-1">85+</p>
                <span class="text-[11px] text-emerald-400 mt-1 block">Siap Direct WhatsApp</span>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5">
                <span class="text-xs uppercase text-slate-400 font-semibold tracking-wider">Layanan Surat</span>
                <p class="text-2xl sm:text-3xl font-extrabold text-white mt-1">12+</p>
                <span class="text-[11px] text-emerald-400 mt-1 block">Format & Prosedur Cepat</span>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5">
                <span class="text-xs uppercase text-slate-400 font-semibold tracking-wider">Dusun & RW</span>
                <p class="text-2xl sm:text-3xl font-extrabold text-white mt-1">4 Dusun</p>
                <span class="text-[11px] text-emerald-400 mt-1 block">Wilayah Desa Ngadiluwih</span>
            </div>
        </div>
    </div>
</section>

<!-- Menu Layanan Cepat -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 md:p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <a href="{{ route('services.guides') }}" class="group p-5 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/40 transition">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg group-hover:scale-110 transition">
                📄
            </div>
            <h3 class="font-bold text-slate-800 text-base mt-4 group-hover:text-emerald-700 transition">Panduan Surat</h3>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Tata cara dan syarat permohonan surat keterangan usaha, domisili, dan lainnya.</p>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('umkm.index') }}" class="group p-5 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/40 transition">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg group-hover:scale-110 transition">
                🛍️
            </div>
            <h3 class="font-bold text-slate-800 text-base mt-4 group-hover:text-emerald-700 transition">Katalog UMKM</h3>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Produk kuliner, kerajinan, dan pertanian asli dari warga Ngadiluwih.</p>
        </a>

        <!-- Card 3 -->
        <a href="{{ route('services.store-register') }}" class="group p-5 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/40 transition">
            <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-lg group-hover:scale-110 transition">
                🏪
            </div>
            <h3 class="font-bold text-slate-800 text-base mt-4 group-hover:text-emerald-700 transition">Daftar Toko UMKM</h3>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Daftarkan usaha Anda secara gratis untuk masuk ke direktori digital desa.</p>
        </a>

        <!-- Card 4 -->
        <a href="{{ route('services.feedback') }}" class="group p-5 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/40 transition">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg group-hover:scale-110 transition">
                📢
            </div>
            <h3 class="font-bold text-slate-800 text-base mt-4 group-hover:text-emerald-700 transition">Aspirasi Warga</h3>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Sampaikan saran, masukan, dan pengaduan langsung ke jajaran pemdes.</p>
        </a>
    </div>
</section>

<!-- Berita Terkini Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Kabar Desa</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Berita & Pengumuman Terbaru</h2>
        </div>
        <a href="{{ route('news.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center">
            Lihat Semua Berita
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($latestNews as $item)
        <article class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-44 bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white text-3xl font-bold">
                    📰
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold">{{ $item->category ?? 'Kegiatan Desa' }}</span>
                        <span>•</span>
                        <span>{{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d F Y') }}</span>
                    </div>
                    <h3 class="font-bold text-base text-slate-900 hover:text-emerald-600 transition">
                        <a href="{{ route('news.show', $item->slug) }}">
                            {{ $item->title }}
                        </a>
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 line-clamp-2">
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
        <div class="col-span-3 text-center py-8 bg-white rounded-2xl border border-slate-200">
            <p class="text-xs text-slate-500">Belum ada berita yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- UMKM Unggulan Section -->
<section class="bg-slate-100/70 py-16 border-y border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Potensi Lokal</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Produk Unggulan UMKM Ngadiluwih</h2>
            </div>
            <a href="{{ route('umkm.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center">
                Buka Direktori UMKM
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredUmkm as $item)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                <div>
                    <div class="w-full h-36 bg-gradient-to-tr from-amber-50 to-emerald-50 rounded-xl flex items-center justify-center text-4xl mb-4 border border-slate-100">
                        🛍️
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">{{ $item->category }}</span>
                        <span class="text-[11px] text-slate-400">Dusun {{ $item->dusun }}</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm mt-2 line-clamp-1">
                        <a href="{{ route('umkm.show', $item->slug) }}" class="hover:text-emerald-600 transition">
                            {{ $item->name }}
                        </a>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                    @if($item->price)
                        <p class="text-emerald-700 font-extrabold text-sm mt-2">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                            <span class="text-xs text-slate-400 font-normal">/ {{ $item->price_unit ?? 'pcs' }}</span>
                        </p>
                    @else
                        <p class="text-emerald-700 font-bold text-xs mt-2">Hubungi Penjual</p>
                    @endif
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('umkm.show', $item->slug) }}" class="text-xs text-slate-600 hover:text-emerald-600 font-medium">Detail</a>
                    <a href="{{ $item->whatsapp_order_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center space-x-1 shadow-sm transition">
                        <span>Pesan via WA</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-8 bg-white rounded-2xl border border-slate-200">
                <p class="text-xs text-slate-500">Belum ada UMKM yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Banner Asisten AI -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="relative rounded-3xl bg-gradient-to-r from-emerald-800 to-teal-800 text-white p-8 sm:p-12 overflow-hidden shadow-xl">
        <div class="relative z-10 max-w-2xl">
            <span class="px-3 py-1 rounded-full bg-white/20 text-xs font-semibold tracking-wide uppercase">Fitur Cerdas AI</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold mt-4">Butuh Bantuan Administrasi & Informasi Cepat?</h2>
            <p class="mt-3 text-emerald-100 text-sm leading-relaxed">
                Asisten AI PojokNgadiluwih siap menjawab pertanyaan Anda seputar syarat dokumen, jam buka kantor balai desa, hingga info produk UMKM warga selama 24 jam nonstop.
            </p>
            <div class="mt-6">
                <button onclick="toggleChatbot()" class="px-6 py-3 rounded-xl bg-white text-emerald-900 font-bold text-xs shadow-md hover:bg-emerald-50 transition inline-flex items-center space-x-2">
                    <span>Mulai Percakapan dengan AI</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
@endsection
