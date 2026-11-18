import React, { useState } from 'react';
import { Search } from 'lucide-react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';

const SURAT_LIST = [
    {
        id: 'sku',
        title: 'Surat Keterangan Usaha',
        purpose: 'Untuk kepentingan perizinan usaha, atau legalitas bisnis mikro',
        requirements: [
            'Fotokopi KTP Pemohon',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW',
            'Foto tempat kegiatan usaha',
        ],
    },
    {
        id: 'skck',
        title: 'Pengantar SKCK Kepolisian',
        purpose: 'Untuk pembuatan SKCK di Polsek Ngadiluwih atau Polres Kediri',
        requirements: [
            'Fotokopi KTP & KK Pemohon',
            'Surat Pengantar RT/RW',
            'Pas foto 4x6 latar belakang merah (2 lembar)',
            'Fotokopi Akta Kelahiran / Ijazah Terakhir',
        ],
    },
    {
        id: 'domisili',
        title: 'Surat Keterangan Domisili',
        purpose: 'Bukti domisili tempat tinggal bagi penduduk tetap maupun perantau',
        requirements: [
            'Fotokopi KTP & Kartu Keluarga',
            'Surat Pengantar RT/RW setempat',
            'Surat pernyataan pemilik kontrakan (jika menyewa)',
            'Fotokopi KTP pemilik kontrakan / rumah',
        ],
    },
    {
        id: 'sktm',
        title: 'Surat Keterangan Tidak Mampu (SKTM)',
        purpose: 'Untuk permohonan beasiswa, keringanan biaya pendidikan, atau jaminan kesehatan',
        requirements: [
            'Fotokopi KTP Pemohon & Kepala Keluarga',
            'Fotokopi Kartu Keluarga (KK)',
            'Surat Pengantar RT/RW menerangkan kondisi ekonomi',
            'Foto rumah tampak depan dan ruang tamu',
        ],
    },
    {
        id: 'kematian',
        title: 'Surat Keterangan Kematian',
        purpose: 'Pelaporan pencatatan sipil, akta kematian, serta pengurusan administrasi ahli waris',
        requirements: [
            'Fotokopi KTP & KK Almarhum / Almarhumah',
            'Surat Keterangan Kematian dari Dokter / RS (jika ada)',
            'Surat Pengantar RT/RW setempat',
            'Fotokopi KTP Pelapor (Ahli Waris)',
        ],
    },
    {
        id: 'nikah',
        title: 'Surat Pengantar Nikah (N1-N4)',
        purpose: 'Pendaftaran berkas pernikahan resmi ke Kantor Urusan Agama (KUA) Ngadiluwih',
        requirements: [
            'Fotokopi KTP, KK, & Akta Kelahiran Calon Pengantin',
            'Surat Pengantar RT/RW setempat',
            'Pas foto 2x3 (4 lembar) & 4x6 (2 lembar) berlatar biru',
            'Fotokopi KTP kedua orang tua / wali',
        ],
    },
];

const STEPS = [
    {
        step: '1',
        title: 'Pengantar RT/RW',
        desc: 'Minta surat keterangan / pengantar dari ketua RT & RW domisili Anda.',
    },
    {
        step: '2',
        title: 'Siapkan Berkas',
        desc: 'Bawa dokumen persyaratan seperti KTP, KK, dan berkas pendukung lainnya.',
    },
    {
        step: '3',
        title: 'Loket Balai Desa',
        desc: 'Serahkan ke petugas pelayanan di Balai Desa Ngadiluwih pada jam kerja.',
    },
];

export default function GuidesPage({ initialData = {} }) {
    const { routes = {} } = initialData;
    const [searchQuery, setSearchQuery] = useState('');

    const filteredSurat = SURAT_LIST.filter((item) => {
        const query = searchQuery.toLowerCase().trim();
        if (!query) return true;
        return (
            item.title.toLowerCase().includes(query) ||
            item.purpose.toLowerCase().includes(query) ||
            item.requirements.some((r) => r.toLowerCase().includes(query))
        );
    });

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar with 'services' active and 'guides' subpage */}
            <Navbar routes={routes} activePage="services" activeSubpage="guides" />

            <main className="flex-grow w-full bg-[#BD6E37]">
                {/* 1. Hero Section */}
                <section className="w-full pt-8 sm:pt-12 pb-6">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        {/* Pill Tag */}
                        <div className="flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-semibold tracking-wider uppercase mb-5 flex-wrap">
                            <span className="px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEEE0] shadow-sm">
                                LAYANAN ADMINISTRASI
                            </span>
                            <span className="text-[#FDEEE0]/60 font-normal">|</span>
                            <span className="text-[#FDEEE0] tracking-wider">
                                KECAMATAN NGADILUWIH, KAB. KEDIRI
                            </span>
                        </div>

                        {/* Title */}
                        <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] tracking-tight leading-[1.15] mb-3">
                            Panduan Persyaratan Surat<br />
                            <span className="italic font-bold">Desa Ngadiluwih</span>
                        </h1>

                        {/* Subtitle */}
                        <p className="font-serif text-[#38190C] text-sm sm:text-base leading-relaxed mb-6 max-w-2xl">
                            Ketahui kelengkapan berkas dan alur permohonan surat pengantar administrasi sebelum datang ke Balai Desa Ngadiluwih
                        </p>

                        {/* Search Input Bar */}
                        <div className="w-full max-w-md sm:max-w-lg mb-8">
                            <div className="relative flex items-center bg-white rounded-full px-4 sm:px-5 py-3 shadow-sm border border-transparent focus-within:border-[#2A1307] transition">
                                <Search className="w-4 h-4 text-[#8C6D58] shrink-0 mr-3" />
                                <input
                                    type="text"
                                    value={searchQuery}
                                    onChange={(e) => setSearchQuery(e.target.value)}
                                    placeholder="Cari jenis surat yang diinginkan..."
                                    className="w-full bg-transparent text-xs sm:text-sm text-[#2A1307] placeholder-[#8C6D58] focus:outline-none"
                                />
                            </div>
                        </div>
                    </div>
                </section>

                {/* 2. Surat Cards Grid */}
                <section className="w-full pb-14 sm:pb-20">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                            {filteredSurat.map((surat) => (
                                <article
                                    key={surat.id}
                                    className="bg-[#EFE1CF] rounded-[28px] p-6 sm:p-7 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between border border-[#E2CEB9]"
                                >
                                    <div>
                                        {/* Title */}
                                        <h3 className="font-serif font-bold text-lg sm:text-xl text-[#2A1307] leading-snug mb-2">
                                            {surat.title}
                                        </h3>

                                        {/* Purpose */}
                                        <p className="font-serif text-xs text-[#5C341F] leading-relaxed mb-3">
                                            {surat.purpose}
                                        </p>

                                        {/* Pembatas / Divider Line antara judul+keterangan dengan persyaratan */}
                                        <div className="border-t border-[#D5C0AC] my-3.5" />

                                        {/* Requirements Title */}
                                        <div className="font-serif font-bold text-xs sm:text-sm text-[#2A1307] mb-2.5">
                                            Persyaratan :
                                        </div>

                                        {/* Numbered Requirements */}
                                        <ol className="space-y-1.5 font-serif text-xs sm:text-sm text-[#3D1E0F] leading-relaxed">
                                            {surat.requirements.map((req, idx) => (
                                                <li key={idx} className="flex items-start gap-2">
                                                    <span className="font-bold text-[#BD6E37] shrink-0">
                                                        {idx + 1}.
                                                    </span>
                                                    <span>{req}</span>
                                                </li>
                                            ))}
                                        </ol>
                                    </div>
                                </article>
                            ))}
                        </div>

                        {filteredSurat.length === 0 && (
                            <div className="text-center py-12 bg-[#FAF1E6]/40 rounded-3xl border border-[#E2CEB9]">
                                <p className="font-serif text-[#2A1307] font-semibold text-base">
                                    Jenis surat "{searchQuery}" tidak ditemukan.
                                </p>
                                <p className="text-xs text-[#5C341F] mt-1">
                                    Silakan gunakan kata kunci lain seperti "Usaha", "SKCK", "Domisili", atau "Nikah".
                                </p>
                            </div>
                        )}

                        {/* 3. Steps Section (Langkah-Langkah Pengurusan Surat) */}
                        <div className="mt-16 sm:mt-24 bg-[#B5632E]/80 border border-[#D57E44] rounded-[32px] sm:rounded-[36px] p-6 sm:p-10 shadow-[0_16px_40px_-10px_rgba(0,0,0,0.25)]">
                            {/* Pill Header (Rata Kiri, Lebih Panjang, Huruf Tebal & Efek Timbul 3D) */}
                            <div className="flex justify-start mb-8 sm:mb-10">
                                <div className="inline-flex items-center px-8 sm:px-16 py-3 sm:py-4 rounded-2xl bg-gradient-to-b from-white to-[#F5EBE0] text-[#2A1307] font-serif font-black italic tracking-[0.2em] sm:tracking-[0.28em] text-xs sm:text-base uppercase shadow-[0_8px_20px_-2px_rgba(0,0,0,0.28),0_3px_6px_rgba(0,0,0,0.15)] border-t border-white border-b-2 border-[#D8C1AA]">
                                    LANGKAH - LANGKAH PENGURUSAN SURAT
                                </div>
                            </div>

                            {/* 3 Step Cards dengan Efek Timbul */}
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                                {STEPS.map((stepItem) => (
                                    <div
                                        key={stepItem.step}
                                        className="bg-gradient-to-b from-[#562912] to-[#461F0B] rounded-2xl sm:rounded-[26px] p-6 sm:p-8 text-center text-white shadow-[0_12px_28px_-6px_rgba(0,0,0,0.4),0_4px_8px_rgba(0,0,0,0.2)] border-t border-white/20 border-b-2 border-black/50 flex flex-col items-center hover:-translate-y-1 transition-transform duration-300"
                                    >
                                        {/* Number Badge Timbul */}
                                        <div className="w-12 h-12 rounded-full bg-gradient-to-b from-white to-[#F2E8DC] text-[#461F0B] font-black font-serif text-xl flex items-center justify-center mb-4 shadow-[0_4px_10px_rgba(0,0,0,0.3)] border-b-2 border-[#D5C2B0]">
                                            {stepItem.step}
                                        </div>

                                        {/* Title */}
                                        <h4 className="font-serif font-bold text-base sm:text-lg text-white mb-2 tracking-wide">
                                            {stepItem.title}
                                        </h4>

                                        {/* Description */}
                                        <p className="font-serif text-xs sm:text-sm text-[#F7E5D0] leading-relaxed max-w-xs font-normal">
                                            {stepItem.desc}
                                        </p>
                                    </div>
                                ))}
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

