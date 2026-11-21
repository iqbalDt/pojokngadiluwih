import React, { useState } from 'react';
import { MapPin, Clock, Phone, Globe, ShieldCheck, X, FileText, CheckCircle2, ExternalLink } from 'lucide-react';

export default function Footer({ routes = {} }) {
    const [isPrivacyModalOpen, setIsPrivacyModalOpen] = useState(false);

    return (
        <footer className="bg-[#F5EFE6] border-t border-[#DCCBB8] pt-14 sm:pt-16 pb-10 text-[#4D2E1E] w-full">
            {/* Full-width container: mengisi dari ujung kiri ke ujung kanan */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                {/* 3 Columns */}
                <div className="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 pb-12">
                    
                    {/* Col 1: Brand & Description (Rata Kiri) */}
                    <div className="md:col-span-5 space-y-4">
                        <span className="font-serif italic font-bold text-2xl sm:text-3xl text-[#38190C] tracking-tight block">
                            PojokNgadiluwih
                        </span>
                        <p className="text-xs sm:text-sm text-[#6E4F3E] leading-relaxed max-w-md font-light text-justify sm:text-left">
                            Portal resmi pelayanan digital dan promosi sentra ekonomi kreatif Desa Ngadiluwih, Kecamatan Ngadiluwih, Kabupaten Kediri, Provinsi Jawa Timur.
                        </p>
                        <div className="pt-2">
                            <span className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-[#D5C0AC] bg-[#EDE0D1] text-xs font-semibold text-[#4D2E1E] shadow-sm">
                                <Globe className="w-3.5 h-3.5 text-[#BD6E37]" />
                                <span>Website Desa Ngadiluwih</span>
                            </span>
                        </div>
                    </div>

                    {/* Col 2: Akses Cepat Warga (Tengah) */}
                    <div className="md:col-span-3 space-y-3">
                        <h4 className="font-serif font-bold text-base sm:text-lg text-[#38190C]">
                            Akses Cepat Warga
                        </h4>
                        <ul className="space-y-2 text-xs sm:text-sm text-[#6E4F3E]">
                            <li>
                                <a href={routes.profile || '/profil'} className="hover:text-[#BD6E37] transition inline-block py-0.5">
                                    Profil Desa
                                </a>
                            </li>
                            <li>
                                <a href={routes.newsIndex || '/berita'} className="hover:text-[#BD6E37] transition inline-block py-0.5">
                                    Berita & Pengumuman
                                </a>
                            </li>
                            <li>
                                <a href={routes.umkmIndex || '/umkm'} className="hover:text-[#BD6E37] transition inline-block py-0.5">
                                    UMKM & Potensi
                                </a>
                            </li>
                            <li>
                                <a href={routes.servicesGuides || '/layanan/panduan'} className="hover:text-[#BD6E37] transition inline-block py-0.5">
                                    Panduan Surat
                                </a>
                            </li>
                            <li>
                                <a href={routes.servicesFeedback || '/layanan/aspirasi'} className="hover:text-[#BD6E37] transition inline-block py-0.5">
                                    Aspirasi Warga
                                </a>
                            </li>
                        </ul>
                    </div>

                    {/* Col 3: Kontak Balai Desa (Rata Kanan) */}
                    <div className="md:col-span-4 space-y-3">
                        <h4 className="font-serif font-bold text-base sm:text-lg text-[#38190C]">
                            Kontak Balai Desa
                        </h4>
                        <div className="space-y-3 text-xs sm:text-sm text-[#6E4F3E]">
                            <a
                                href="https://www.google.com/maps/search/?api=1&query=Balai+Desa+Ngadiluwih,+Kecamatan+Ngadiluwih,+Kabupaten+Kediri,+Jawa+Timur+64171"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-start gap-2.5 hover:text-[#BD6E37] transition group"
                                title="Buka lokasi di Google Maps"
                            >
                                <MapPin className="w-4 h-4 text-[#BD6E37] shrink-0 mt-0.5 group-hover:scale-110 transition-transform" />
                                <span className="underline-offset-2 group-hover:underline">Jl. Raya Ngadiluwih No. 12, Kec. Ngadiluwih, Kab. Kediri, Jawa Timur 64171</span>
                            </a>
                            <div className="flex items-center gap-2.5">
                                <Clock className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                <span>Senin - Jumat: 08.00 - 16.00 WIB</span>
                            </div>
                            <a
                                href="https://wa.me/6282131135556"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-center gap-2.5 hover:text-[#BD6E37] transition group"
                                title="Hubungi via WhatsApp"
                            >
                                <Phone className="w-4 h-4 text-[#BD6E37] shrink-0 group-hover:scale-110 transition-transform" />
                                <span className="underline-offset-2 group-hover:underline">+62 821-3113-5556 | WhatsApp Layanan Desa</span>
                            </a>
                        </div>
                    </div>

                </div>

                {/* Bottom Separator & Copyright Bar */}
                <div className="border-t border-[#DCCBB8] pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#7B5B49]">
                    <p className="text-center sm:text-left">
                        &copy; 2026 Pemerintah Desa Ngadiluwih | Bersinergi membangun desa. Didukung oleh Pojok Ngadiluwih Smart Village Team.
                    </p>
                    <div className="flex items-center gap-3">
                        <button
                            type="button"
                            onClick={() => setIsPrivacyModalOpen(true)}
                            className="hover:text-[#BD6E37] transition cursor-pointer font-medium underline-offset-4 hover:underline"
                        >
                            Kebijakan Privasi
                        </button>
                        <span>•</span>
                        <a href={routes.servicesGuides || '/layanan/panduan'} className="hover:text-[#BD6E37] transition">
                            Panduan Warga
                        </a>
                    </div>
                </div>
            </div>

            {/* Modal Kebijakan Privasi */}
            {isPrivacyModalOpen && (
                <div
                    className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm transition-opacity"
                    onClick={() => setIsPrivacyModalOpen(false)}
                >
                    <div
                        className="bg-[#FAF4ED] dark:bg-[#18120D] text-[#38190C] dark:text-[#F8F1EB] rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] flex flex-col overflow-hidden border border-[#D5C0AC] dark:border-[#2E2017] animate-in fade-in zoom-in-95 duration-200"
                        onClick={(e) => e.stopPropagation()}
                    >
                        {/* Header Modal */}
                        <div className="p-5 sm:p-6 border-b border-[#E8DACB] dark:border-[#2E2017] flex items-center justify-between bg-[#F5EFE6] dark:bg-[#201812]">
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-xl bg-[#BD6E37]/15 dark:bg-[#BD6E37]/25 border border-[#BD6E37]/30 dark:border-[#BD6E37]/40 flex items-center justify-center text-[#BD6E37] dark:text-[#E08A58]">
                                    <ShieldCheck className="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 className="font-serif font-bold text-lg sm:text-xl text-[#38190C] dark:text-[#F8F1EB]">
                                        Kebijakan Privasi & Perlindungan Data
                                    </h3>
                                    <p className="text-xs text-[#7B5B49] dark:text-[#C7B6A8]">
                                        Portal Pelayanan Publik Desa Ngadiluwih, Kab. Kediri
                                    </p>
                                </div>
                            </div>
                            <button
                                type="button"
                                onClick={() => setIsPrivacyModalOpen(false)}
                                className="p-2 rounded-lg text-[#7B5B49] dark:text-[#C7B6A8] hover:text-[#38190C] dark:hover:text-[#F8F1EB] hover:bg-[#E8DACB]/50 dark:hover:bg-[#2E2219] transition"
                                title="Tutup"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        {/* Konten Scrollable */}
                        <div className="p-5 sm:p-6 overflow-y-auto space-y-4 text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8] leading-relaxed bg-[#FAF4ED] dark:bg-[#18120D]">
                            <div className="p-3.5 rounded-xl bg-[#EDE0D1]/70 dark:bg-[#231A13] border border-[#D5C0AC] dark:border-[#3A2A1E] text-xs">
                                <p className="font-medium text-[#38190C] dark:text-[#F8F1EB]">
                                    Pemerintah Desa Ngadiluwih menjamin keamanan serta kerahasiaan seluruh informasi dan data pribadi warga sesuai dengan amanat UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi.
                                </p>
                            </div>

                            <div className="space-y-1.5">
                                <h4 className="font-bold text-[#38190C] dark:text-[#F8F1EB] flex items-center gap-2">
                                    <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58]" />
                                    1. Data yang Dikumpulkan
                                </h4>
                                <p className="pl-6 text-xs text-[#6E4F3E] dark:text-[#C7B6A8]">
                                    Kami hanya menghimpun data yang diperlukan untuk pelayanan warga, seperti data pendaftaran toko UMKM (nama pemilik, nomor WhatsApp, foto produk), serta nama dan kontak pengirim formulir aspirasi warga.
                                </p>
                            </div>

                            <div className="space-y-1.5">
                                <h4 className="font-bold text-[#38190C] dark:text-[#F8F1EB] flex items-center gap-2">
                                    <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58]" />
                                    2. Penggunaan Data
                                </h4>
                                <p className="pl-6 text-xs text-[#6E4F3E] dark:text-[#C7B6A8]">
                                    Data hanya digunakan oleh aparatur Pemerintah Desa Ngadiluwih untuk memverifikasi keabsahan usaha, menerbitkan surat keterangan, menindaklanjuti keluhan masyarakat, serta menyusun evaluasi pelayanan desa secara agregat (anonim).
                                </p>
                            </div>

                            <div className="space-y-1.5">
                                <h4 className="font-bold text-[#38190C] dark:text-[#F8F1EB] flex items-center gap-2">
                                    <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58]" />
                                    3. Jaminan Keamanan & Tanpa Pihak Ketiga
                                </h4>
                                <p className="pl-6 text-xs text-[#6E4F3E] dark:text-[#C7B6A8]">
                                    Pemerintah Desa Ngadiluwih tidak pernah memperjualbelikan atau membagikan data warga kepada pihak ketiga untuk kepentingan komersial. Data tersimpan di server cloud terenkripsi yang terlindungi.
                                </p>
                            </div>

                            <div className="space-y-1.5">
                                <h4 className="font-bold text-[#38190C] dark:text-[#F8F1EB] flex items-center gap-2">
                                    <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58]" />
                                    4. Hak Warga & Pembaruan Data
                                </h4>
                                <p className="pl-6 text-xs text-[#6E4F3E] dark:text-[#C7B6A8]">
                                    Warga berhak mengajukan permohonan pembaruan, koreksi, atau penghapusan data toko UMKM maupun data aspirasi melalui kontak resmi Balai Desa Ngadiluwih.
                                </p>
                            </div>
                        </div>

                        {/* Footer Modal */}
                        <div className="p-4 sm:p-5 border-t border-[#E8DACB] dark:border-[#2E2017] bg-[#F5EFE6] dark:bg-[#201812] flex items-center justify-between gap-3">
                            <a
                                href={routes.privacy || '/kebijakan-privasi'}
                                className="inline-flex items-center gap-1.5 text-xs font-semibold text-[#BD6E37] dark:text-[#E08A58] hover:text-[#9A4C1B] dark:hover:text-[#F8A878] transition hover:underline"
                            >
                                <FileText className="w-4 h-4" />
                                <span>Lihat Halaman Lengkap</span>
                                <ExternalLink className="w-3.5 h-3.5" />
                            </a>
                            <button
                                type="button"
                                onClick={() => setIsPrivacyModalOpen(false)}
                                className="px-5 py-2 rounded-xl bg-[#BD6E37] hover:bg-[#A85B28] text-white text-xs font-semibold shadow-sm transition cursor-pointer"
                            >
                                Saya Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </footer>
    );
}
