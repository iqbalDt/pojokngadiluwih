@extends('layouts.app')

@section('title', $umkm->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('umkm.index') }}" class="hover:text-emerald-600">Katalog UMKM</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold truncate">{{ $umkm->name }}</span>
    </nav>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-10">
        <!-- Product Image Placeholder -->
        <div class="flex flex-col items-center justify-center bg-gradient-to-tr from-amber-50 to-emerald-50 rounded-2xl border border-slate-200/60 p-10 min-h-80">
            <div class="text-8xl mb-4">🛍️</div>
            <span class="text-xs text-slate-500 font-medium">Katalog Resmi UMKM Desa Ngadiluwih</span>
        </div>

        <!-- Product Details -->
        <div class="flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">{{ $umkm->category }}</span>
                    <span class="text-xs text-slate-400">Dusun {{ $umkm->dusun }}</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3">
                    {{ $umkm->name }}
                </h1>

                <div class="mt-4 flex items-baseline space-x-3">
                    @if($umkm->price)
                        <span class="text-3xl font-black text-emerald-600">
                            Rp {{ number_format($umkm->price, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-slate-400">/ {{ $umkm->price_unit ?? 'pcs' }}</span>
                    @else
                        <span class="text-2xl font-bold text-emerald-600">Harga Menyesuaikan Pesanan</span>
                    @endif
                </div>

                <div class="mt-6 border-t border-slate-100 pt-4 space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Deskripsi Produk & Usaha</h2>
                    <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $umkm->description }}
                    </p>
                </div>

                <div class="mt-6 border-t border-slate-100 pt-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Informasi Toko / Penjual</h3>
                    <div class="bg-slate-50 rounded-xl p-3 text-xs space-y-1 text-slate-600">
                        <p><strong class="text-slate-800">Nama Usaha:</strong> {{ $umkm->name }}</p>
                        <p><strong class="text-slate-800">Pemilik:</strong> {{ $umkm->owner_name }}</p>
                        <p><strong class="text-slate-800">Lokasi / Alamat:</strong> {{ $umkm->address }}, Dusun {{ $umkm->dusun }}</p>
                        <p><strong class="text-slate-800">WhatsApp:</strong> {{ $umkm->whatsapp }}</p>
                    </div>
                </div>
            </div>

            <!-- Direct-to-WA Order Button -->
            <div class="mt-8 pt-6 border-t border-slate-200">
                <a href="{{ $umkm->whatsapp_order_url }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/25 flex items-center justify-center space-x-2 transition">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi & Pesan Langsung via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
