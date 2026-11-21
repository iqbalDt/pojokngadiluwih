import React from 'react';
import { 
    ShieldCheck, 
    Lock, 
    FileText, 
    UserCheck, 
    Database, 
    HelpCircle, 
    MapPin, 
    Clock, 
    Phone, 
    Mail, 
    ArrowLeft,
    CheckCircle2
} from 'lucide-react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';

export default function PrivacyPage({ initialData = {} }) {
    const { routes = {} } = initialData;

    return (
        <div className="min-h-screen bg-[#BD6E37] dark:bg-[#140E0A] text-[#2A1307] dark:text-[#F8F1EB] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full transition-colors">
            {/* Top Navbar */}
            <Navbar routes={routes} activePage="" />

            <main className="flex-grow w-full bg-[#BD6E37] dark:bg-[#140E0A]">
                {/* 1. Hero Section */}
                <section className="w-full pt-8 sm:pt-12 pb-8 sm:pb-10">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        {/* Tombol Kembali & Pill Tag */}
                        <div className="flex items-center gap-3 sm:gap-4 mb-6 flex-wrap">
                            <a
                                href={routes.home || '/'}
                                className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/20 dark:bg-[#231A13]/80 hover:bg-white/30 dark:hover:bg-[#2E2219] text-white dark:text-[#F8F1EB] text-xs font-semibold backdrop-blur-sm border border-white/20 dark:border-[#3A2A1E] transition"
                            >
                                <ArrowLeft className="w-3.5 h-3.5" />
                                <span>Kembali ke Beranda</span>
                            </a>
                            <span className="px-3.5 py-1.5 rounded-full bg-[#8E4A1E]/80 dark:bg-[#2A1B12] border border-[#A85B28] dark:border-[#4A2D1B] text-[#FDEEE0] dark:text-[#E08A58] text-xs font-semibold tracking-wider uppercase shadow-sm">
                                TRANSPARANSI & PERLINDUNGAN DATA
                            </span>
                        </div>

                        {/* Title & Subtitle */}
                        <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] dark:text-[#F8F1EB] tracking-tight leading-[1.15] mb-4">
                            Kebijakan Privasi Portal<br />
                            <span className="italic font-bold text-[#38190C] dark:text-[#E08A58]">PojokNgadiluwih</span>
                        </h1>
                        <p className="font-serif text-[#38190C] dark:text-[#D1C2B8] text-sm sm:text-base leading-relaxed max-w-3xl">
                            Komitmen Pemerintah Desa Ngadiluwih dalam melindungi keamanan data, hak-hak privasi masyarakat, dan kerahasiaan informasi pengguna portal digital desa.
                        </p>
                    </div>
                </section>

                {/* 2. Main Content Card Section */}
                <section className="w-full pb-16 sm:pb-24">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        <div className="bg-[#F5EFE6] dark:bg-[#18120D] rounded-3xl p-6 sm:p-10 md:p-14 shadow-xl border border-[#D5C0AC] dark:border-[#2E2017] space-y-12 transition-colors">
                            
                            {/* Ringkasan Komitmen Utama */}
                            <div className="bg-[#EDE0D1] dark:bg-[#231A13] border border-[#D5C0AC] dark:border-[#3A2A1E] rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div className="w-14 h-14 rounded-2xl bg-[#BD6E37] text-white flex items-center justify-center shrink-0 shadow-md">
                                    <ShieldCheck className="w-8 h-8" />
                                </div>
                                <div className="space-y-1.5 flex-1">
                                    <h3 className="font-serif font-bold text-lg sm:text-xl text-[#38190C] dark:text-[#F8F1EB]">
                                        Sesuai Regulasi UU No. 27 Tahun 2022
                                    </h3>
                                    <p className="text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8] leading-relaxed">
                                        Seluruh pemrosesan, penyimpanan, dan verifikasi data pada platform PojokNgadiluwih tunduk pada ketentuan Undang-Undang Perlindungan Data Pribadi (UU PDP) Republik Indonesia serta asas Keterbukaan Informasi Publik di lingkungan Desa Ngadiluwih.
                                    </p>
                                </div>
                            </div>

                            {/* Grid 4 Pilar Kebijakan */}
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                {/* Pilar 1: Data yang Dikumpulkan */}
                                <div className="bg-[#FAF4ED] dark:bg-[#201812] rounded-2xl p-6 sm:p-8 border border-[#EADBCC] dark:border-[#2E2017] shadow-sm space-y-4 transition-colors">
                                    <div className="w-10 h-10 rounded-xl bg-[#BD6E37]/15 dark:bg-[#BD6E37]/25 text-[#BD6E37] dark:text-[#E08A58] flex items-center justify-center">
                                        <Database className="w-5 h-5" />
                                    </div>
                                    <h3 className="font-serif font-bold text-lg text-[#38190C] dark:text-[#F8F1EB]">
                                        1. Data Pribadi yang Dihimpun
                                    </h3>
                                    <p className="text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8] leading-relaxed">
                                        Kami hanya meminta dan menyimpan data yang relevan secara fungsional untuk keperluan layanan desa:
                                    </p>
                                    <ul className="space-y-2 text-xs sm:text-sm text-[#6E4F3E] dark:text-[#C7B6A8]">
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Pendaftaran Toko UMKM:</strong> Nama pemilik, NIK, nama usaha, foto produk, alamat fisik usaha di desa, dan nomor WhatsApp.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Aspirasi & Pengaduan:</strong> Nama pelapor, nomor telepon/WhatsApp, kategori layanan, dusun asal (Ngadiluwih, Ngadiloyo, Kandang Sapi), serta deskripsi laporan.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Interaksi Chatbot AI:</strong> Riwayat pesan pertanyaan seputar informasi desa guna evaluasi akurasi jawaban (tanpa mengaitkan rekening atau data rahasia perbankan).</span>
                                        </li>
                                    </ul>
                                </div>

                                {/* Pilar 2: Tujuan Penggunaan Data */}
                                <div className="bg-[#FAF4ED] dark:bg-[#201812] rounded-2xl p-6 sm:p-8 border border-[#EADBCC] dark:border-[#2E2017] shadow-sm space-y-4 transition-colors">
                                    <div className="w-10 h-10 rounded-xl bg-[#BD6E37]/15 dark:bg-[#BD6E37]/25 text-[#BD6E37] dark:text-[#E08A58] flex items-center justify-center">
                                        <FileText className="w-5 h-5" />
                                    </div>
                                    <h3 className="font-serif font-bold text-lg text-[#38190C] dark:text-[#F8F1EB]">
                                        2. Tujuan Penggunaan Informasi
                                    </h3>
                                    <p className="text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8] leading-relaxed">
                                        Data yang Anda serahkan digunakan secara eksklusif untuk kepentingan berikut:
                                    </p>
                                    <ul className="space-y-2 text-xs sm:text-sm text-[#6E4F3E] dark:text-[#C7B6A8]">
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span>Memvalidasi identitas warga pemohon surat pengantar dan pelaku usaha binaan desa.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span>Meneruskan pengaduan dan saran warga kepada kepala seksi atau kepala dusun yang berwenang.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span>Mempromosikan katalog produk UMKM lokal kepada calon pembeli melalui direct link WhatsApp.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span>Menyusun statistik agregat (data tanpa nama) untuk perencanaan pembangunan desa berkelanjutan.</span>
                                        </li>
                                    </ul>
                                </div>

                                {/* Pilar 3: Keamanan & Non-Komersialisasi */}
                                <div className="bg-[#FAF4ED] dark:bg-[#201812] rounded-2xl p-6 sm:p-8 border border-[#EADBCC] dark:border-[#2E2017] shadow-sm space-y-4 transition-colors">
                                    <div className="w-10 h-10 rounded-xl bg-[#BD6E37]/15 dark:bg-[#BD6E37]/25 text-[#BD6E37] dark:text-[#E08A58] flex items-center justify-center">
                                        <Lock className="w-5 h-5" />
                                    </div>
                                    <h3 className="font-serif font-bold text-lg text-[#38190C] dark:text-[#F8F1EB]">
                                        3. Keamanan Data & Larangan Penjualan
                                    </h3>
                                    <p className="text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8] leading-relaxed">
                                        Kami memegang teguh integritas perlindungan informasi:
                                    </p>
                                    <ul className="space-y-2 text-xs sm:text-sm text-[#6E4F3E] dark:text-[#C7B6A8]">
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Anti Pihak Ketiga:</strong> Data warga TIDAK PERNAH diperjualbelikan, disewakan, atau dibagikan kepada pihak pengiklan atau korporasi komersial mana pun.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Infrastruktur Cloud Aman:</strong> Data tersimpan dalam Google Cloud Firestore dengan enkripsi data saat transit (TLS/HTTPS) dan saat istirahat (at-rest).</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Hak Akses Bertingkat:</strong> Hanya operator dan pimpinan Pemerintah Desa Ngadiluwih yang memiliki kredensial terautentikasi untuk membuka basis data.</span>
                                        </li>
                                    </ul>
                                </div>

                                {/* Pilar 4: Hak-Hak Warga */}
                                <div className="bg-[#FAF4ED] dark:bg-[#201812] rounded-2xl p-6 sm:p-8 border border-[#EADBCC] dark:border-[#2E2017] shadow-sm space-y-4 transition-colors">
                                    <div className="w-10 h-10 rounded-xl bg-[#BD6E37]/15 dark:bg-[#BD6E37]/25 text-[#BD6E37] dark:text-[#E08A58] flex items-center justify-center">
                                        <UserCheck className="w-5 h-5" />
                                    </div>
                                    <h3 className="font-serif font-bold text-lg text-[#38190C] dark:text-[#F8F1EB]">
                                        4. Hak Pengendalian Warga
                                    </h3>
                                    <p className="text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8] leading-relaxed">
                                        Sebagai subjek data, setiap warga Desa Ngadiluwih berhak:
                                    </p>
                                    <ul className="space-y-2 text-xs sm:text-sm text-[#6E4F3E] dark:text-[#C7B6A8]">
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Hak Memeriksa:</strong> Meminta konfirmasi status pendaftaran toko UMKM atau status tindak lanjut pengaduan yang diajukan.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Hak Memperbaiki:</strong> Mengajukan perubahan informasi nama produk, harga, foto, atau nomor kontak toko apabila terjadi pembaruan.</span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <CheckCircle2 className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Hak Penghapusan (Right to be Forgotten):</strong> Mengajukan permohonan agar data usaha dihapus dari direktori publik jika usaha sudah tidak beroperasi lagi.</span>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            {/* Kotak Kontak Saluran Pengaduan Privasi */}
                            <div className="bg-[#EDE0D1]/60 dark:bg-[#231A13] rounded-2xl p-6 sm:p-8 border border-[#D5C0AC] dark:border-[#3A2A1E] space-y-4 transition-colors">
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 rounded-lg bg-[#BD6E37]/20 dark:bg-[#BD6E37]/30 text-[#BD6E37] dark:text-[#E08A58] flex items-center justify-center">
                                        <HelpCircle className="w-4 h-4" />
                                    </div>
                                    <h3 className="font-serif font-bold text-base sm:text-lg text-[#38190C] dark:text-[#F8F1EB]">
                                        Pertanyaan & Saluran Layanan Privasi
                                    </h3>
                                </div>
                                <p className="text-xs sm:text-sm text-[#543828] dark:text-[#C7B6A8]">
                                    Apabila Anda memiliki pertanyaan, klarifikasi hak data pribadi, atau kendala terkait privasi di platform PojokNgadiluwih, silakan menghubungi kami melalui:
                                </p>
                                
                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                                    <div className="flex items-start gap-3 p-3.5 rounded-xl bg-white/90 dark:bg-[#18120D] border border-[#E0D0C0] dark:border-[#2E2017]">
                                        <MapPin className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                        <div className="text-xs text-[#543828] dark:text-[#C7B6A8]">
                                            <span className="font-semibold block text-[#38190C] dark:text-[#F8F1EB]">Kantor Balai Desa:</span>
                                            Jl. Raya Ngadiluwih No. 12, Kec. Ngadiluwih, Kab. Kediri 64171
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3 p-3.5 rounded-xl bg-white/90 dark:bg-[#18120D] border border-[#E0D0C0] dark:border-[#2E2017]">
                                        <Clock className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5" />
                                        <div className="text-xs text-[#543828] dark:text-[#C7B6A8]">
                                            <span className="font-semibold block text-[#38190C] dark:text-[#F8F1EB]">Jam Operasional:</span>
                                            Senin - Jumat, 08.00 - 16.00 WIB
                                        </div>
                                    </div>

                                    <a
                                        href="https://wa.me/6282131135556"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="flex items-start gap-3 p-3.5 rounded-xl bg-white/90 dark:bg-[#18120D] border border-[#E0D0C0] dark:border-[#2E2017] hover:border-[#BD6E37] dark:hover:border-[#BD6E37] transition group"
                                    >
                                        <Phone className="w-4 h-4 text-[#BD6E37] dark:text-[#E08A58] shrink-0 mt-0.5 group-hover:scale-110 transition-transform" />
                                        <div className="text-xs text-[#543828] dark:text-[#C7B6A8]">
                                            <span className="font-semibold block text-[#38190C] dark:text-[#F8F1EB] group-hover:text-[#BD6E37] transition">WhatsApp Resmi:</span>
                                            +62 821-3113-5556
                                        </div>
                                    </a>
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
