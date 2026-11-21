import React, { useState, useMemo } from 'react';
import { Search, X, Clock, CheckCircle2 } from 'lucide-react';

export default function AdminUmkmPage({ initialData = {} }) {
    const umkmsList = initialData.umkms || [];
    const pendingCount = initialData.pendingCount ?? 0;
    const approvedCount = initialData.approvedCount ?? 0;
    const initialStatus = initialData.currentStatus || 'pending';
    const csrfToken = initialData.csrfToken || (typeof document !== 'undefined' ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') : '') || '';
    const routes = initialData.routes || {};

    const [statusFilter, setStatusFilter] = useState(initialStatus);
    const [searchQuery, setSearchQuery] = useState('');

    // Filter daftar UMKM berdasarkan status tab dan search query secara realtime
    const filteredUmkms = useMemo(() => {
        return umkmsList.filter((item) => {
            // Filter Status
            const matchesStatus =
                statusFilter === 'all' ||
                (statusFilter === 'pending' && item.status === 'pending') ||
                (statusFilter === 'approved' && item.status === 'approved') ||
                (statusFilter === 'rejected' && item.status === 'rejected');

            // Search Query
            const q = searchQuery.toLowerCase().trim();
            const matchesSearch =
                q === '' ||
                (item.name && item.name.toLowerCase().includes(q)) ||
                (item.owner_name && item.owner_name.toLowerCase().includes(q)) ||
                (item.category && item.category.toLowerCase().includes(q)) ||
                (item.dusun && item.dusun.toLowerCase().includes(q)) ||
                (item.products && item.products.toLowerCase().includes(q)) ||
                (item.whatsapp && item.whatsapp.toLowerCase().includes(q));

            return matchesStatus && matchesSearch;
        });
    }, [umkmsList, statusFilter, searchQuery]);

    // Format tanggal rilis / pengajuan
    const formatDate = (dateStr) => {
        if (!dateStr) return '-';
        try {
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        } catch {
            return dateStr;
        }
    };

    return (
        <div className="space-y-6">
            
            {/* Baris Pencarian, Filter Pills & Badges Statistik Cepat */}
            <div className="space-y-4">
                
                {/* Baris Atas: Input Pencarian Panjang & Badges Statistik dari Gambar 2 */}
                <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    {/* Search Input Pill Panjang Sesuai Gambar 1 */}
                    <div className="relative w-full max-w-xl">
                        <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#C07044]">
                            <Search className="w-4 h-4 text-[#C07044]" />
                        </div>
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            placeholder="Cari data UMKM yang diinginkan"
                            className="w-full pl-11 pr-5 py-3 rounded-full bg-[#FDF7F0] border border-[#EADBCC] text-xs sm:text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] transition shadow-inner"
                        />
                        {searchQuery && (
                            <button
                                type="button"
                                onClick={() => setSearchQuery('')}
                                className="absolute inset-y-0 right-0 pr-4 flex items-center text-stone-400 hover:text-stone-600"
                            >
                                <X className="w-4 h-4" />
                            </button>
                        )}
                    </div>

                    {/* 2 Badges Statistik Cepat (Tambahan Bagian dari Gambar 2) */}
                    <div className="flex items-center gap-2.5 shrink-0">
                        {/* 1 Pengajuan Menunggu */}
                        <div className="px-4 py-2 rounded-2xl bg-[#FEF9EE] border border-[#FDE68A] text-[#B45309] font-medium text-xs flex items-center gap-1.5 shadow-sm">
                            <Clock className="w-3.5 h-3.5 text-[#D97706]" />
                            <span>{pendingCount} Pengajuan Menunggu</span>
                        </div>

                        {/* 7 Toko Aktif */}
                        <div className="px-4 py-2 rounded-2xl bg-[#ECFDF5] border border-[#A7F3D0] text-[#059669] font-medium text-xs flex items-center gap-1.5 shadow-sm">
                            <CheckCircle2 className="w-3.5 h-3.5 text-[#059669]" />
                            <span>{approvedCount} Toko Aktif</span>
                        </div>
                    </div>
                </div>

                {/* Baris Bawah: Pills Filter Status Sesuai Gambar 1 */}
                <div className="flex flex-wrap items-center gap-2.5 pt-1">
                    {/* Menunggu Verifikasi */}
                    <button
                        type="button"
                        onClick={() => setStatusFilter('pending')}
                        className={`px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 cursor-pointer ${
                            statusFilter === 'pending'
                                ? 'bg-[#FCE8D3] text-[#B45309] border border-[#FCD34D] shadow-sm'
                                : 'bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]'
                        }`}
                    >
                        Menunggu Verifikasi ({pendingCount})
                    </button>

                    {/* Aktif di Publik */}
                    <button
                        type="button"
                        onClick={() => setStatusFilter('approved')}
                        className={`px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 cursor-pointer ${
                            statusFilter === 'approved'
                                ? 'bg-[#D1FAE5] text-[#065F46] border border-[#A7F3D0] shadow-sm'
                                : 'bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]'
                        }`}
                    >
                        Aktif di Publik ({approvedCount})
                    </button>

                    {/* Ditolak */}
                    <button
                        type="button"
                        onClick={() => setStatusFilter('rejected')}
                        className={`px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 cursor-pointer ${
                            statusFilter === 'rejected'
                                ? 'bg-[#FEE2E2] text-[#991B1B] border border-[#FECACA] shadow-sm'
                                : 'bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]'
                        }`}
                    >
                        Ditolak
                    </button>

                    {/* Semua Toko */}
                    <button
                        type="button"
                        onClick={() => setStatusFilter('all')}
                        className={`px-5 py-2.5 rounded-2xl text-xs font-semibold transition duration-150 cursor-pointer ${
                            statusFilter === 'all'
                                ? 'bg-[#38190C] text-white shadow-sm'
                                : 'bg-[#FDF7F0] text-[#38190C] border border-[#EADBCC] hover:bg-[#F5ECE1]'
                        }`}
                    >
                        Semua Toko
                    </button>
                </div>
            </div>

            {/* Container Card Krem Tabel UMKM Sesuai Gambar 1 + Aksi Gambar 2 */}
            <div className="bg-[#FBF4EC] rounded-3xl border border-[#EADBCC] shadow-sm p-6 sm:p-8 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-xs min-w-[760px]">
                        <thead>
                            <tr className="border-b border-[#EADBCC] text-[#38190C] font-serif font-bold text-xs sm:text-sm">
                                <th className="pb-4 pr-3 pl-1 w-[22%]">Nama Toko & Usaha</th>
                                <th className="pb-4 px-3 w-[16%]">Pemilik & NIK</th>
                                <th className="pb-4 px-3 w-[14%]">Kategori & Dusun</th>
                                <th className="pb-4 px-3 w-[18%]">Daftar Produk</th>
                                <th className="pb-4 px-3 w-[12%]">Whatsapp</th>
                                <th className="pb-4 px-3 w-[10%]">Status</th>
                                <th className="pb-4 pl-3 pr-1 w-[18%] text-right sm:text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-[#EADBCC]/70 text-stone-700">
                            {filteredUmkms.map((item) => (
                                <tr key={item.id} className="hover:bg-white/40 transition">
                                    {/* Nama Toko & Usaha */}
                                    <td className="py-4 pr-3 pl-1">
                                        <span className="font-bold text-[#38190C] block text-xs sm:text-sm">
                                            {item.name}
                                        </span>
                                        <span className="text-[11px] text-stone-400 block mt-0.5">
                                            Diajukan: {formatDate(item.created_at)}
                                        </span>
                                    </td>

                                    {/* Pemilik & NIK */}
                                    <td className="py-4 px-3">
                                        <span className="text-[#38190C] font-medium block">
                                            {item.owner_name}
                                        </span>
                                        {item.nik && (
                                            <span className="text-[11px] text-stone-400 block mt-0.5 font-mono">
                                                ({item.nik})
                                            </span>
                                        )}
                                    </td>

                                    {/* Kategori & Dusun */}
                                    <td className="py-4 px-3">
                                        <span className="text-[#38190C] font-medium block">
                                            {item.category}
                                        </span>
                                        <span className="text-[11px] text-stone-400 block mt-0.5">
                                            {item.dusun ? (item.dusun.toLowerCase().startsWith('dusun') ? item.dusun : `Dusun ${item.dusun}`) : '-'}
                                        </span>
                                    </td>

                                    {/* Daftar Produk */}
                                    <td className="py-4 px-3">
                                        <span className="text-stone-600 block leading-relaxed line-clamp-2 max-w-[200px]">
                                            {item.products || (Array.isArray(item.products_list) ? item.products_list.join(', ') : 'Beras, Minyak, Mie Instan, dan lainnya')}
                                        </span>
                                    </td>

                                    {/* Whatsapp */}
                                    <td className="py-4 px-3 font-mono text-stone-700 whitespace-nowrap">
                                        {item.whatsapp || '-'}
                                    </td>

                                    {/* Status (Badge dari Gambar 2) */}
                                    <td className="py-4 px-3 whitespace-nowrap">
                                        {item.status === 'approved' && (
                                            <span className="px-2.5 py-1 rounded-xl text-[11px] bg-[#D1FAE5] text-[#065F46] border border-[#A7F3D0] font-semibold">
                                                Aktif di Publik
                                            </span>
                                        )}
                                        {item.status === 'rejected' && (
                                            <span className="px-2.5 py-1 rounded-xl text-[11px] bg-[#FEE2E2] text-[#991B1B] border border-[#FECACA] font-semibold">
                                                Ditolak
                                            </span>
                                        )}
                                        {(!item.status || item.status === 'pending') && (
                                            <span className="px-2.5 py-1 rounded-xl text-[11px] bg-[#FEF3C7] text-[#92400E] border border-[#FDE68A] font-semibold">
                                                Menunggu Verifikasi
                                            </span>
                                        )}
                                    </td>

                                    {/* Aksi 4 Tombol Sesuai Gambar 2 (Setujui, Tolak, Edit, Hapus) */}
                                    <td className="py-4 pl-3 pr-1 text-right sm:text-center whitespace-nowrap">
                                        <div className="inline-flex items-center gap-1.5">
                                            {/* Tombol Setujui (Hijau Solid dari Gambar 2) */}
                                            {item.status !== 'approved' && (
                                                <form action={routes.approve ? routes.approve.replace(':id', item.id) : `/admin/umkm/${item.id}/approve`} method="POST" className="inline">
                                                    <input type="hidden" name="_token" value={csrfToken} />
                                                    <button
                                                        type="submit"
                                                        className="px-3 py-1.5 rounded-xl bg-[#059669] hover:bg-[#047857] text-white font-semibold text-xs shadow-sm transition cursor-pointer"
                                                        title="Setujui Toko"
                                                    >
                                                        Setujui
                                                    </button>
                                                </form>
                                            )}

                                            {/* Tombol Tolak (Merah Muda Lembut dari Gambar 2) */}
                                            {item.status === 'pending' && (
                                                <form 
                                                    action={routes.reject ? routes.reject.replace(':id', item.id) : `/admin/umkm/${item.id}/reject`} 
                                                    method="POST" 
                                                    className="inline"
                                                    onSubmit={(e) => {
                                                        if (!window.confirm('Tolak pengajuan pendaftaran toko ini?')) {
                                                            e.preventDefault();
                                                        }
                                                    }}
                                                >
                                                    <input type="hidden" name="_token" value={csrfToken} />
                                                    <button
                                                        type="submit"
                                                        className="px-3 py-1.5 rounded-xl bg-[#FEE2E2] hover:bg-[#FECACA] text-[#B91C1C] font-semibold text-xs transition cursor-pointer"
                                                        title="Tolak Pengajuan"
                                                    >
                                                        Tolak
                                                    </button>
                                                </form>
                                            )}

                                            {/* Tombol Edit */}
                                            <a
                                                href={routes.edit ? routes.edit.replace(':id', item.id) : `/admin/umkm/${item.id}/edit`}
                                                className="px-3 py-1.5 rounded-xl bg-[#FAF4ED] dark:bg-[#1E1712] hover:bg-[#F3E7DA] dark:hover:bg-[#281F18] border border-[#EADBCC] dark:border-[#2A1E17] text-[#38190C] dark:text-[#F8F1EB] font-semibold text-xs transition inline-block shadow-sm"
                                            >
                                                Edit
                                            </a>

                                            {/* Tombol Hapus (Teks Merah Tegas dari Gambar 2) */}
                                            <form
                                                action={routes.destroy ? routes.destroy.replace(':id', item.id) : `/admin/umkm/${item.id}`}
                                                method="POST"
                                                className="inline ml-1"
                                                onSubmit={(e) => {
                                                    if (!window.confirm('Hapus data toko UMKM ini secara permanen?')) {
                                                        e.preventDefault();
                                                    }
                                                }}
                                            >
                                                <input type="hidden" name="_token" value={csrfToken} />
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <button
                                                    type="submit"
                                                    className="text-rose-600 hover:text-rose-700 font-bold text-xs transition cursor-pointer"
                                                    title="Hapus Toko"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            ))}

                            {filteredUmkms.length === 0 && (
                                <tr>
                                    <td colSpan="7" className="py-8 text-center text-stone-400 text-xs">
                                        Tidak ada data toko UMKM yang cocok dengan filter atau kata kunci ini.
                                    </td>
                                </tr>
                            )}

                            {/* Baris-baris Bergaris Elegan (Lined Ledger) Sesuai Desain Gambar 1 */}
                            {Array.from({ length: Math.max(0, 8 - filteredUmkms.length) }).map((_, idx) => (
                                <tr key={`empty-line-${idx}`} className="empty-ledger-line pointer-events-none">
                                    <td className="py-4 pr-3 pl-1 text-transparent select-none">&nbsp;</td>
                                    <td className="py-4 px-3 text-transparent select-none">&nbsp;</td>
                                    <td className="py-4 px-3 text-transparent select-none">&nbsp;</td>
                                    <td className="py-4 px-3 text-transparent select-none">&nbsp;</td>
                                    <td className="py-4 px-3 text-transparent select-none">&nbsp;</td>
                                    <td className="py-4 px-3 text-transparent select-none">&nbsp;</td>
                                    <td className="py-4 pl-3 pr-1 text-transparent select-none">&nbsp;</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}
