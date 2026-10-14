@extends('layouts.admin')

@section('title', 'Arsip & Pengelolaan Layanan')
@section('header_title', 'Arsip Pengajuan Layanan & Aspirasi Warga')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pengelolaan Layanan Publik & Aspirasi</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar aspirasi, pengaduan, dan permohonan surat masuk dari masyarakat.</p>
        </div>
        <div class="flex items-center space-x-2 text-xs">
            <span class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-medium">
                Total Masuk: <strong>24 Berkas</strong>
            </span>
        </div>
    </div>

    <!-- Table of Submissions and Aspirations -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row gap-3">
            <input type="text" placeholder="Cari nama pemohon atau subjek aspirasi..." class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 flex-1 focus:outline-none focus:ring-1 focus:ring-emerald-500 bg-white">
            <select class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none bg-white text-slate-700">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu Tindak Lanjut</option>
                <option value="processed">Sedang Diproses</option>
                <option value="completed">Selesai</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-medium bg-slate-50/50">
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Pemohon / Warga</th>
                        <th class="p-4">Jenis & Kategori</th>
                        <th class="p-4">Rincian Aspirasi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Item 1 -->
                    <tr>
                        <td class="p-4 text-slate-500 whitespace-nowrap">14 Okt 2026</td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Joko Prasetyo</span>
                            <span class="text-[11px] text-slate-400">Dusun Wonorejo • 08123444555</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-semibold text-[10px]">Aspirasi Warga</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Infrastruktur & Jalan</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <p class="font-medium text-slate-800 line-clamp-1">Perbaikan Lampu Penerangan Jalan</p>
                            <p class="text-[11px] text-slate-500 line-clamp-1">Lampu jalan RT 02 Dusun Wonorejo padam sejak seminggu lalu.</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold">
                                Menunggu
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.services.status', 1) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold text-xs">
                                    Tandai Diproses
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Item 2 -->
                    <tr>
                        <td class="p-4 text-slate-500 whitespace-nowrap">13 Okt 2026</td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Dwi Lestari</span>
                            <span class="text-[11px] text-slate-400">Dusun Sukorejo • 08567888999</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 font-semibold text-[10px]">Aspirasi Warga</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Irigasi & Pertanian</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <p class="font-medium text-slate-800 line-clamp-1">Pembersihan Sampah Saluran Sawah</p>
                            <p class="text-[11px] text-slate-500 line-clamp-1">Saluran irigasi barat tersumbat tumpukan ranting pohon.</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-teal-100 text-teal-800 font-bold">
                                Sedang Diproses
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.services.status', 2) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 font-semibold text-xs shadow-sm">
                                    Tandai Selesai
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Item 3 -->
                    <tr>
                        <td class="p-4 text-slate-500 whitespace-nowrap">10 Okt 2026</td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Kurniawan</span>
                            <span class="text-[11px] text-slate-400">Dusun Krajan</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-semibold text-[10px]">Layanan Surat</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Surat Keterangan Usaha</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <p class="font-medium text-slate-800 line-clamp-1">Permohonan SKU Toko Kelontong</p>
                            <p class="text-[11px] text-slate-500 line-clamp-1">Untuk kelengkapan pengajuan izin mikro.</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">
                                Selesai
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <span class="text-xs text-slate-400">Diarsipkan</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
