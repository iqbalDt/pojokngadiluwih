import React from 'react';
import { Calendar, ArrowRight, Image as ImageIcon, ChevronLeft, ChevronRight } from 'lucide-react';

const FALLBACK_ARTICLES = [
    {
        id: 'fallback-1',
        category: 'Peristiwa',
        title: 'Pemotor Terpeleset Limbah Blotong di Purwokerto',
        published_at: '27 Okt 2026',
        location: 'Dusun Purwoharjo',
        excerpt: 'Dua pengendara sepeda motor terluka setelah terpeleset tumpahan limbah blotong di jalan raya Dusun Purwoharjo...',
        read_time: '2 menit membaca',
        image_url: null,
        show_url: '#',
    },
    {
        id: 'fallback-2',
        category: 'Ekonomi',
        title: 'Pasar Ngadiluwih Siap Beroperasi 24 Jam, Tampung 714 Pedagang...',
        published_at: '15 Okt 2026',
        location: 'Ngadiluwih',
        excerpt: 'Pasar Ngadiluwih akan mengadopsi pola operasional Pasar Wates dengan membagi aktivitas perdagangan...',
        read_time: '2 menit membaca',
        image_url: null,
        show_url: '#',
    },
    {
        id: 'fallback-3',
        category: 'Sosial',
        title: 'Warga Desa Dukuh Mendatangi Rumah Aktivis LSM di Mojo',
        published_at: '13 Okt 2026',
        location: 'Desa Dukuh',
        excerpt: 'Warga Desa Dukuh Mendatangi Rumah Aktivis LSM di Mojo. Aksi ini dipicu oleh unggahan di media sosial milik AF...',
        read_time: '4 menit membaca',
        image_url: null,
        show_url: '#',
    },
];

export default function NewsGridSection({
    news = [],
    pagination = {},
    routes = {},
}) {
    // If backend data is provided and not empty, use backend data; otherwise fallback to the design showcase articles
    const displayArticles = news && news.length > 0 ? news : FALLBACK_ARTICLES;
    const totalCount = pagination?.total || (news?.length > 0 ? news.length : 24);
    const displayedCount = displayArticles.length;

    return (
        <section className="w-full bg-[#BD6E37] text-[#2A1307] pb-16 sm:pb-24">
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                {/* Section Header Row */}
                <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#D58550]/40 pb-4 mb-8">
                    <div>
                        <span className="text-xs uppercase tracking-widest font-serif font-bold text-[#FDEEE0] block">
                            KANAL BERITA TERBARU
                        </span>
                        <h2 className="font-serif font-bold text-xl sm:text-2xl text-[#2A1307] mt-1">
                            Kabar &amp; Dinamika Dusun
                        </h2>
                    </div>

                    <div className="text-xs sm:text-sm font-medium text-[#FDEEE0]">
                        Menampilkan {displayedCount} dari {totalCount} Warta
                    </div>
                </div>

                {/* News Cards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    {displayArticles.map((article, idx) => {
                        const showUrl = article.show_url && article.show_url !== '#'
                            ? article.show_url
                            : (article.slug ? `/berita/${article.slug}` : '#');

                        return (
                            <article
                                key={article.id || article.slug || idx}
                                className="group bg-[#EFE1CF] rounded-[28px] p-5 sm:p-6 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between border border-[#E2CEB9]"
                            >
                                <div>
                                    {/* Top Category Badge */}
                                    <div className="mb-4">
                                        <span className="inline-block px-3.5 py-1 rounded-full border border-[#D5C0AC] bg-white/70 text-xs font-semibold text-[#5A331E]">
                                            {article.category || 'Warta'}
                                        </span>
                                    </div>

                                    {/* Image Box */}
                                    <div className="w-full aspect-[16/10] sm:aspect-[4/3] rounded-2xl bg-[#E2D2BE] border border-[#D5C0AC] flex items-center justify-center overflow-hidden mb-5 relative">
                                        {article.image_url ? (
                                            <img
                                                src={article.image_url}
                                                alt={article.title}
                                                className="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                                loading="lazy"
                                            />
                                        ) : (
                                            <div className="flex flex-col items-center justify-center text-[#9E8270]">
                                                <ImageIcon className="w-10 h-10 stroke-[1.5]" />
                                            </div>
                                        )}
                                    </div>

                                    {/* Date & Location */}
                                    <div className="flex items-center gap-1.5 text-xs text-[#6E4F3E] mb-2.5 font-medium">
                                        <Calendar className="w-3.5 h-3.5 text-[#BD6E37] shrink-0" />
                                        <span>
                                            {article.published_at || 'Terbaru'}
                                            {article.location ? ` • ${article.location}` : ''}
                                        </span>
                                    </div>

                                    {/* Title */}
                                    <h3 className="font-serif font-bold text-lg sm:text-xl text-[#2B140B] leading-snug line-clamp-2 group-hover:text-[#8E4A1E] transition mb-2.5">
                                        <a href={showUrl}>
                                            {article.title}
                                        </a>
                                    </h3>

                                    {/* Excerpt */}
                                    <p className="font-serif text-xs sm:text-sm text-[#4E3120] leading-relaxed line-clamp-3 mb-6">
                                        {article.excerpt}
                                    </p>
                                </div>

                                {/* Bottom Info Row */}
                                <div className="border-t border-[#DFCBB8] pt-4 flex items-center justify-between text-xs text-[#6E4F3E]">
                                    <span className="font-medium text-[#7A5B49]">
                                        {article.read_time || '2 menit membaca'}
                                    </span>

                                    <a
                                        href={showUrl}
                                        className="inline-flex items-center gap-1 font-serif font-bold text-[#2B140B] group-hover:text-[#8E4A1E] transition"
                                    >
                                        <span>Baca Selengkapnya</span>
                                        <ArrowRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                                    </a>
                                </div>
                            </article>
                        );
                    })}
                </div>

                {/* Pagination Controls (if pagination exists and has multiple pages) */}
                {pagination?.lastPage > 1 && (
                    <div className="mt-12 flex items-center justify-center gap-3">
                        {pagination.prevPageUrl ? (
                            <a
                                href={pagination.prevPageUrl}
                                className="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white text-xs font-semibold text-[#2B140B] shadow hover:bg-[#F5EFE6] transition"
                            >
                                <ChevronLeft className="w-4 h-4" />
                                <span>Sebelumnya</span>
                            </a>
                        ) : (
                            <span className="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/40 text-xs font-semibold text-[#2B140B]/50 cursor-not-allowed">
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
                                className="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white text-xs font-semibold text-[#2B140B] shadow hover:bg-[#F5EFE6] transition"
                            >
                                <span>Selanjutnya</span>
                                <ChevronRight className="w-4 h-4" />
                            </a>
                        ) : (
                            <span className="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/40 text-xs font-semibold text-[#2B140B]/50 cursor-not-allowed">
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

