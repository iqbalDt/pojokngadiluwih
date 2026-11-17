import React, { useState } from 'react';
import { Search } from 'lucide-react';

export default function UmkmHeroSection({
    currentSearch = '',
    currentCategory = '',
    onSearchSubmit,
    onCategoryChange,
}) {
    const [searchTerm, setSearchTerm] = useState(currentSearch);

    const categories = [
        { label: 'Semua Kategori', value: '' },
        { label: 'Kuliner', value: 'Kuliner' },
        { label: 'Pertanian & Bibit', value: 'Pertanian' },
        { label: 'Kerajinan tangan', value: 'Kerajinan Tangan' },
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

                {/* Breadcrumb Tag Pill Row with CAPITAL text */}
                <div className="flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-semibold tracking-wider uppercase mb-5 flex-wrap">
                    <span className="px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEEE0] shadow-sm">
                        PEMBERDAYAAN EKONOMI
                    </span>
                    <span className="text-[#FDEEE0]/60 font-normal">|</span>
                    <span className="text-[#FDEEE0] tracking-wider">
                        KECAMATAN NGADILUWIH, KAB. KEDIRI
                    </span>
                </div>

                {/* Big Serif Title */}
                <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] tracking-tight leading-[1.12] mb-3">
                    Katalog UMKM Desa<br />
                    <span>Ngadiluwih</span>
                </h1>

                {/* Subtitle */}
                <p className="font-serif text-[#38190C] text-sm sm:text-base leading-relaxed mb-6 max-w-xl">
                    Dukung produk lokal desa Ngadiluwih. Pesan langsung ke penjual<br className="hidden sm:inline" />
                    via WhatsApp tanpa perantara.
                </p>

                {/* Search Bar – sized proportionally like in the design image */}
                <form onSubmit={handleSubmit} className="w-full max-w-md sm:max-w-lg mb-6">
                    <div className="relative flex items-center bg-white rounded-full px-5 py-3 shadow-sm border border-transparent focus-within:border-[#2A1307] transition">
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Cari produk UMKM......"
                            className="w-full bg-transparent text-xs sm:text-sm text-[#2A1307] placeholder-[#8C6D58] focus:outline-none pr-8"
                        />
                        <button
                            type="submit"
                            className="absolute right-4 text-[#2A1307] hover:text-[#BD6E37] transition"
                            aria-label="Cari"
                        >
                            <Search className="w-4 h-4 stroke-[2.5]" />
                        </button>
                    </div>
                </form>

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
                                className={`px-5 py-2 rounded-full text-xs sm:text-sm font-serif whitespace-nowrap transition-all duration-200 cursor-pointer ${
                                    isActive
                                        ? 'bg-[#2B140B] text-white shadow-sm font-semibold'
                                        : 'bg-[#FAF3EB] text-[#2B140B] hover:bg-white border border-[#E5D3BF] shadow-sm font-medium'
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
