import React, { useState, useMemo } from 'react';
import { Search, ChevronDown, X, MessageSquare, CheckCircle, Clock } from 'lucide-react';

export default function AdminServicesPage({ initialData = {} }) {
    const aspirationsList = initialData.aspirations || [];
    const totalCount = initialData.totalCount ?? aspirationsList.length;
    const initialSearch = initialData.currentSearch || '';
    const initialStatus = initialData.currentStatus || '';
    const csrfToken = initialData.csrfToken || (typeof document !== 'undefined' ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') : '') || '';
    const routes = initialData.routes || {};

    const [searchQuery, setSearchQuery] = useState(initialSearch);
    const [selectedStatus, setSelectedStatus] = useState(initialStatus);

    // Filter daftar aspirasi secara realtime berdasarkan search query dan status dropdown
    const filteredAspirations = useMemo(() => {
        return aspirationsList.filter((item) => {
            // Filter Status
            const matchesStatus =
                selectedStatus === '' ||
                (selectedStatus === 'pending' && (item.status === 'pending' || !item.status)) ||
                (selectedStatus === 'processed' && item.status === 'processed') ||
                (selectedStatus === 'completed' && item.status === 'completed');

            // Search Query
            const q = searchQuery.toLowerCase().trim();
            const matchesSearch =
                q === '' ||
                (item.name && item.name.toLowerCase().includes(q)) ||
                (item.dusun && item.dusun.toLowerCase().includes(q)) ||
                (item.category && item.category.toLowerCase().includes(q)) ||
                (item.title && item.title.toLowerCase().includes(q)) ||
                (item.message && item.message.toLowerCase().includes(q)) ||
                (item.phone && item.phone.toLowerCase().includes(q));

            return matchesStatus && matchesSearch;
        });
    }, [aspirationsList, selectedStatus, searchQuery]);

    // Format tanggal
    const formatDate = (dateStr) => {
        if (!dateStr) return '-';
        try {
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        } catch {
            return dateStr;
        }
    };

    return (
        <div className="space-y-6">

            {/* Baris Pencarian & Dropdown Status (Persis Gambar 1) */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                {/* Search Input Pill Panjang Sesuai Gambar 1 */}
                <div className="relative w-full max-w-xl">
                    <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#C07044]">
                        <Search className="w-4 h-4 text-[#C07044]" />
                    </div>
                    <input
                        type="text"
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        placeholder="Cari nama pemohon / objek aspirasi"
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

                {/* Dropdown Filter Status Pill Sesuai Gambar 1 */}
                <div className="relative shrink-0 w-full sm:w-auto">
                    <select
                        value={selectedStatus}
                        onChange={(e) => setSelectedStatus(e.target.value)}
                        className="w-full sm:w-auto appearance-none px-6 py-3 pr-10 rounded-2xl bg-[#FDF7F0] border border-[#EADBCC] text-xs font-semibold text-[#38190C] focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] transition cursor-pointer shadow-sm"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Tindak Lanjut</option>
                        <option value="processed">Sedang Diproses</option>
                        <option value="completed">Selesai Diproses</option>
                    </select>
                    <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-[#38190C]">
                        <ChevronDown className="w-4 h-4 text-[#C07044]" />
                    </div>
                </div>
            </div>

            {/* Container Card Krem Tabel Aspirasi Sesuai Gambar 1 */}
            <div className="bg-[#FBF4EC] rounded-3xl border border-[#EADBCC] shadow-sm p-6 sm:p-8 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-xs min-w-[760px]">
                        <thead>
                            <tr className="border-b border-[#EADBCC] text-[#38190C] font-serif font-bold text-xs sm:text-sm">
                                <th className="pb-4 pr-3 pl-1 w-[18%]">Tanggal</th>
                                <th className="pb-4 px-3 w-[20%]">Pemohon/warga</th>
                                <th className="pb-4 px-3 w-[20%]">Jenis & Kategori</th>
                                <th className="pb-4 px-3 w-[24%]">Rincian Aspirasi</th>
                                <th className="pb-4 px-3 w-[10%]">Status</th>
                                <th className="pb-4 pl-3 pr-1 w-[12%] text-right sm:text-center">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-[#EADBCC]/70 text-stone-700">
                            {filteredAspirations.map((item) => {
                                const isPending = !item.status || item.status === 'pending';
                                const isProcessed = item.status === 'processed';
                                const isCompleted = item.status === 'completed';

                                return (
                                    <tr key={item.id} className="hover:bg-white/40 transition">
                                        {/* Tanggal */}
                                        <td className="py-4 pr-3 pl-1 text-stone-600 font-normal whitespace-nowrap">
                                            {formatDate(item.created_at)}
                                        </td>

                                        {/* Pemohon/warga */}
                                        <td className="py-4 px-3">
                                            <span className="font-medium text-[#38190C] block text-xs">
                                                {item.public_display_name || item.name || 'Warga Desa'}
                                            </span>
                                            {item.dusun && (
                                                <span className="text-[11px] text-stone-400 block mt-0.5">
                                                    (Dusun {item.dusun})
                                                </span>
                                            )}
                                        </td>

                                        {/* Jenis & Kategori (Aspirasi Warga Berwarna Biru Tosca Sesuai Gambar 1) */}
                                        <td className="py-4 px-3">
                                            <span className="font-medium text-cyan-600 block text-xs">
                                                Aspirasi Warga
                                            </span>
                                            {item.category && (
                                                <span className="text-[11px] text-stone-400 block mt-0.5">
                                                    ({item.category})
                                                </span>
                                            )}
                                        </td>

                                        {/* Rincian Aspirasi */}
                                        <td className="py-4 px-3">
                                            <p className="text-stone-700 leading-relaxed text-xs max-w-sm line-clamp-3">
                                                {item.message || item.title || '-'}
                                            </p>
                                        </td>

                                        {/* Status Sesuai Gambar 1 */}
                                        <td className="py-4 px-3 whitespace-nowrap">
                                            {isPending && (
                                                <span className="px-3 py-1 rounded-xl text-[11px] bg-[#FEF3C7] text-[#92400E] border border-[#FDE68A] font-semibold">
                                                    Menunggu
                                                </span>
                                            )}
                                            {isProcessed && (
                                                <span className="px-3 py-1 rounded-xl text-[11px] bg-[#D1FAE5] text-[#065F46] border border-[#A7F3D0] font-semibold">
                                                    Diproses
                                                </span>
                                            )}
                                            {isCompleted && (
                                                <span className="px-3 py-1 rounded-xl text-[11px] bg-[#E0E7FF] text-[#3730A3] border border-[#C7D2FE] font-semibold">
                                                    Selesai
                                                </span>
                                            )}
                                        </td>

                                        {/* Ubah Status Sesuai Gambar 1 */}
                                        <td className="py-4 pl-3 pr-1 text-right sm:text-center whitespace-nowrap">
                                            {isPending && (
                                                <form action={routes.status ? routes.status.replace(':id', item.id) : `/admin/layanan/${item.id}/status`} method="POST" className="inline">
                                                    <input type="hidden" name="_token" value={csrfToken} />
                                                    <input type="hidden" name="status" value="processed" />
                                                    <button
                                                        type="submit"
                                                        className="px-3.5 py-1.5 rounded-xl bg-[#D1FAE5] hover:bg-[#A7F3D0] text-[#065F46] border border-[#A7F3D0] text-xs font-semibold shadow-sm transition cursor-pointer"
                                                        title="Tandai Sedang Diproses"
                                                    >
                                                        Diproses
                                                    </button>
                                                </form>
                                            )}

                                            {isProcessed && (
                                                <form action={routes.status ? routes.status.replace(':id', item.id) : `/admin/layanan/${item.id}/status`} method="POST" className="inline">
                                                    <input type="hidden" name="_token" value={csrfToken} />
                                                    <input type="hidden" name="status" value="completed" />
                                                    <button
                                                        type="submit"
                                                        className="text-stone-500 hover:text-emerald-700 font-medium text-xs transition cursor-pointer hover:underline"
                                                        title="Tandai Selesai Diproses"
                                                    >
                                                        Selesai diproses
                                                    </button>
                                                </form>
                                            )}

                                            {isCompleted && (
                                                <span className="text-xs text-stone-400 font-normal">
                                                    Telah selesai
                                                </span>
                                            )}
                                        </td>
                                    </tr>
                                );
                            })}

                            {filteredAspirations.length === 0 && (
                                <tr>
                                    <td colSpan="6" className="py-8 text-center text-stone-400 text-xs">
                                        Tidak ada data aspirasi atau pengajuan warga yang cocok.
                                    </td>
                                </tr>
                            )}

                            {/* Baris-baris Bergaris Elegan (Lined Ledger) Sesuai Desain Gambar 1 */}
                            {Array.from({ length: Math.max(0, 8 - filteredAspirations.length) }).map((_, idx) => (
                                <tr key={`empty-line-${idx}`} className="empty-ledger-line pointer-events-none">
                                    <td className="py-4 pr-3 pl-1 text-transparent select-none">&nbsp;</td>
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

            {/* Bagian yang Kurang dari Gambar 2: Diletakkan di Bagian Bawah Menggunakan React.js Sesuai Permintaan User */}
            <div className="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                {/* Badge Total Masuk dari Gambar 2 */}
                <div className="inline-flex items-center px-4 py-2 rounded-2xl bg-[#FAF4ED] dark:bg-[#1E1712] border border-[#EADBCC] dark:border-[#2A1E17] text-stone-700 dark:text-[#F8F1EB] text-xs font-medium shadow-sm">
                    <span>Total Masuk:</span>
                    <strong className="text-[#38190C] dark:text-[#BD6E37] font-bold ml-1.5">{totalCount} Berkas / Pesan</strong>
                </div>

                <div className="text-[11px] text-stone-400">
                    Menampilkan {filteredAspirations.length} dari {totalCount} data aspirasi warga
                </div>
            </div>

        </div>
    );
}

