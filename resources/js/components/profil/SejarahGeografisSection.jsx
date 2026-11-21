import React, { useState } from 'react';
import { Image as ImageIcon } from 'lucide-react';

export default function SejarahGeografisSection() {
    const [imgError, setImgError] = useState(false);

    return (
        <section className="bg-[#BD6E37] pb-12 sm:pb-16 lg:pb-20 w-full">
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                {/* Main Cream / Tan Card */}
                <div className="bg-[#EFE1CF] rounded-[28px] sm:rounded-[36px] p-6 sm:p-8 lg:p-10 xl:p-12 shadow-sm border border-[#DFCEB9]">
                    
                    {/* Top Pill Header (Lebar & tegas sesuai panah 1) */}
                    <div className="mb-6 sm:mb-8">
                        <span className="inline-block bg-[#BD6E37] text-white px-6 sm:px-8 lg:px-9 py-2.5 sm:py-3 rounded-full font-serif font-bold text-xs sm:text-sm lg:text-base tracking-wider uppercase shadow-sm">
                            SEJARAH SINGKAT DESA NGADILUWIH &amp; KONDISI GEOGRAFIS
                        </span>
                    </div>

                    {/* Content Grid */}
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-center">
                        
                        {/* Left Column: Image Container (Proporsional & Lebih Besar sesuai panah 2) */}
                        <div className="lg:col-span-5 w-full flex justify-center lg:justify-start">
                            <div className="w-full h-[300px] sm:h-[380px] lg:h-[420px] xl:h-[450px] rounded-2xl sm:rounded-3xl border-[6px] border-[#BD6E37] shadow-md overflow-hidden bg-[#BD6E37] relative group">
                                {!imgError ? (
                                    <img
                                        src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1200&auto=format&fit=crop"
                                        alt="Lanskap Pertanian dan Sejarah Desa Ngadiluwih"
                                        onError={() => setImgError(true)}
                                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                    />
                                ) : (
                                    /* Image fallback with village sunset tone */
                                    <div className="w-full h-full bg-gradient-to-br from-[#BD6E37] via-[#D58C55] to-[#A85827] flex flex-col items-center justify-center text-white/80 p-6 text-center">
                                        <ImageIcon className="w-12 h-12 text-white/90 mb-3" />
                                        <span className="font-serif italic text-sm text-white font-medium">
                                            Lanskap Sejarah &amp; Pertanian Ngadiluwih
                                        </span>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Right Column: Narrative Text & Batas Wilayah (Full Serif font) */}
                        <div className="lg:col-span-7 flex flex-col justify-between space-y-5 font-serif text-[#38190C]">
                            {/* Narrative Paragraph */}
                            <p className="text-sm sm:text-base lg:text-lg xl:text-xl leading-relaxed text-justify sm:text-left font-normal">
                                Desa Ngadiluwih, yang terletak di Kabupaten Kediri, memiliki sejarah yang kaya dan berakar pada tradisi lokal. Desa ini dikenal sebagai wilayah pertanian yang subur, dengan masyarakat yang bergantung pada hasil pertanian seperti padi, jagung, dan sayuran. Sejak zaman kolonial, Ngadiluwih telah menjadi pusat aktivitas agraris, yang turut mempengaruhi pola kehidupan sosial dan budaya masyarakatnya.
                            </p>

                            {/* Divider Line */}
                            <hr className="border-t border-[#38190C]/20 my-2" />

                            {/* Batas Wilayah */}
                            <div className="space-y-2">
                                <h3 className="font-serif font-bold text-base sm:text-lg lg:text-xl text-[#38190C]">
                                    Batas Wilayah
                                </h3>

                                <div className="space-y-1 text-sm sm:text-base lg:text-lg text-[#38190C] font-normal leading-relaxed">
                                    <p>Utara: Desa Rembang &amp; Desa Banjarejo</p>
                                    <p>Timur: Desa Slumbung</p>
                                    <p>Selatan: Desa Dukuh &amp; Sungai Brantas</p>
                                    <p>Barat: Kecamatan Mojo</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    );
}
