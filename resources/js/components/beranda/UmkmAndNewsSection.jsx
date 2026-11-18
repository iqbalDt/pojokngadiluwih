import React, { useState } from 'react';
import { ArrowRight, Phone, Newspaper } from 'lucide-react';

export default function UmkmAndNewsSection({ featuredUmkm = [], latestNews = [], routes = {} }) {
    const [newsImgError, setNewsImgError] = useState(false);

    const fallbackUmkm = [
        {
            id: '1',
            name: 'Kacang Oven Gurih Bu Surni',
            description: 'kacang kahas renyah tanpa minyak berlebih dan oleh-oleh Favorit',
            price: 'Rp. 15.000/ bks',
            phone: '6281234567890',
            image_url: 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?q=80&w=600&auto=format&fit=crop',
        },
        {
            id: '2',
            name: 'Kacang Oven Gurih Bu Surni',
            description: 'kacang kahas renyah tanpa minyak berlebih dan oleh-oleh Favorit',
            price: 'Rp. 15.000/ bks',
            phone: '6281234567890',
            image_url: 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?q=80&w=600&auto=format&fit=crop',
        },
    ];

    const displayUmkm = featuredUmkm && featuredUmkm.length > 0 ? featuredUmkm.slice(0, 2) : fallbackUmkm;

    const fallbackNews = {
        title: 'KONI KEDIRI, OBAT JALANAN KEDIRI MENJADI BENTENG SOUND HOREGG.',
        date: 'Senin, 24 Oktober 2026',
        image_url: 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=800&auto=format&fit=crop',
        excerpt: 'KEDIRI — Obrolan dan atmosfer sound horegg di Kediri sempat menjadi sorotan publik saat pagelaran karnaval desa. Namun di balik riuhnya suara sound, KONI Kab Kediri melihat sisi lain yang menarik dan berpotensi untuk merangkul pemuda desa agar berkreasi positif...',
        slug: 'koni-kediri-sound-horegg',
    };

    const firstNews = latestNews && latestNews.length > 0 ? latestNews[0] : fallbackNews;

    const formatPrice = (val) => {
        if (!val) return 'Rp. 15.000/ bks';
        if (typeof val === 'number') return `Rp. ${val.toLocaleString('id-ID')}/ bks`;
        const str = String(val).trim();
        if (str.startsWith('Rp')) return str.includes('/') ? str : `${str}/ bks`;
        return `Rp. ${str}/ bks`;
    };

    return (
        <section className="py-12 sm:py-16 lg:py-20 bg-[#F5EFE6] w-full">
            {/* Full-width container: mengisi dari ujung kiri ke ujung kanan */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-stretch">
                    
                    {/* Left Column: KATALOG UMKM (Rata Kiri, Sesuai Gambar 1) */}
                    <div className="lg:col-span-5 xl:col-span-5 flex flex-col justify-between h-full">
                        <div className="mb-4">
                            <h2 className="font-serif text-2xl sm:text-3xl font-extrabold tracking-wide text-[#3D1E0F] border-b-2 border-[#3D1E0F] inline-block pb-1">
                                KATALOG UMKM
                            </h2>
                        </div>

                        {/* Tan Container with solid dark border matching Gambar 1 */}
                        <div className="bg-[#D4A987] border-2 border-[#3D1E0F] rounded-[32px] sm:rounded-[36px] p-4 sm:p-5 xl:p-6 flex flex-col justify-between flex-1 gap-4 shadow-sm">
                            <div className="flex flex-col gap-4 flex-1">
                                {displayUmkm.map((item, idx) => {
                                    const waUrl = `https://wa.me/${(item.phone || item.whatsapp || '6281234567890').replace(/[^0-9]/g, '')}?text=${encodeURIComponent(`Halo, saya tertarik memesan produk ${item.name || item.title || 'UMKM'} di PojokNgadiluwih.`)}`;
                                    const imgSrc = item.image_url || item.image || item.photo || 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?q=80&w=600&auto=format&fit=crop';

                                    return (
                                        <div
                                            key={item.id || idx}
                                            className="bg-white rounded-[22px] sm:rounded-[26px] p-3 sm:p-3.5 border border-[#3D1E0F]/20 shadow-xs flex flex-col justify-between gap-2.5 group hover:shadow-md transition flex-1"
                                        >
                                            <div className="w-full aspect-[16/10] sm:aspect-[16/11] rounded-[18px] overflow-hidden bg-[#FAF3EA]">
                                                <img
                                                    src={imgSrc}
                                                    alt={item.name || item.title}
                                                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                    loading="lazy"
                                                />
                                            </div>

                                            <div>
                                                <h3 className="font-serif font-bold text-[#2A1307] text-base sm:text-lg leading-snug group-hover:text-[#BD6E37] transition">
                                                    {item.name || item.title}
                                                </h3>
                                                <p className="text-xs sm:text-[13px] text-[#5C3822] mt-1 line-clamp-2 leading-relaxed">
                                                    {item.description || 'kacang kahas renyah tanpa minyak berlebih dan oleh-oleh Favorit'}
                                                </p>
                                            </div>

                                            <div className="flex items-center justify-between pt-1">
                                                <span className="font-serif font-bold text-[#BD6E37] text-sm sm:text-base">
                                                    {formatPrice(item.price)}
                                                </span>

                                                <a
                                                    href={waUrl}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="w-8 h-8 rounded-full bg-[#BD6E37] hover:bg-[#9E5220] text-white flex items-center justify-center shadow-xs hover:scale-110 active:scale-95 transition"
                                                    title="Pesan via WhatsApp"
                                                    aria-label="Pesan via WhatsApp"
                                                >
                                                    <Phone className="w-3.5 h-3.5 fill-current" />
                                                </a>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>

                            {/* View All UMKM Link: "Lihat semuanya" */}
                            <div className="text-center pt-1 pb-0.5">
                                <a
                                    href={routes.umkmIndex || '/umkm'}
                                    className="text-xs sm:text-sm font-serif font-semibold text-[#3D1E0F] hover:text-[#BD6E37] transition cursor-pointer"
                                >
                                    Lihat semuanya
                                </a>
                            </div>
                        </div>
                    </div>

                    {/* Right Column: KABAR DESA (Rata Kanan) */}
                    <div className="lg:col-span-7 xl:col-span-7 flex flex-col justify-between h-full">
                        <div className="mb-4">
                            <h2 className="font-serif text-2xl sm:text-3xl font-bold text-[#3D1E0F]">
                                KABAR DESA
                            </h2>
                        </div>

                        {/* Big Featured News Card */}
                        <div className="bg-[#FFFDF9] border border-[#E9DFD3] rounded-3xl p-6 sm:p-7 xl:p-8 shadow-sm flex flex-col justify-between flex-1 gap-5">
                            <div className="w-full h-64 sm:h-80 xl:h-96 rounded-2xl overflow-hidden bg-[#FAF2E8] relative group flex-shrink-0">
                                {!newsImgError ? (
                                    <img
                                        src={firstNews.image_url || firstNews.image || 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=800&auto=format&fit=crop'}
                                        alt={firstNews.title}
                                        onError={() => setNewsImgError(true)}
                                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                    />
                                ) : (
                                    <div className="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-[#DECBBA] to-[#EFE4D6] p-6 text-center text-[#5C3925]">
                                        <Newspaper className="w-12 h-12 text-[#BD6E37] mb-2" />
                                        <span className="font-serif font-bold text-lg">Berita & Informasi Desa Ngadiluwih</span>
                                    </div>
                                )}
                            </div>

                            <div className="space-y-3 flex-1 flex flex-col justify-between">
                                <div className="space-y-2.5">
                                    <h3 className="font-serif font-bold text-xl sm:text-2xl xl:text-3xl text-[#2A1307] uppercase leading-tight hover:text-[#BD6E37] transition">
                                        <a href={firstNews.slug ? `${routes.newsIndex || '/berita'}/${firstNews.slug}` : routes.newsIndex || '/berita'}>
                                            {firstNews.title}
                                        </a>
                                    </h3>

                                    <p className="text-xs sm:text-sm font-semibold text-[#BD6E37]">
                                        {firstNews.date || firstNews.created_at || 'Senin, 24 Oktober 2026'}
                                    </p>

                                    <p className="text-xs sm:text-sm lg:text-base text-[#5C4233] leading-relaxed line-clamp-4 font-light text-justify sm:text-left">
                                        {firstNews.excerpt || firstNews.content || 'KEDIRI — Obrolan dan atmosfer sound horegg di Kediri sempat menjadi sorotan publik saat pagelaran karnaval desa. Namun di balik riuhnya suara sound, KONI Kab Kediri melihat sisi lain yang menarik dan berpotensi untuk merangkul pemuda desa...'}
                                    </p>
                                </div>

                                <div className="pt-3">
                                    <a
                                        href={firstNews.slug ? `${routes.newsIndex || '/berita'}/${firstNews.slug}` : routes.newsIndex || '/berita'}
                                        className="text-xs sm:text-sm font-semibold text-[#BD6E37] hover:text-[#8E4A1E] inline-flex items-center gap-1.5 transition"
                                    >
                                        <span>Baca selengkapnya</span>
                                        <ArrowRight className="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    );
}
