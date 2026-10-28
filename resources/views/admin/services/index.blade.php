@extends('layouts.admin')

@section('title', 'Arsip & Pengelolaan Layanan')
@section('header_title', 'Arsip Pengajuan Layanan & Aspirasi Warga')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pengelolaan Layanan Publik & Aspirasi</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar aspirasi, pengaduan, dan permohonan masuk dari masyarakat.</p>
        </div>
        <div class="flex items-center space-x-2 text-xs">
            <span class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-medium">
                Total Masuk: <strong>{{ $totalCount }} Berkas / Pesan</strong>
            </span>
        </div>
    </div>

    <!-- Table of Submissions and Aspirations -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Search and Filter Bar -->
        <form method="GET" action="{{ route('admin.services.index') }}" class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pemohon atau subjek aspirasi..." class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 flex-1 focus:outline-none focus:ring-1 focus:ring-emerald-500 bg-white">
            <select name="status" onchange="this.form.submit()" class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none bg-white text-slate-700">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Tindak Lanjut</option>
                <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
            @if(request('q') || request('status'))
                <a href="{{ route('admin.services.index') }}" class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 flex items-center justify-center">Reset</a>
            @endif
        </form>

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
                    @forelse($aspirations as $item)
                    <tr>
                        <td class="p-4 text-slate-500 whitespace-nowrap">
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">
                                {{ $item->public_display_name }}
                            </span>
                            <span class="text-[11px] text-slate-400">
                                Dusun {{ $item->dusun }} • {{ $item->is_anonymous ? 'Kontak Dirahasiakan' : $item->phone }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-semibold text-[10px]">Aspirasi Warga</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">{{ $item->category }}</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <p class="font-medium text-slate-800 line-clamp-1">{{ $item->title }}</p>
                            <p class="text-[11px] text-slate-500 line-clamp-2">{{ $item->message }}</p>
                        </td>
                        <td class="p-4">
                            @if($item->status === 'processed')
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-teal-100 text-teal-800 font-bold">
                                    Sedang Diproses
                                </span>
                            @elseif($item->status === 'completed')
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">
                                    Selesai
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold">
                                    Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if($item->status === 'pending')
                                <form action="{{ route('admin.services.status', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="processed">
                                    <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold text-xs transition">
                                        Tandai Diproses
                                    </button>
                                </form>
                            @elseif($item->status === 'processed')
                                <form action="{{ route('admin.services.status', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 font-semibold text-xs shadow-sm transition">
                                        Tandai Selesai
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">Selesai / Diarsipkan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                            Belum ada aspirasi atau pengaduan masyarakat yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($aspirations->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $aspirations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
