import React, { useState } from 'react';
import { Search, MessageSquare, Clock, Building2, Trees } from 'lucide-react';

export default function HeroSection({ routes = {} }) {
    const [searchQuery, setSearchQuery] = useState('');
    const [imgError, setImgError] = useState(false);

    const handleSearch = (e) => {
        e.preventDefault();
        if (searchQuery.trim()) {
            window.location.href = `${routes.umkmIndex || '/umkm'}?q=${encodeURIComponent(searchQuery)}`;
        }
    };

    const handleOpenChatbot = () => {
        if (typeof window.toggleChatbot === 'function') {
            window.toggleChatbot();
        }
    };

    return (
        <section className="relative bg-[#BD6E37] text-white py-10 sm:py-14 lg:py-16 xl:py-20 overflow-hidden w-full">
            {/* Subtle decorative pattern background */}
            <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1.5px,transparent_1.5px)] [background-size:24px_24px] pointer-events-none" />

            {/* Full-width container: fills screen from left to right */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20 relative">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-stretch">
                    
                    {/* Left Column - Content (Rata Kiri, bentang penuh) */}
                    <div className="lg:col-span-7 xl:col-span-7 flex flex-col justify-between gap-6 xl:gap-8">
                        <div className="space-y-4 sm:space-y-6">
                            {/* Tag Pill */}
                            <div className="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEBDD] text-xs sm:text-sm font-semibold w-fit tracking-wide shadow-sm">
                                <span>PORTAL LAYANAN DIGITAL DESA</span>
                                <span className="opacity-50">|</span>
                                <span>KECAMATAN NGADILUWIH, KAB. KEDIRI</span>
                            </div>

                            {/* Hero Title */}
                            <h1 className="font-serif text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-[#2A1307] tracking-tight leading-[1.12]">
                                Layanan Desa <br />
                                <span className="italic font-normal text-[#3D1E0F]">Ngadiluwih</span>
                            </h1>

                            {/* Subtitle Description */}
                            <p className="font-serif text-[#38190C] text-sm sm:text-base md:text-lg leading-relaxed max-w-3xl">
                                Selamat datang di PojokNgadiluwih. Akses layanan administrasi desa, temukan produk UMKM lokal terbaik dengan pesan langsung via WhatsApp, dan manfaatkan asisten AI kami.
                            </p>

                            {/* Quote Card */}
                            <div className="bg-[#994F21]/80 border border-[#B36331] rounded-2xl p-5 sm:p-6 text-[#FDF5ED] shadow-sm w-full">
                                <span className="text-[11px] sm:text-xs font-bold tracking-widest uppercase text-[#F3CDB2] block mb-1.5">
                                    DESA NGADILUWIH
                                </span>
                                <p className="text-sm sm:text-base lg:text-lg italic leading-relaxed text-[#FFF8F3]">
                                    &ldquo;Ngadiluwih adalah desa yang asri, guyub rukun, dan bertumbuh maju bersama seluruh warganya.&rdquo;
                                </p>
                            </div>
                        </div>

                        {/* Search Bar */}
                        <form onSubmit={handleSearch} className="relative w-full pt-2">
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                placeholder="Pencarian layanan, surat, atau produk UMKM..."
                                className="w-full bg-[#FBF6F0] text-[#3D1E0F] placeholder-[#8C7063] text-sm sm:text-base rounded-full pl-6 pr-16 py-4 sm:py-4.5 shadow-lg focus:outline-none focus:ring-2 focus:ring-[#3D1E0F] border border-[#ECDCCB] transition"
                            />
                            <button
                                type="submit"
                                aria-label="Cari"
                                className="absolute right-2.5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#3D1E0F] hover:bg-[#251208] text-white flex items-center justify-center transition shadow-md group"
                            >
                                <Search className="w-5 h-5 group-hover:scale-110 transition-transform" />
                            </button>
                        </form>
                    </div>

                    {/* Right Column - Media Banner & Status Pill (Rata Kanan, meregang penuh) */}
                    <div className="lg:col-span-5 xl:col-span-5 flex flex-col justify-between items-stretch gap-4 min-h-[320px] sm:min-h-[400px] lg:min-h-full">
                        {/* Media Container */}
                        <div className="w-full flex-1 rounded-3xl bg-[#FAF1E6] p-2.5 sm:p-3 shadow-xl border border-[#D59E75]/40 relative overflow-hidden group min-h-[280px] sm:min-h-[360px] lg:min-h-[440px] flex flex-col justify-between">
                            {!imgError ? (
                                <img
                                    src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1200&auto=format&fit=crop"
                                    alt="Kantor dan Suasana Desa Ngadiluwih"
                                    onError={() => setImgError(true)}
                                    className="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-500 flex-1"
                                    loading="lazy"
                                />
                            ) : (
                                /* High-quality offline architectural & village illustration fallback */
                                <div className="w-full h-full min-h-[260px] rounded-2xl bg-gradient-to-br from-[#EBD9C7] via-[#DFCAAF] to-[#CCA885] p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div className="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-amber-500/10 blur-2xl pointer-events-none" />
                                    <div className="flex items-center justify-between text-[#5C3925]">
                                        <div className="flex items-center gap-2">
                                            <Building2 className="w-6 h-6 text-[#8E4A1E]" />
                                            <span className="font-serif font-bold text-sm tracking-wide">Kantor Balai Desa</span>
                                        </div>
                                        <Trees className="w-5 h-5 text-[#8E4A1E]/80" />
                                    </div>
                                    <div className="space-y-1 relative z-10">
                                        <span className="text-[10px] uppercase font-bold tracking-widest text-[#8E4A1E]">KABUPATEN KEDIRI</span>
                                        <h3 className="font-serif font-bold text-2xl text-[#2A1307] leading-tight">
                                            Pusat Pelayanan Terpadu Warga Ngadiluwih
                                        </h3>
                                        <p className="text-xs text-[#5C3925] line-clamp-2">
                                            Lingkungan asri, sejuk, dan siap memberikan kemudahan akses pelayanan administratif setiap hari kerja.
                                        </p>
                                    </div>
                                </div>
                            )}
                            <div className="absolute inset-0 bg-gradient-to-t from-[#3D1E0F]/40 via-transparent to-transparent pointer-events-none rounded-2xl" />
                        </div>

                        {/* Office Status Pill - Rata Kiri & Kanan */}
                        <div className="w-full flex items-center justify-between px-6 sm:px-8 py-3 rounded-full bg-[#994F21]/85 border border-[#B36331] text-[#FFF9F3] text-xs sm:text-sm font-medium shadow-md backdrop-blur-sm">
                            <div className="flex items-center gap-2.5">
                                <span className="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shrink-0" />
                                <span className="font-semibold text-emerald-100">Pelayanan kantor terbuka</span>
                            </div>
                            <div className="flex items-center gap-2 text-[#FCE6D4]">
                                <Clock className="w-4 h-4 opacity-80 shrink-0" />
                                <span>08.00 - 16.00 WIB</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    );
}
