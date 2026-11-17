import React, { useState } from 'react';
import { Search, Calendar } from 'lucide-react';

export default function NewsHeroSection({
    currentSearch = '',
    currentCategory = '',
    onSearchSubmit,
    onCategoryChange,
}) {
    const [searchTerm, setSearchTerm] = useState(currentSearch);

    const categories = [
        { label: 'Semua Warta', value: '' },
        { label: 'Pengumuman Resmi', value: 'Pengumuman' },
        { label: 'Kegiatan Desa', value: 'Kegiatan Desa' },
        { label: 'Pembangunan', value: 'Pembangunan' },
        { label: 'Kesehatan & Posyandu', value: 'Kesehatan' },
    ];

    const handleSubmit = (e) => {
        e.preventDefault();
        if (onSearchSubmit) {
            onSearchSubmit(searchTerm);
        }
    };

    return (
        <section className="w-full bg-[#BD6E37] text-[#2A1307] pt-8 sm:pt-12 pb-6">
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                {/* Tag Pill */}
                <div className="inline-flex items-center gap-2 px-4 sm:px-5 py-1.5 sm:py-2 rounded-full bg-[#A55622]/70 border border-[#D58550]/60 text-xs sm:text-sm font-semibold tracking-wider uppercase text-[#FDEEE0] shadow-inner mb-5">
                    <span>INFORMASI PUBLIK &amp; WARTA WARGA</span>
                    <span className="opacity-50">|</span>
                    <span className="font-semibold">KECAMATAN NGADILUWIH, KAB. KEDIRI</span>
                </div>

                {/* Big Serif Heading */}
                <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] tracking-tight leading-[1.15] mb-3">
                    Berita &amp; Pengumuman Desa<br />
                    <span>Ngadiluwih</span>
                </h1>

                {/* Description */}
                <p className="font-serif text-[#38190C] text-sm sm:text-base md:text-lg max-w-3xl leading-relaxed mb-8">
                    Ikuti informasi resmi seputar program pembangunan, agenda posyandu, penyaluran bantuan sosial, serta kabar guyub rukun kemasyarakatan terkini.
                </p>

                {/* Search Bar & Year Filter */}
                <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full mb-5">
                    <form onSubmit={handleSubmit} className="relative flex-1">
                        <div className="relative flex items-center bg-white rounded-full px-5 py-3.5 shadow-sm border border-transparent focus-within:border-[#2A1307] transition">
                            <Search className="w-5 h-5 text-[#8C6D58] shrink-0 mr-3" />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Cari warta desa, jadwal posyandu, bantuan sosial, atau kegiatan..."
                                className="w-full bg-transparent text-sm sm:text-base text-[#2A1307] placeholder-[#8C6D58] focus:outline-none"
                            />
                        </div>
                    </form>

                    <div className="inline-flex items-center justify-center gap-2 bg-white rounded-full px-6 py-3.5 shadow-sm border border-transparent text-sm font-semibold text-[#2A1307] shrink-0">
                        <Calendar className="w-4 h-4 text-[#8C6D58]" />
                        <span>Tahun: 2026</span>
                    </div>
                </div>

                {/* Category Filter Pills */}
                <div className="flex items-center gap-2 sm:gap-3 overflow-x-auto pb-2 scrollbar-none">
                    {categories.map((cat) => {
                        const isActive =
                            (cat.value === '' && (!currentCategory || currentCategory === '')) ||
                            (cat.value !== '' && currentCategory?.toLowerCase().includes(cat.value.toLowerCase()));

                        return (
                            <button
                                key={cat.label}
                                type="button"
                                onClick={() => onCategoryChange && onCategoryChange(cat.value)}
                                className={`px-4 sm:px-5 py-2 rounded-full text-xs sm:text-sm whitespace-nowrap transition-all duration-200 cursor-pointer ${
                                    isActive
                                        ? 'bg-[#2B140B] text-white font-semibold shadow-sm'
                                        : 'bg-transparent text-[#2B140B] hover:bg-[#A55622]/40 font-medium'
                                }`}
                            >
                                {cat.label}
                            </button>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}

