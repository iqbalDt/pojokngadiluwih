import React, { useState } from 'react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';
import { BadgeCheck, RotateCcw, MapPin } from 'lucide-react';

export default function DemografiPage({ initialData = {} }) {
    const { routes = {} } = initialData;

    // Pembagian wilayah administratif dusun resmi Desa Ngadiluwih (3 Dusun)
    const dusunList = [
        {
            name: 'Dusun Ngadiluwih',
            description: 'Wilayah utama di pusat desa.',
        },
        {
            name: 'Dusun Ngadiloyo',
            description: 'Dusun yang dikenal dengan keberadaan Sumber Ngadiloyo.',
        },
        {
            name: 'Dusun Kandang Sapi',
            description: 'Salah satu bagian wilayah administratif Desa Ngadiluwih.',
        },
    ];

    // Ringkasan struktur keluarga resmi
    const familyBreakdown = [
        {
            label: 'Kepala Keluarga (KK)',
            total: '2.136',
            male: '1.601',
            female: '535',
        },
        {
            label: 'Anggota Keluarga',
            total: '3.890',
            male: '1.390',
            female: '2.500',
        },
    ];

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar with 'demographics' active */}
            <Navbar routes={routes} activePage="demographics" />

            <main className="flex-grow w-full bg-[#BD6E37] pb-16 sm:pb-24">
                {/* 1. Hero Section */}
                <section className="w-full pt-8 sm:pt-12 pb-6">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        {/* Pill Tag */}
                        <div className="flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-semibold tracking-wider uppercase mb-5 flex-wrap">
                            <span className="px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEEE0] shadow-sm">
                                INFORMASI PUBLIK &amp; WARTA WARGA
                            </span>
                            <span className="text-[#FDEEE0]/60 font-normal">|</span>
                            <span className="text-[#FDEEE0] tracking-wider">
                                KECAMATAN NGADILUWIH, KAB. KEDIRI
                            </span>
                        </div>

                        {/* Title with italic 'Demografi' */}
                        <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] tracking-tight leading-[1.12] mb-3">
                            Statistik &amp; <span className="italic font-normal">Demografi</span> Desa<br />
                            <span>Pojok Ngadiluwih</span>
                        </h1>

                        {/* Subtitle */}
                        <p className="font-serif text-[#38190C] text-sm sm:text-base leading-relaxed mb-6 max-w-2xl">
                            Visualisasi data kependudukan, sebaran mata pencaharian, komposisi usia, dan wilayah rukun warga secara terbuka dan berkala demi pembangunan desa yang inklusif dan merata.
                        </p>

                        {/* Meta Badges Row matching exact design in Gambar 1 */}
                        <div className="flex items-center gap-3 flex-wrap">
                            {/* Badge 1: Semester I 2026 */}
                            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 border border-white/25 text-xs sm:text-[13px] font-sans text-white shadow-sm backdrop-blur-xs">
                                <BadgeCheck className="w-4 h-4 text-white shrink-0 stroke-[2]" />
                                <span>Semester I 2026</span>
                            </div>

                            {/* Badge 2: Diperbarui: 15 Oktober 2026 */}
                            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#52250F]/55 border border-[#7A3E1E]/60 text-xs sm:text-[13px] font-sans text-[#FDEEE0] shadow-sm backdrop-blur-xs">
                                <RotateCcw className="w-3.5 h-3.5 text-[#FDEEE0] shrink-0 stroke-[2]" />
                                <span>Diperbarui: 15 Oktober 2026</span>
                            </div>

                            {/* Badge 3: Validasi Terpusat Balai Desa */}
                            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 border border-white/25 text-xs sm:text-[13px] font-sans text-white shadow-sm backdrop-blur-xs">
                                <span className="w-2 h-2 rounded-full bg-white shrink-0 inline-block" />
                                <span>Validasi Terpusat Balai Desa</span>
                            </div>
                        </div>

                        {/* 2. Key Stats Cards (4 Columns) */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6 mt-8 mb-10">
                            {/* Total Penduduk */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    TOTAL PENDUDUK
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    6.026
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    Jiwa Terdata (KK + Anggota)
                                </span>
                            </div>

                            {/* Kepala Keluarga */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    KEPALA KELUARGA
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    2.136
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    1.601 Laki-laki · 535 Perempuan
                                </span>
                            </div>

                            {/* Laki-Laki */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    LAKI-LAKI
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    2.991
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    49,6% Proporsi
                                </span>
                            </div>

                            {/* Perempuan */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    PEREMPUAN
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    3.035
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    50,4% Proporsi
                                </span>
                            </div>
                        </div>

                        {/* 3. Main Box: Grafik Penduduk (Map & Progress Bars) */}
                        <div className="bg-[#EFE1CF] rounded-[32px] p-6 sm:p-8 lg:p-10 shadow-xl border border-[#E2CEB9]">
                            <h2 className="font-serif font-bold text-2xl sm:text-3xl text-[#2A1307] mb-8">
                                Grafik Penduduk
                            </h2>

                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                                {/* Left Column: Map Visualizer */}
                                <div className="lg:col-span-7 rounded-2xl overflow-hidden border border-[#D5C0AC] shadow-inner bg-[#E4D5C3] relative min-h-[360px] sm:min-h-[420px] flex flex-col justify-between">
                                    {/* Embedded Map of Ngadiluwih area */}
                                    <iframe
                                        title="Peta Wilayah Ngadiluwih Kediri"
                                        src="https://www.openstreetmap.org/export/embed.html?bbox=111.965%2C-7.935%2C112.035%2C-7.875&layer=mapnik&marker=-7.898%2C111.996"
                                        className="w-full h-full min-h-[360px] sm:min-h-[420px] border-0"
                                        loading="lazy"
                                    />

                                    {/* Overlay Badge at bottom */}
                                    <div className="absolute bottom-3 left-3 bg-[#FAF1E6]/95 backdrop-blur-sm border border-[#D5C0AC] px-3.5 py-1.5 rounded-xl text-xs font-serif text-[#2A1307] flex items-center gap-1.5 shadow-sm pointer-events-none">
                                        <MapPin className="w-3.5 h-3.5 text-[#BD6E37]" />
                                        <span>Peta Administrasi Desa Ngadiluwih, Kab. Kediri</span>
                                    </div>
                                </div>

                                {/* Right Column: Demographics Breakdown */}
                                <div className="lg:col-span-5 flex flex-col justify-between space-y-6">
                                    {/* Wilayah Administratif Dusun */}
                                    <div>
                                        <h3 className="font-serif font-bold text-lg sm:text-xl text-[#2A1307] mb-3">
                                            Pembagian Wilayah Dusun (3 Dusun)
                                        </h3>

                                        <div className="space-y-3">
                                            {dusunList.map((dusun) => (
                                                <div key={dusun.name} className="bg-[#FAF1E6]/80 border border-[#DFCEB9] rounded-2xl px-4 py-3">
                                                    <div className="font-serif font-bold text-sm text-[#2A1307]">
                                                        {dusun.name}
                                                    </div>
                                                    <p className="font-serif text-xs text-[#6E4F3E] mt-0.5 leading-relaxed">
                                                        {dusun.description}
                                                    </p>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    {/* Rincian Kepala & Anggota Keluarga */}
                                    <div>
                                        <h3 className="font-serif font-bold text-lg sm:text-xl text-[#2A1307] mb-3">
                                            Komposisi Keluarga
                                        </h3>

                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            {familyBreakdown.map((item) => (
                                                <div key={item.label} className="bg-[#FAF1E6]/80 border border-[#DFCEB9] rounded-2xl px-4 py-3">
                                                    <span className="block text-[11px] font-serif font-semibold text-[#6E4F3E]">
                                                        {item.label}
                                                    </span>
                                                    <div className="font-serif font-extrabold text-xl text-[#2A1307] mt-0.5">
                                                        {item.total}
                                                    </div>
                                                    <span className="text-[11px] font-serif text-[#6E4F3E]">
                                                        L: {item.male} · P: {item.female}
                                                    </span>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    {/* Mata Pencaharian & Pendidikan Dominan */}
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div className="bg-[#FAF1E6]/80 border border-[#DFCEB9] rounded-2xl px-4 py-3">
                                            <span className="block text-[11px] font-serif font-semibold text-[#6E4F3E]">
                                                Mata Pencaharian Terbanyak
                                            </span>
                                            <div className="font-serif font-bold text-base text-[#2A1307] mt-1">
                                                Petani
                                            </div>
                                        </div>
                                        <div className="bg-[#FAF1E6]/80 border border-[#DFCEB9] rounded-2xl px-4 py-3">
                                            <span className="block text-[11px] font-serif font-semibold text-[#6E4F3E]">
                                                Pendidikan Dominan
                                            </span>
                                            <div className="font-serif font-bold text-base text-[#2A1307] mt-1">
                                                SLTA ke Atas
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            {/* Bottom Footer */}
            <Footer routes={routes} />
        </div>
    );
}

