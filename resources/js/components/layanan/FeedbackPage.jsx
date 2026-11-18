import React from 'react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';
import { CheckCircle2, AlertCircle } from 'lucide-react';

export default function FeedbackPage({ initialData = {} }) {
    const {
        routes = {},
        csrfToken = '',
        oldInput = {},
        errors = {},
        flashSuccess = '',
    } = initialData;

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar with 'services' active and 'feedback' subpage */}
            <Navbar routes={routes} activePage="services" activeSubpage="feedback" />

            <main className="flex-grow w-full bg-[#BD6E37] pb-16 sm:pb-24">
                {/* 1. Hero Section */}
                <section className="w-full pt-8 sm:pt-12 pb-6">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        {/* Pill Tag */}
                        <div className="flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-semibold tracking-wider uppercase mb-5 flex-wrap">
                            <span className="px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEEE0] shadow-sm">
                                PARTISIPASI WARGA
                            </span>
                            <span className="text-[#FDEEE0]/60 font-normal">|</span>
                            <span className="text-[#FDEEE0] tracking-wider">
                                KECAMATAN NGADILUWIH, KAB. KEDIRI
                            </span>
                        </div>

                        {/* Title */}
                        <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] tracking-tight leading-[1.15] mb-3">
                            Kanal Aspirasi &amp;<br />
                            <span className="italic font-bold">Pengaduan Masyarakat</span>
                        </h1>

                        {/* Subtitle */}
                        <p className="font-serif text-[#38190C] text-sm sm:text-base leading-relaxed max-w-2xl">
                            Sampaikan usulan pembangunan, aspirasi sosial, maupun laporan kendala fasilitas secara langsung kepada aparatur Desa Ngadiluwih
                        </p>
                    </div>
                </section>

                {/* 2. Form Section */}
                <section className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                    <div className="max-w-3xl mx-auto bg-[#EFE1CF] rounded-[32px] p-6 sm:p-10 shadow-xl border border-[#E2CEB9]">
                        {/* Header Pill */}
                        <div className="mb-8">
                            <span className="inline-block px-6 py-2.5 rounded-full bg-[#BD6E37] text-white font-serif font-bold text-xs sm:text-sm tracking-widest uppercase shadow-sm">
                                FORM PENGISIAN ASPIRASI
                            </span>
                        </div>

                        {/* Success Notification */}
                        {flashSuccess && (
                            <div className="mb-6 p-4 rounded-2xl bg-emerald-100/80 border border-emerald-300 text-emerald-900 text-xs sm:text-sm flex items-start gap-3">
                                <CheckCircle2 className="w-5 h-5 text-emerald-700 shrink-0 mt-0.5" />
                                <div>
                                    <div className="font-bold">Aspirasi Terkirim!</div>
                                    <p className="mt-0.5">{flashSuccess}</p>
                                </div>
                            </div>
                        )}

                        {/* Form Errors Notification */}
                        {errors && Object.keys(errors).length > 0 && (
                            <div className="mb-6 p-4 rounded-2xl bg-rose-100/80 border border-rose-300 text-rose-900 text-xs sm:text-sm flex items-start gap-3">
                                <AlertCircle className="w-5 h-5 text-rose-700 shrink-0 mt-0.5" />
                                <div>
                                    <div className="font-bold">Mohon periksa kembali isian formulir:</div>
                                    <ul className="list-disc list-inside mt-1 space-y-0.5">
                                        {Object.values(errors).flat().map((err, i) => (
                                            <li key={i}>{err}</li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                        )}

                        {/* Form element with POST */}
                        <form
                            action={routes.submitFeedback || '/layanan/aspirasi'}
                            method="POST"
                            className="space-y-5"
                        >
                            <input type="hidden" name="_token" value={csrfToken} />

                            {/* Nama Lengkap */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    NAMA LENGKAP <span className="text-rose-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    defaultValue={oldInput.name || ''}
                                    required
                                    placeholder="Nama lengkap sesuai KTP"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Nomor Kontak / WhatsApp */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    NOMOR KONTAK / WHATSAPP <span className="text-rose-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="phone"
                                    defaultValue={oldInput.phone || ''}
                                    required
                                    placeholder="08xxxxxxxxxx"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Row: Nama Dusun & Kategori Aspirasi */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                        NAMA DUSUN <span className="text-rose-600">*</span>
                                    </label>
                                    <select
                                        name="dusun"
                                        defaultValue={oldInput.dusun || ''}
                                        required
                                        className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                    >
                                        <option value="">Pilih dusun domisili</option>
                                        <option value="Krajan">Dusun Krajan</option>
                                        <option value="Wonorejo">Dusun Wonorejo</option>
                                        <option value="Sukorejo">Dusun Sukorejo</option>
                                        <option value="Karangrejo">Dusun Karangrejo</option>
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                        KATEGORI ASPIRASI <span className="text-rose-600">*</span>
                                    </label>
                                    <select
                                        name="category"
                                        defaultValue={oldInput.category || ''}
                                        required
                                        className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                    >
                                        <option value="">Pilih kategori aspirasi</option>
                                        <option value="Infrastruktur & Jalan">Infrastruktur &amp; Jalan</option>
                                        <option value="Irigasi & Pertanian">Irigasi &amp; Pertanian</option>
                                        <option value="Kebersihan & Lingkungan">Kebersihan &amp; Lingkungan</option>
                                        <option value="Pelayanan Administrasi">Pelayanan Administrasi</option>
                                        <option value="Keamanan & Ketertiban">Keamanan &amp; Ketertiban</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            {/* Judul Aspirasi / Laporan */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    JUDUL ASPIRASI / LAPORAN <span className="text-rose-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="title"
                                    defaultValue={oldInput.title || ''}
                                    required
                                    placeholder="Contoh: Usulan perbaikan lampu penerangan jalan"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Isi Aspirasi / Laporan */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    ISI ASPIRASI / LAPORAN <span className="text-rose-600">*</span>
                                </label>
                                <textarea
                                    name="message"
                                    rows={4}
                                    defaultValue={oldInput.message || ''}
                                    required
                                    placeholder="Tuliskan secara lengkap kronologi beserta lokasi kejadian..."
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Saran (Opsional) */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    SARAN (OPSIONAL)
                                </label>
                                <textarea
                                    name="suggestion"
                                    rows={3}
                                    defaultValue={oldInput.suggestion || ''}
                                    placeholder="Usulan solusi yang ingin Anda sampaikan (opsional)..."
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Submit Button */}
                            <div className="pt-3">
                                <button
                                    type="submit"
                                    className="w-full py-4 px-6 rounded-2xl bg-[#BD6E37] hover:bg-[#A85B28] text-white font-serif font-bold text-sm tracking-widest uppercase transition duration-200 shadow-md cursor-pointer text-center"
                                >
                                    KIRIM ASPIRASI SEKARANG
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </main>

            {/* Bottom Footer */}
            <Footer routes={routes} />
        </div>
    );
}

