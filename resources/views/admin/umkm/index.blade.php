@extends('layouts.admin')

@section('title', 'Kelola & Kurasi Toko UMKM')
@section('header_title', 'Kelola & Kurasi Toko UMKM')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen & Kurasi Katalog UMKM</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data toko UMKM desa, verifikasi pengajuan warga, perbarui harga, dan unggah foto produk.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">
                {{ $pendingCount }} Pengajuan Menunggu
            </span>
            <span class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ $approvedCount }} Toko Aktif
            </span>
        </div>
    </div>

    <!-- Filter Tab Status -->
    <div class="flex items-center space-x-2 border-b border-slate-200 pb-3 text-xs overflow-x-auto">
        <a href="{{ route('admin.umkm.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl font-semibold transition whitespace-nowrap {{ ($currentStatus ?? 'pending') === 'pending' ? 'bg-amber-100 text-amber-900 shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Menunggu Verifikasi ({{ $pendingCount }})
        </a>
        <a href="{{ route('admin.umkm.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl font-semibold transition whitespace-nowrap {{ ($currentStatus ?? '') === 'approved' ? 'bg-emerald-100 text-emerald-900 shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Aktif di Publik ({{ $approvedCount }})
        </a>
        <a href="{{ route('admin.umkm.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl font-semibold transition whitespace-nowrap {{ ($currentStatus ?? '') === 'rejected' ? 'bg-rose-100 text-rose-900 shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Ditolak
        </a>
        <a href="{{ route('admin.umkm.index', ['status' => 'all']) }}" class="px-4 py-2 rounded-xl font-semibold transition whitespace-nowrap {{ ($currentStatus ?? '') === 'all' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Semua Toko
        </a>
    </div>

    <!-- Table of UMKM -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-medium bg-slate-50/50">
                        <th class="p-4">Nama Toko & Usaha</th>
                        <th class="p-4">Pemilik & NIK</th>
                        <th class="p-4">Kategori & Dusun</th>
                        <th class="p-4">Harga / Satuan</th>
                        <th class="p-4">WhatsApp</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($umkms as $item)
                    <tr>
                        <td class="p-4">
                            <div class="flex items-center space-x-3">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-lg shrink-0 border border-slate-200">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100 text-sm">
                                        🛍️
                                    </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $item->name }}</span>
                                    <span class="text-[11px] text-slate-400">Diajukan: {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">{{ $item->owner_name }}</span>
                            <span class="text-[11px] text-slate-400">{{ $item->nik }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">{{ $item->category }}</span>
                            <span class="text-[11px] text-slate-400">Dusun {{ $item->dusun }}</span>
                        </td>
                        <td class="p-4 font-semibold text-slate-800">
                            @if($item->price)
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                <span class="text-[10px] text-slate-400 font-normal">/ {{ $item->price_unit ?? 'pcs' }}</span>
                            @else
                                <span class="text-slate-400 font-normal italic">Menyesuaikan</span>
                            @endif
                        </td>
                        <td class="p-4 font-mono text-emerald-700">
                            {{ $item->whatsapp }}
                        </td>
                        <td class="p-4">
                            @if($item->status === 'approved')
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">
                                    Aktif di Publik
                                </span>
                            @elseif($item->status === 'rejected')
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-100 text-rose-800 font-bold">
                                    Ditolak
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold">
                                    Menunggu Verifikasi
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                            @if($item->status === 'pending')
                                <form action="{{ route('admin.umkm.approve', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-sm transition">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.umkm.reject', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pendaftaran usaha ini?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs transition">
                                        Tolak
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.umkm.edit', $item->id) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 font-semibold text-xs transition inline-block">
                                Edit
                            </a>

                            <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data toko ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1.5 rounded-lg text-rose-600 hover:bg-rose-50 font-semibold text-xs transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 text-xs">
                            Tidak ada data toko UMKM pada filter ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($umkms->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $umkms->appends(['status' => $currentStatus])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
