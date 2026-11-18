import React, { useState } from 'react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';
import { BadgeCheck, RotateCcw, MapPin } from 'lucide-react';

export default function DemografiPage({ initialData = {} }) {
    const { routes = {} } = initialData;

    // Sebaran penduduk per dusun
    const dusunStats = [
        { name: 'Dusun Ngadiluwih', count: 2450, percentage: 39 },
        { name: 'Dusun Ngadiloyo', count: 2110, percentage: 33.5 },
        { name: 'Dusun Kandang Sapi', count: 1728, percentage: 27.5 },
    ];

    // Mata pencaharian utama
    const jobStats = [
        { name: 'Petani dan Buruh Tani', percentage: 42, count: '2.640 jiwa' },
        { name: 'Pertanian', percentage: 28, count: '1.760 jiwa' },
        { name: 'Wiraswasta dan Pedagang', percentage: 30, count: '1.888 jiwa' },
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
                                    6.288
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    Jiwa (Semester 2026)
                                </span>
                            </div>

                            {/* Kepala Keluarga */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    KEPALA KELUARGA
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    2.112
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    KK (Kartu Keluarga)
                                </span>
                            </div>

                            {/* Laki-Laki */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    LAKI-LAKI
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    3.134
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    49,8% Proporsi
                                </span>
                            </div>

                            {/* Perempuan */}
                            <div className="bg-[#EFE1CF] rounded-[24px] p-6 shadow-md border border-[#E2CEB9]">
                                <span className="block text-[11px] font-serif font-bold uppercase tracking-wider text-[#5C341F]">
                                    PEREMPUAN
                                </span>
                                <div className="font-serif font-extrabold text-3xl sm:text-4xl text-[#2A1307] my-2 tracking-tight">
                                    3.154
                                </div>
                                <span className="text-xs font-serif text-[#6E4F3E]">
                                    50,2% Proporsi
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
                                <div className="lg:col-span-5 flex flex-col justify-between space-y-8">
                                    {/* Sebaran Penduduk per Dusun */}
                                    <div>
                                        <h3 className="font-serif font-bold text-lg sm:text-xl text-[#2A1307] mb-4">
                                            Sebaran Penduduk per Dusun
                                        </h3>

                                        <div className="space-y-4">
                                            {dusunStats.map((dusun) => (
                                                <div key={dusun.name}>
                                                    <div className="flex items-center justify-between text-xs sm:text-sm font-serif text-[#2A1307] mb-1.5">
                                                        <span>{dusun.name}</span>
                                                        <span className="text-[#6E4F3E] text-xs">
                                                            {dusun.percentage}%
                                                        </span>
                                                    </div>
                                                    {/* Progress bar light blue #BFD9EC matching the design */}
                                                    <div className="w-full h-2 rounded-full bg-[#DCCBB8]/60 overflow-hidden">
                                                        <div
                                                            className="h-full rounded-full bg-[#BFD9EC]"
                                                            style={{ width: `${dusun.percentage}%` }}
                                                        />
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    {/* Mata Pencaharian Utama */}
                                    <div>
                                        <h3 className="font-serif font-bold text-lg sm:text-xl text-[#2A1307] mb-4">
                                            Mata Pencaharian Utama
                                        </h3>

                                        <div className="space-y-4">
                                            {jobStats.map((job) => (
                                                <div key={job.name}>
                                                    <div className="flex items-center justify-between text-xs sm:text-sm font-serif text-[#2A1307] mb-1.5">
                                                        <span>{job.name}</span>
                                                        <span className="text-[#6E4F3E] text-xs">
                                                            {job.percentage}%
                                                        </span>
                                                    </div>
                                                    {/* Progress bar light blue #BFD9EC matching the design */}
                                                    <div className="w-full h-2 rounded-full bg-[#DCCBB8]/60 overflow-hidden">
                                                        <div
                                                            className="h-full rounded-full bg-[#BFD9EC]"
                                                            style={{ width: `${job.percentage}%` }}
                                                        />
                                                    </div>
                                                </div>
                                            ))}
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

