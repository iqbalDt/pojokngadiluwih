import React from 'react';
import { User, MessageCircle, ChevronLeft, ChevronRight } from 'lucide-react';

const FALLBACK_UMKM = [
    {
        id: 'fb-1',
        name: 'Sambal Pecel Khas Kediri',
        category: 'Kuliner',
        dusun: 'Dusun Sukorejo',
        description: 'Bumbu pecel otentik, gurih pedas siap seduh air hangat. Awet di simpan hingga 3 bulan di dalam freezer.',
        price: 'Rp. 25.000 / 500gr',
        image_url: null,
        slug: 'sambal-pecel-khas-kediri-1',
        show_url: '#',
        phone: '081234567890',
    },
    {
        id: 'fb-2',
        name: 'Sambal Pecel Khas Kediri',
        category: 'Kuliner',
        dusun: 'Dusun Sukorejo',
        description: 'Bumbu pecel otentik, gurih pedas siap seduh air hangat. Awet di simpan hingga 3 bulan di dalam freezer.',
        price: 'Rp. 25.000 / 500gr',
        image_url: null,
        slug: 'sambal-pecel-khas-kediri-2',
        show_url: '#',
        phone: '081234567890',
    },
    {
        id: 'fb-3',
        name: 'Sambal Pecel Khas Kediri',
        category: 'Kuliner',
        dusun: 'Dusun Sukorejo',
        description: 'Bumbu pecel otentik, gurih pedas siap seduh air hangat. Awet di simpan hingga 3 bulan di dalam freezer.',
        price: 'Rp. 25.000 / 500gr',
        image_url: null,
        slug: 'sambal-pecel-khas-kediri-3',
        show_url: '#',
        phone: '081234567890',
    },
    {
        id: 'fb-4',
        name: 'Sambal Pecel Khas Kediri',
        category: 'Kuliner',
        dusun: 'Dusun Sukorejo',
        description: 'Bumbu pecel otentik, gurih pedas siap seduh air hangat. Awet di simpan hingga 3 bulan di dalam freezer.',
        price: 'Rp. 25.000 / 500gr',
        image_url: null,
        slug: 'sambal-pecel-khas-kediri-4',
        show_url: '#',
        phone: '081234567890',
    },
];

export default function UmkmGridSection({
    umkms = [],
    pagination = {},
    routes = {},
}) {
    const displayItems = umkms && umkms.length > 0 ? umkms : FALLBACK_UMKM;

    return (
        <section className="w-full bg-[#BD6E37] text-[#2A1307] pb-16 sm:pb-24">
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">

                {/* 4-column responsive grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">
                    {displayItems.map((item, idx) => {
                        const showUrl = item.show_url && item.show_url !== '#'
                            ? item.show_url
                            : (item.slug ? `/umkm/${item.slug}` : '#');

                        const waNumber = item.phone ? item.phone.replace(/\D/g, '') : '6281234567890';
                        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(`Halo, saya ingin memesan ${item.name} dari PojokNgadiluwih.`)}`;

                        return (
                            <article
                                key={item.id || item.slug || idx}
                                className="group bg-[#EFE1CF] rounded-[26px] p-4 sm:p-5 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between border border-[#E2CEB9]"
                            >
                                <div>
                                    {/* Image Container with Warm Tan Placeholder */}
                                    <div className="w-full aspect-[4/3] rounded-2xl bg-[#D7A376] flex items-center justify-center overflow-hidden mb-3.5 relative">
                                        {item.image_url ? (
                                            <img
                                                src={item.image_url}
                                                alt={item.name}
                                                className="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                                loading="lazy"
                                            />
                                        ) : (
                                            <div className="w-full h-full bg-[#D7A376]" />
                                        )}
                                    </div>

                                    {/* Meta Row: Category Pill & Dusun */}
                                    <div className="flex items-center justify-between mb-2">
                                        <span className="inline-block px-2.5 py-0.5 rounded-full bg-[#2A1307] text-[10px] font-semibold text-white tracking-wide">
                                            {item.category || 'Kuliner'}
                                        </span>

                                        <span className="inline-flex items-center gap-1 text-[11px] font-serif text-[#6E4F3E]">
                                            <User className="w-3 h-3 text-[#8C6D58]" />
                                            <span>{item.dusun || 'Dusun Sukorejo'}</span>
                                        </span>
                                    </div>

                                    {/* Product Title */}
                                    <h3 className="font-serif font-bold text-base text-[#2A1307] leading-snug line-clamp-1 group-hover:text-[#8E4A1E] transition mb-1">
                                        <a href={showUrl}>{item.name}</a>
                                    </h3>

                                    {/* Description */}
                                    <p className="font-serif text-xs text-[#4E3120] leading-relaxed line-clamp-3 mb-2.5">
                                        {item.description}
                                    </p>

                                    {/* Price */}
                                    <div className="font-serif font-bold text-xs sm:text-sm text-[#2A1307] mb-3">
                                        {item.price || 'Rp. 25.000 / 500gr'}
                                    </div>
                                </div>

                                {/* Bottom Actions Row */}
                                <div className="pt-2 flex items-center justify-between">
                                    <a
                                        href={showUrl}
                                        className="font-serif text-xs text-[#4E3120] hover:text-[#BD6E37] transition font-medium"
                                    >
                                        Detail produk
                                    </a>

                                    <a
                                        href={waUrl}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#2A1307] text-[11px] font-semibold text-white hover:bg-[#3D1E0F] transition shadow-sm"
                                    >
                                        <MessageCircle className="w-3 h-3 fill-current" />
                                        <span>Pesan via WA</span>
                                    </a>
                                </div>
                            </article>
                        );
                    })}
                </div>

                {/* Pagination Controls */}
                {pagination?.lastPage > 1 && (
                    <div className="mt-12 flex items-center justify-center gap-3">
                        {pagination.prevPageUrl ? (
                            <a
                                href={pagination.prevPageUrl}
                                className="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-white text-xs font-semibold text-[#2B140B] shadow hover:bg-[#F5EFE6] transition"
                            >
                                <ChevronLeft className="w-4 h-4" />
                                <span>Sebelumnya</span>
                            </a>
                        ) : (
                            <span className="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-white/40 text-xs font-semibold text-[#2B140B]/50 cursor-not-allowed">
                                <ChevronLeft className="w-4 h-4" />
                                <span>Sebelumnya</span>
                            </span>
                        )}

                        <span className="text-xs font-bold text-[#FDEEE0] px-3">
                            Halaman {pagination.currentPage} dari {pagination.lastPage}
                        </span>

                        {pagination.nextPageUrl ? (
                            <a
                                href={pagination.nextPageUrl}
                                className="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-white text-xs font-semibold text-[#2B140B] shadow hover:bg-[#F5EFE6] transition"
                            >
                                <span>Selanjutnya</span>
                                <ChevronRight className="w-4 h-4" />
                            </a>
                        ) : (
                            <span className="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-white/40 text-xs font-semibold text-[#2B140B]/50 cursor-not-allowed">
                                <span>Selanjutnya</span>
                                <ChevronRight className="w-4 h-4" />
                            </span>
                        )}
                    </div>
                )}
            </div>
        </section>
    );
}
