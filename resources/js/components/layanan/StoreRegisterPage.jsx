import React, { useState } from 'react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';
import { CheckCircle2, AlertCircle } from 'lucide-react';

export default function StoreRegisterPage({ initialData = {} }) {
    const {
        routes = {},
        csrfToken = '',
        oldInput = {},
        errors = {},
        flashSuccess = '',
    } = initialData;

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar with 'services' active and 'store-register' subpage */}
            <Navbar routes={routes} activePage="services" activeSubpage="store-register" />

            <main className="flex-grow w-full bg-[#BD6E37] pb-16 sm:pb-24">
                {/* 1. Hero Section */}
                <section className="w-full pt-8 sm:pt-12 pb-6">
                    <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                        {/* Pill Tag */}
                        <div className="flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-semibold tracking-wider uppercase mb-5 flex-wrap">
                            <span className="px-4 py-1.5 rounded-full bg-[#8E4A1E]/80 border border-[#A85B28] text-[#FDEEE0] shadow-sm">
                                PEMBERDAYAAN UMKM
                            </span>
                            <span className="text-[#FDEEE0]/60 font-normal">|</span>
                            <span className="text-[#FDEEE0] tracking-wider">
                                KECAMATAN NGADILUWIH, KAB. KEDIRI
                            </span>
                        </div>

                        {/* Title */}
                        <h1 className="font-serif font-extrabold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#2A1307] tracking-tight leading-[1.15] mb-3">
                            Formulir Pendaftaran<br />
                            <span className="italic font-bold">Toko UMKM Desa</span>
                        </h1>

                        {/* Subtitle */}
                        <p className="font-serif text-[#38190C] text-sm sm:text-base leading-relaxed max-w-2xl">
                            Promosikan usaha anda ke seluruh masyarakat melalui katalog digital PojokNgadiluwih dengan direct order Whatsapp secara gratis
                        </p>
                    </div>
                </section>

                {/* 2. Form Section */}
                <section className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                    <div className="max-w-3xl mx-auto bg-[#EFE1CF] rounded-[32px] p-6 sm:p-10 shadow-xl border border-[#E2CEB9]">
                        {/* Header Pill */}
                        <div className="mb-8">
                            <span className="inline-block px-6 py-2.5 rounded-full bg-[#BD6E37] text-white font-serif font-bold text-xs sm:text-sm tracking-widest uppercase shadow-sm">
                                FORM PENGISIAN DATA UMKM
                            </span>
                        </div>

                        {/* Success Notification */}
                        {flashSuccess && (
                            <div className="mb-6 p-4 rounded-2xl bg-emerald-100/80 border border-emerald-300 text-emerald-900 text-xs sm:text-sm flex items-start gap-3">
                                <CheckCircle2 className="w-5 h-5 text-emerald-700 shrink-0 mt-0.5" />
                                <div>
                                    <div className="font-bold">Berhasil Dikirim!</div>
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
                            action={routes.submitStoreRegister || '/layanan/daftar-toko'}
                            method="POST"
                            encType="multipart/form-data"
                            className="space-y-5"
                        >
                            <input type="hidden" name="_token" value={csrfToken} />

                            {/* Nama Pemilik */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    NAMA PEMILIK <span className="text-rose-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="owner_name"
                                    defaultValue={oldInput.owner_name || ''}
                                    required
                                    placeholder="Nama lengkap sesuai KTP"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* NIK Pemilik */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    NIK PEMILIK <span className="text-rose-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nik"
                                    maxLength={16}
                                    defaultValue={oldInput.nik || ''}
                                    required
                                    placeholder="16 digit NIK"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Row: Nama Usaha & Kategori Produk */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                        NAMA USAHA <span className="text-rose-600">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="store_name"
                                        defaultValue={oldInput.store_name || ''}
                                        required
                                        placeholder="Nama usaha / toko"
                                        className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                    />
                                </div>

                                <div>
                                    <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                        KATEGORI PRODUK <span className="text-rose-600">*</span>
                                    </label>
                                    <select
                                        name="category"
                                        defaultValue={oldInput.category || ''}
                                        required
                                        className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                    >
                                        <option value="">Pilih kategori usaha</option>
                                        <option value="Kuliner & Camilan">Kuliner &amp; Camilan</option>
                                        <option value="Pertanian & Hasil Alam">Pertanian &amp; Hasil Alam</option>
                                        <option value="Kerajinan Tangan">Kerajinan Tangan</option>
                                        <option value="Jasa & Servis Lokal">Jasa &amp; Servis Lokal</option>
                                    </select>
                                </div>
                            </div>

                            {/* Row: Dusun Domisili & Nomor Kontak / WhatsApp */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                        DUSUN DOMISILI <span className="text-rose-600">*</span>
                                    </label>
                                    <select
                                        name="dusun"
                                        defaultValue={oldInput.dusun || ''}
                                        required
                                        className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                    >
                                        <option value="">Pilih dusun domisili</option>
                                        <option value="Ngadiluwih">Dusun Ngadiluwih</option>
                                        <option value="Ngadiloyo">Dusun Ngadiloyo</option>
                                        <option value="Kandang Sapi">Dusun Kandang Sapi</option>
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                        NOMER KONTAK / WHATSAPP <span className="text-rose-600">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="whatsapp"
                                        defaultValue={oldInput.whatsapp || ''}
                                        required
                                        placeholder="08xxxxxxxxxx"
                                        className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                    />
                                </div>
                            </div>

                            {/* Alamat Lengkap Usaha */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    ALAMAT LENGKAP USAHA <span className="text-rose-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="address"
                                    defaultValue={oldInput.address || ''}
                                    required
                                    placeholder="Contoh: Jl. Mawar RT.02 RW.01"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Deskripsi Usaha & Produk */}
                            <div>
                                <label className="block text-[11px] sm:text-xs font-serif font-bold uppercase tracking-wider text-[#2A1307] mb-1.5">
                                    DESKRIPSI USAHA &amp; PRODUK <span className="text-rose-600">*</span>
                                </label>
                                <textarea
                                    name="description"
                                    rows={4}
                                    defaultValue={oldInput.description || ''}
                                    required
                                    placeholder="Jelaskan produk apa saja yang Anda jual & kisaran harga"
                                    className="w-full px-4 py-2.5 rounded-xl bg-[#DECBB5]/50 border border-[#CBB39C] text-xs text-[#2A1307] placeholder-[#8C6D58] focus:bg-white focus:outline-none focus:border-[#2A1307] transition"
                                />
                            </div>

                            {/* Submit Button */}
                            <div className="pt-3">
                                <button
                                    type="submit"
                                    className="w-full py-4 px-6 rounded-2xl bg-[#BD6E37] hover:bg-[#A85B28] text-white font-serif font-bold text-sm tracking-widest uppercase transition duration-200 shadow-md cursor-pointer text-center"
                                >
                                    KIRIM PENDAFTARAN SEKARANG
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

