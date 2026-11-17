import React from 'react';
import { MapPin, Clock, Phone, Globe } from 'lucide-react';

export default function Footer({ routes = {} }) {
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
                                <span>Website Resmi Pemerintah Desa</span>
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
                            <div className="flex items-start gap-2.5">
                                <MapPin className="w-4 h-4 text-[#BD6E37] shrink-0 mt-0.5" />
                                <span>Jl. Raya Ngadiluwih No. 12, Kec. Ngadiluwih, Kab. Kediri, Jawa Timur 64171</span>
                            </div>
                            <div className="flex items-center gap-2.5">
                                <Clock className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                <span>Senin - Jumat: 08.00 - 15.00 WIB</span>
                            </div>
                            <div className="flex items-center gap-2.5">
                                <Phone className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                <span>(0354) 741-2010 | WhatsApp Layanan Desa</span>
                            </div>
                        </div>
                    </div>

                </div>

                {/* Bottom Separator & Copyright Bar */}
                <div className="border-t border-[#DCCBB8] pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#7B5B49]">
                    <p className="text-center sm:text-left">
                        &copy; 2026 Pemerintah Desa Ngadiluwih | Bersinergi membangun desa. Didukung oleh Pojok Ngadiluwih Smart Village Team.
                    </p>
                    <div className="flex items-center gap-3">
                        <span className="hover:text-[#BD6E37] transition cursor-pointer">Kebijakan Privasi</span>
                        <span>•</span>
                        <a href={routes.servicesGuides || '/layanan/panduan'} className="hover:text-[#BD6E37] transition">
                            Panduan Warga
                        </a>
                        <span>•</span>
                        <a href={routes.login || '/masuk'} className="hover:text-[#BD6E37] transition">
                            Masuk Admin
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
