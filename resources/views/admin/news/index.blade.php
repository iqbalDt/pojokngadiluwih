@extends('layouts.admin')

@section('title', 'CMS Berita dan Informasi')
@section('search_placeholder', 'Cari judul berita yang diinginkan')

@section('content')
<div class="space-y-6">

    <!-- Baris Filter Kategori & Tombol Tambah Berita (Persis Screenshot) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <!-- Filter Pills Kategori -->
        <div class="flex flex-wrap items-center gap-2.5">
            <button 
                type="button" 
                onclick="filterNewsCategory('all', this)"
                class="category-filter-btn px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 bg-[#38190C] text-white shadow-sm"
                data-category="all"
            >
                Semua Kategori
            </button>
            <button 
                type="button" 
                onclick="filterNewsCategory('Kegiatan', this)"
                class="category-filter-btn px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]"
                data-category="Kegiatan"
            >
                Kegiatan
            </button>
            <button 
                type="button" 
                onclick="filterNewsCategory('Pengumuman', this)"
                class="category-filter-btn px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]"
                data-category="Pengumuman"
            >
                Pengumuman
            </button>
            <button 
                type="button" 
                onclick="filterNewsCategory('Lainnya', this)"
                class="category-filter-btn px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]"
                data-category="Lainnya"
            >
                Lainnya
            </button>
        </div>

        <!-- Tombol Tambah Berita Terracotta (Persis Screenshot) -->
        <div class="shrink-0">
            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl bg-[#C07044] hover:bg-[#B06035] text-white text-xs font-semibold shadow-md shadow-[#C07044]/25 transition duration-150">
                <span>+ Tambah Berita</span>
            </a>
        </div>
    </div>

    <!-- Container Card Krem Tabel Berita (Persis Screenshot) -->
    <div class="bg-[#FBF4EC] rounded-3xl border border-[#EADBCC] shadow-sm p-6 sm:p-8 overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs min-w-[640px]">
                <thead>
                    <tr class="border-b border-[#EADBCC] text-[#38190C] font-serif-title font-bold text-xs sm:text-sm">
                        <th class="pb-4 pr-4 pl-1 w-[38%]">Judul Berita</th>
                        <th class="pb-4 px-4 w-[20%]">Kategori</th>
                        <th class="pb-4 px-4 w-[18%]">Tanggal Rilis</th>
                        <th class="pb-4 px-4 w-[12%]">Status</th>
                        <th class="pb-4 pl-4 pr-1 w-[12%] text-right sm:text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="news-table-body" class="divide-y divide-[#EADBCC]/70 text-stone-700">
                    @php $renderedRows = 0; @endphp
                    @forelse($news as $item)
                        @php 
                            $renderedRows++; 
                            $cat = $item->category ?? 'Lainnya';
                            $statusLabel = match($item->status ?? 'published') {
                                'published' => 'Terbit',
                                'draft' => 'Draft',
                                default => 'Arsip'
                            };
                        @endphp
                        <tr class="news-row hover:bg-[#F5ECE1]/60 dark:hover:bg-[#251D17]/60 transition" data-category="{{ $cat }}" data-title="{{ strtolower($item->title) }}">
                            <!-- Judul Berita -->
                            <td class="py-4 pr-4 pl-1 text-[#38190C] font-normal leading-relaxed">
                                {{ $item->title }}
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-4 text-stone-600 font-normal">
                                {{ str_contains(strtolower($cat), 'kegiatan') ? 'Kegiatan Desa' : $cat }}
                            </td>

                            <!-- Tanggal Rilis -->
                            <td class="py-4 px-4 text-stone-600 font-normal whitespace-nowrap">
                                {{ $item->published_at ? $item->published_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-stone-600 font-normal">
                                {{ $statusLabel }}
                            </td>

                            <!-- Aksi Edit | Hapus -->
                            <td class="py-4 pl-4 pr-1 text-right sm:text-center whitespace-nowrap">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="text-stone-600 hover:text-[#C07044] font-medium transition text-xs">
                                    Edit
                                </a>
                                <span class="text-stone-400 mx-1.5 font-light">|</span>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-700 font-bold transition text-xs cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-news-row">
                            <td colspan="5" class="py-8 text-center text-stone-400 text-xs">
                                Belum ada berita atau pengumuman yang diterbitkan.
                            </td>
                        </tr>
                    @endforelse

                    <!-- Baris-Baris Bergaris Elegan (Lined Ledger) Sesuai Desain Screenshot -->
                    @for($i = $renderedRows; $i < 8; $i++)
                        <tr class="empty-ledger-line pointer-events-none">
                            <td class="py-4 pr-4 pl-1 text-transparent select-none">&nbsp;</td>
                            <td class="py-4 px-4 text-transparent select-none">&nbsp;</td>
                            <td class="py-4 px-4 text-transparent select-none">&nbsp;</td>
                            <td class="py-4 px-4 text-transparent select-none">&nbsp;</td>
                            <td class="py-4 pl-4 pr-1 text-transparent select-none">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Pagination jika halaman banyak -->
        @if(method_exists($news, 'hasPages') && $news->hasPages())
        <div class="pt-6 border-t border-[#EADBCC]/80 mt-2">
            {{ $news->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Script Filter Kategori & Pencarian Real-Time Sesuai Screenshot -->
@push('scripts')
<script>
    let activeCategory = 'all';

    function filterNewsCategory(category, clickedBtn) {
        activeCategory = category;

        // Update styling tombol filter kategori
        document.querySelectorAll('.category-filter-btn').forEach(btn => {
            btn.classList.remove('bg-[#38190C]', 'text-white', 'shadow-sm');
            btn.classList.add('bg-[#FDF7F0]', 'text-[#38190C]', 'border', 'border-[#EADBCC]');
        });

        if (clickedBtn) {
            clickedBtn.classList.remove('bg-[#FDF7F0]', 'text-[#38190C]', 'border', 'border-[#EADBCC]');
            clickedBtn.classList.add('bg-[#38190C]', 'text-white', 'shadow-sm');
        }

        applyNewsFilters();
    }

    function applyNewsFilters() {
        const searchInput = document.getElementById('admin-search-input');
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const rows = document.querySelectorAll('.news-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowCat = row.getAttribute('data-category') || '';
            const rowTitle = row.getAttribute('data-title') || '';

            const matchesCategory = (activeCategory === 'all') || 
                (activeCategory === 'Kegiatan' && rowCat.toLowerCase().includes('kegiatan')) ||
                (activeCategory === 'Pengumuman' && rowCat.toLowerCase().includes('pengumuman')) ||
                (activeCategory === 'Lainnya' && !rowCat.toLowerCase().includes('kegiatan') && !rowCat.toLowerCase().includes('pengumuman'));

            const matchesSearch = query === '' || rowTitle.includes(query);

            if (matchesCategory && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Hubungkan Search Input di Topbar
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('admin-search-input');
        if (searchInput) {
            searchInput.addEventListener('input', applyNewsFilters);
        }
    });
</script>
@endpush
@endsection
