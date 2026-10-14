@extends('layouts.admin')

@section('title', 'Manajemen Berita & Pengumuman')
@section('header_title', 'CMS Berita & Pengumuman Desa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Publikasi Berita</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola artikel, dokumentasi kegiatan, dan pengumuman resmi desa.</p>
        </div>
        <div>
            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Berita Baru
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row gap-3">
            <input type="text" placeholder="Cari judul berita..." class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 flex-1 focus:outline-none focus:ring-1 focus:ring-emerald-500 bg-white">
            <select class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none bg-white text-slate-700">
                <option value="">Semua Kategori</option>
                <option value="Kegiatan">Kegiatan Desa</option>
                <option value="Pengumuman">Pengumuman</option>
                <option value="Pembangunan">Pembangunan</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-medium bg-slate-50/50">
                        <th class="p-4">Judul Berita</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Tanggal Rilis</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="p-4 font-semibold text-slate-900">Pelatihan Digitalisasi & Pemasaran Online bagi UMKM Desa Ngadiluwih</td>
                        <td class="p-4"><span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold">Kegiatan</span></td>
                        <td class="p-4 text-slate-500">12 Oktober 2026</td>
                        <td class="p-4"><span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">Terbit</span></td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.news.edit', 1) }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600">Edit</a>
                            <form action="{{ route('admin.news.destroy', 1) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 font-semibold text-slate-900">Jadwal Posyandu Balita dan Pemeriksaan Kesehatan Lansia Bulan Ini</td>
                        <td class="p-4"><span class="px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-700 text-[11px] font-semibold">Pengumuman</span></td>
                        <td class="p-4 text-slate-500">08 Oktober 2026</td>
                        <td class="p-4"><span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">Terbit</span></td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.news.edit', 2) }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600">Edit</a>
                            <form action="{{ route('admin.news.destroy', 2) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 font-semibold text-slate-900">Peningkatan Saluran Irigasi Pertanian di Wilayah Persawahan Ngadiluwih</td>
                        <td class="p-4"><span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[11px] font-semibold">Pembangunan</span></td>
                        <td class="p-4 text-slate-500">01 Oktober 2026</td>
                        <td class="p-4"><span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">Terbit</span></td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.news.edit', 3) }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600">Edit</a>
                            <form action="{{ route('admin.news.destroy', 3) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
