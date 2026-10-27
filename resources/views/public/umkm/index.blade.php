@extends('layouts.app')

@section('title', 'Katalog UMKM Desa Ngadiluwih')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Pemberdayaan Ekonomi</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Sentra & Katalog UMKM Ngadiluwih</h1>
                <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                    Dukung produk karya warga desa. Pesan langsung ke penjual via WhatsApp tanpa perantara.
                </p>
            </div>
            <div>
                <a href="{{ route('services.store-register') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Daftarkan Usaha Anda
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <form method="GET" action="{{ route('umkm.index') }}" class="mt-8 flex flex-col sm:flex-row gap-3">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk UMKM, nama toko, atau dusun..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="flex gap-2 overflow-x-auto text-xs">
                <a href="{{ route('umkm.index', array_filter(['q' => request('q')])) }}" class="px-4 py-2.5 rounded-xl {{ !request('category') ? 'bg-emerald-600 text-white font-semibold' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Semua Kategori</a>
                <a href="{{ route('umkm.index', array_filter(['category' => 'Kuliner & Camilan', 'q' => request('q')])) }}" class="px-4 py-2.5 rounded-xl {{ request('category') === 'Kuliner & Camilan' ? 'bg-emerald-600 text-white font-semibold' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Kuliner & Camilan</a>
                <a href="{{ route('umkm.index', array_filter(['category' => 'Pertanian & Hasil Alam', 'q' => request('q')])) }}" class="px-4 py-2.5 rounded-xl {{ request('category') === 'Pertanian & Hasil Alam' ? 'bg-emerald-600 text-white font-semibold' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Pertanian & Hasil Alam</a>
                <a href="{{ route('umkm.index', array_filter(['category' => 'Kerajinan Tangan', 'q' => request('q')])) }}" class="px-4 py-2.5 rounded-xl {{ request('category') === 'Kerajinan Tangan' ? 'bg-emerald-600 text-white font-semibold' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Kerajinan Tangan</a>
                <a href="{{ route('umkm.index', array_filter(['category' => 'Jasa & Servis Lokal', 'q' => request('q')])) }}" class="px-4 py-2.5 rounded-xl {{ request('category') === 'Jasa & Servis Lokal' ? 'bg-emerald-600 text-white font-semibold' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Jasa Lokal</a>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($umkms as $item)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition">
            <div>
                <div class="w-full h-40 bg-gradient-to-tr from-amber-50 to-emerald-50 rounded-xl flex items-center justify-center text-5xl mb-4 border border-slate-100">
                    🛍️
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">{{ $item->category }}</span>
                    <span class="text-[11px] text-slate-400">Dusun {{ $item->dusun }}</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base mt-2 line-clamp-1">
                    <a href="{{ route('umkm.show', $item->slug) }}" class="hover:text-emerald-600 transition">
                        {{ $item->name }}
                    </a>
                </h3>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                @if($item->price)
                    <p class="text-emerald-700 font-extrabold text-base mt-2">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                        <span class="text-xs text-slate-400 font-normal">/ {{ $item->price_unit ?? 'pcs' }}</span>
                    </p>
                @else
                    <p class="text-emerald-700 font-bold text-xs mt-2">Hubungi Penjual</p>
                @endif
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('umkm.show', $item->slug) }}" class="text-xs text-slate-600 hover:text-emerald-600 font-medium">Detail Produk</a>
                <a href="{{ $item->whatsapp_order_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition inline-flex items-center">
                    <span>Pesan via WA</span>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-500 text-sm">Belum ada usaha UMKM yang cocok dengan pencarian Anda.</p>
            <a href="{{ route('umkm.index') }}" class="mt-3 inline-block text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua UMKM</a>
        </div>
        @endforelse
    </div>

    <!-- Navigasi Halaman (Pagination) -->
    <div class="mt-10">
        {{ $umkms->links() }}
    </div>
</div>
@endsection
