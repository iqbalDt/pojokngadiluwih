@extends('layouts.admin')

@section('title', 'Verifikasi Pengajuan Toko UMKM')
@section('header_title', 'Verifikasi & Kurasi Toko UMKM')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pengajuan Pendaftaran Toko UMKM</h2>
            <p class="text-xs text-slate-500 mt-1">Verifikasi identitas usaha warga sebelum dipublikasikan ke katalog umum.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">
                ⏳ {{ $pendingCount }} Pengajuan Menunggu
            </span>
        </div>
    </div>

    <!-- Table of Pending & Approved UMKM -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-medium bg-slate-50/50">
                        <th class="p-4">Nama Toko & Usaha</th>
                        <th class="p-4">Pemilik & NIK</th>
                        <th class="p-4">Kategori & Dusun</th>
                        <th class="p-4">WhatsApp</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($umkms as $item)
                    <tr>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">{{ $item->name }}</span>
                            <span class="text-[11px] text-slate-400">Diajukan: {{ $item->created_at->translatedFormat('d M Y') }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">{{ $item->owner_name }}</span>
                            <span class="text-[11px] text-slate-400">{{ $item->nik }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">{{ $item->category }}</span>
                            <span class="text-[11px] text-slate-400">Dusun {{ $item->dusun }}</span>
                        </td>
                        <td class="p-4 font-mono text-emerald-700">
                            {{ $item->whatsapp }}
                        </td>
                        <td class="p-4">
                            @if($item->status === 'approved')
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">
                                    Terverifikasi
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
                        <td class="p-4 text-right space-x-2">
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
                            @elseif($item->status === 'approved')
                                <span class="text-xs text-emerald-600 font-medium">Tayang di Katalog</span>
                                <form action="{{ route('admin.umkm.reject', $item->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Cabut verifikasi usaha ini?')">
                                    @csrf
                                    <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-semibold">Tarik</button>
                                </form>
                            @else
                                <form action="{{ route('admin.umkm.approve', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold">Setujui Ulang</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                            Belum ada pendaftaran toko UMKM.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($umkms->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $umkms->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
