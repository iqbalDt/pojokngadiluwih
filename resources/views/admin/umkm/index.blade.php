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
                ⏳ 2 Pengajuan Menunggu
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
                    <!-- Pending Item 1 -->
                    <tr>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Kacang Telur Renyah Bu Sumi</span>
                            <span class="text-[11px] text-slate-400">Diajukan: 13 Okt 2026</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">Siti Sumarni</span>
                            <span class="text-[11px] text-slate-400">3506124809800001</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">Kuliner</span>
                            <span class="text-[11px] text-slate-400">Dusun Wonorejo</span>
                        </td>
                        <td class="p-4 font-mono text-emerald-700">
                            081234567890
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <form action="{{ route('admin.umkm.approve', 1) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-sm">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.umkm.reject', 1) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pendaftaran usaha ini?')">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Pending Item 2 -->
                    <tr>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Keripik Tempe Aneka Rasa</span>
                            <span class="text-[11px] text-slate-400">Diajukan: 11 Okt 2026</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">Sukardi</span>
                            <span class="text-[11px] text-slate-400">3506121504780003</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">Kuliner Olahan</span>
                            <span class="text-[11px] text-slate-400">Dusun Krajan</span>
                        </td>
                        <td class="p-4 font-mono text-emerald-700">
                            082198765432
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <form action="{{ route('admin.umkm.approve', 2) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-sm">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.umkm.reject', 2) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pendaftaran usaha ini?')">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Approved Item -->
                    <tr>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Madu Murni Randu Ngadiluwih</span>
                            <span class="text-[11px] text-slate-400">Diajukan: 01 Okt 2026</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">Ahmad Ridwan</span>
                            <span class="text-[11px] text-slate-400">3506120405850002</span>
                        </td>
                        <td class="p-4">
                            <span class="font-medium text-slate-800 block">Hasil Alam</span>
                            <span class="text-[11px] text-slate-400">Dusun Krajan</span>
                        </td>
                        <td class="p-4 font-mono text-emerald-700">
                            081345678901
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">
                                Terverifikasi
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <span class="text-xs text-slate-400">Tayang di Katalog</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
