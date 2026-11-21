import React from 'react';
import { ArrowLeft, MessageCircle, MapPin, User, Phone, CheckCircle, ShoppingBag, Store } from 'lucide-react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';

export default function UmkmDetailPage({ initialData = {} }) {
    const {
        routes = {},
        umkm = {},
    } = initialData;

    const waOrderUrl = umkm.whatsapp_order_url || 
        (umkm.whatsapp ? `https://wa.me/${umkm.whatsapp.replace(/\D/g, '').replace(/^0/, '62')}?text=${encodeURIComponent(`Halo ${umkm.name}, saya tertarik dengan produk yang ada di Katalog UMKM Desa Ngadiluwih.`)}` : '#');

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar */}
            <Navbar routes={routes} activePage="umkm" />

            {/* Main Content Area */}
            <main className="flex-grow w-full py-8 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
                {/* Breadcrumb Navigation */}
                <nav className="flex items-center space-x-2 text-xs font-serif text-[#FFF4E8]/80 mb-6">
                    <a href={routes.home || '/'} className="hover:text-white transition">Beranda</a>
                    <span className="opacity-60">/</span>
                    <a href={routes.umkmIndex || '/katalog-umkm'} className="hover:text-white transition">Katalog UMKM</a>
                    <span className="opacity-60">/</span>
                    <span className="text-white font-semibold truncate">{umkm.name || 'Detail Toko'}</span>
                </nav>

                {/* Main Card with Cream/Biscuit Background */}
                <div className="bg-[#FAF4ED] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-xl overflow-hidden p-6 sm:p-10 transition-colors">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                        
                        {/* Left Column: Product / Store Image */}
                        <div className="lg:col-span-5 flex flex-col">
                            <div className="w-full aspect-[4/3] sm:aspect-square rounded-2xl bg-[#D7A376]/30 dark:bg-[#251B15] border border-[#EADBCC] dark:border-[#2A1E17] overflow-hidden relative shadow-inner flex items-center justify-center">
                                {umkm.image_url ? (
                                    <img 
                                        src={umkm.image_url} 
                                        alt={umkm.name} 
                                        className="w-full h-full object-cover"
                                    />
                                ) : (
                                    <div className="flex flex-col items-center justify-center p-8 text-center">
                                        <div className="w-20 h-20 rounded-2xl bg-[#EADBCC]/60 dark:bg-[#2A1E17] flex items-center justify-center text-4xl mb-3 text-[#BD6E37]">
                                            <ShoppingBag className="w-10 h-10 text-[#BD6E37]" />
                                        </div>
                                        <span className="font-serif font-bold text-sm text-[#38190C] dark:text-[#F8F1EB]">
                                            {umkm.name || 'Katalog Resmi UMKM'}
                                        </span>
                                        <span className="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-1">
                                            Desa Ngadiluwih
                                        </span>
                                    </div>
                                )}
                            </div>

                            {/* Back Link */}
                            <div className="mt-6 hidden lg:block">
                                <a 
                                    href={routes.umkmIndex || '/katalog-umkm'}
                                    className="inline-flex items-center gap-2 text-xs font-serif font-semibold text-[#6E4F3E] dark:text-[#BCAAA0] hover:text-[#BD6E37] dark:hover:text-[#E08A58] transition"
                                >
                                    <ArrowLeft className="w-4 h-4" />
                                    <span>Kembali ke Semua Katalog</span>
                                </a>
                            </div>
                        </div>

                        {/* Right Column: Details & Information */}
                        <div className="lg:col-span-7 flex flex-col justify-between">
                            <div>
                                {/* Meta Badges */}
                                <div className="flex flex-wrap items-center gap-2.5 mb-3">
                                    <span className="px-3 py-1 rounded-full bg-[#2A1307] text-[#FFF4E8] text-[11px] font-bold tracking-wide">
                                        {umkm.category || 'Kuliner & Camilan'}
                                    </span>
                                    <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#F5ECE1] dark:bg-[#221A14] text-[#6E4F3E] dark:text-[#D1C2B8] border border-[#EADBCC] dark:border-[#2A1E17] text-[11px] font-serif font-medium">
                                        <MapPin className="w-3.5 h-3.5 text-[#BD6E37]" />
                                        <span>Dusun {umkm.dusun || 'Krajan'}</span>
                                    </span>
                                </div>

                                {/* Store / Product Title */}
                                <h1 className="font-serif-title font-bold text-2xl sm:text-4xl text-[#38190C] dark:text-[#F8F1EB] leading-tight mb-2">
                                    {umkm.name}
                                </h1>

                                {/* Price Tag if Available */}
                                {umkm.price && (
                                    <div className="font-serif font-bold text-lg sm:text-xl text-[#BD6E37] dark:text-[#E08A58] mb-5">
                                        {umkm.price}
                                    </div>
                                )}

                                {/* Deskripsi Usaha */}
                                <div className="mt-5 pt-5 border-t border-[#EADBCC]/80 dark:border-[#2A1E17] space-y-2">
                                    <h2 className="text-[11px] font-bold uppercase tracking-wider text-[#765F50] dark:text-[#BCAAA0] font-serif-title">
                                        Deskripsi
                                    </h2>
                                    <p className="font-serif text-xs sm:text-sm text-[#4E3120] dark:text-[#D1C2B8] leading-relaxed whitespace-pre-line">
                                        {umkm.description || 'Tidak ada deskripsi usaha.'}
                                    </p>
                                </div>

                                {/* Daftar Barang & Produk yang Dijual */}
                                <div className="mt-6 pt-5 border-t border-[#EADBCC]/80 dark:border-[#2A1E17] space-y-2.5">
                                    <h2 className="text-[11px] font-bold uppercase tracking-wider text-[#765F50] dark:text-[#BCAAA0] font-serif-title">
                                        Daftar Barang & Produk yg Dijual
                                    </h2>
                                    {Array.isArray(umkm.products_list) && umkm.products_list.length > 0 ? (
                                        <ul className="space-y-1.5 font-serif text-xs sm:text-sm text-[#38190C] dark:text-[#E6D7CD]">
                                            {umkm.products_list.map((prod, idx) => (
                                                <li key={idx} className="flex items-start gap-2">
                                                    <span className="w-1.5 h-1.5 rounded-full bg-[#BD6E37] mt-1.5 shrink-0" />
                                                    <span>{prod}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    ) : (
                                        <p className="text-xs font-serif italic text-[#8C6D58] dark:text-[#A89284]">
                                            Belum ada daftar rincian barang. Silakan hubungi penjual via WhatsApp untuk info produk lengkap.
                                        </p>
                                    )}
                                </div>

                                {/* Informasi Toko / Penjual */}
                                <div className="mt-6 pt-5 border-t border-[#EADBCC]/80 dark:border-[#2A1E17]">
                                    <h3 className="text-[11px] font-bold uppercase tracking-wider text-[#765F50] dark:text-[#BCAAA0] font-serif-title mb-3">
                                        Informasi Toko / Penjual
                                    </h3>
                                    <div className="bg-[#F5ECE1] dark:bg-[#201812] rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] p-4 text-xs font-serif space-y-2 text-[#4E3120] dark:text-[#D1C2B8]">
                                        <div className="flex items-center gap-2">
                                            <Store className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Nama Usaha:</strong> {umkm.name}</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <User className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Pemilik:</strong> {umkm.owner_name}</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <MapPin className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">Lokasi / Alamat:</strong> {umkm.address}, Dusun {umkm.dusun}</span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <Phone className="w-4 h-4 text-[#BD6E37] shrink-0" />
                                            <span><strong className="text-[#38190C] dark:text-[#F8F1EB]">WhatsApp:</strong> {umkm.whatsapp}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Direct WhatsApp Call to Action */}
                            <div className="mt-8 pt-6 border-t border-[#EADBCC]/80 dark:border-[#2A1E17]">
                                <p className="text-xs font-serif text-[#765F50] dark:text-[#BCAAA0] mb-3 text-center sm:text-left">
                                    Tanyakan ketersediaan produk, varian, dan harga langsung ke penjual:
                                </p>
                                <a
                                    href={waOrderUrl}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="w-full py-3.5 px-6 rounded-2xl bg-[#38190C] hover:bg-[#251007] text-[#FFF8F0] font-bold text-xs sm:text-sm shadow-lg shadow-[#38190C]/25 border border-[#251007] flex items-center justify-center gap-2.5 transition duration-150 cursor-pointer"
                                >
                                    <MessageCircle className="w-5 h-5 fill-current text-[#E08A58]" />
                                    <span>Hubungi & Pesan Langsung via WhatsApp</span>
                                </a>
                            </div>

                            {/* Back Link on Mobile */}
                            <div className="mt-6 text-center lg:hidden">
                                <a 
                                    href={routes.umkmIndex || '/katalog-umkm'}
                                    className="inline-flex items-center gap-2 text-xs font-serif font-semibold text-[#6E4F3E] dark:text-[#BCAAA0] hover:text-[#BD6E37] transition"
                                >
                                    <ArrowLeft className="w-4 h-4" />
                                    <span>Kembali ke Semua Katalog</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </main>

            {/* Bottom Footer */}
            <Footer routes={routes} />
        </div>
    );
}

