import React from 'react';

export default function ProfileHeroSection() {
    return (
        <section className="relative bg-[#BD6E37] text-white pt-12 pb-14 sm:pt-16 sm:pb-16 lg:pt-20 lg:pb-16 overflow-hidden w-full text-center">
            {/* Ambient pattern */}
            <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1.5px,transparent_1.5px)] [background-size:24px_24px] pointer-events-none" />

            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20 relative flex flex-col items-center">
                {/* Pill Tag */}
                <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEBDD] text-xs sm:text-sm font-semibold w-fit tracking-wider shadow-sm mb-5">
                    <span>MENGENAL LEBIH DEKAT</span>
                    <span className="opacity-50">|</span>
                    <span>KECAMATAN NGADILUWIH, KAB. KEDIRI</span>
                </div>

                {/* Hero Title */}
                <h1 className="font-serif text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-[#2A1307] tracking-tight leading-[1.15] mb-4">
                    Profil Desa <br />
                    <span className="italic font-normal text-[#3D1E0F]">Ngadiluwih</span>
                </h1>

                {/* Subtitle Description */}
                <p className="font-serif text-[#38190C] text-sm sm:text-base lg:text-lg leading-relaxed max-w-3xl mx-auto">
                    Informasi lengkap visi misi desa, sejarah peta lokasi serta jajaran aparatur Pemerintah di Desa Ngadiluwih, Kecamatan Ngadiluwih, Kabupaten Kediri.
                </p>
            </div>
        </section>
    );
}

