import React, { useState } from 'react';
import { ArrowLeft, Calendar, User, Clock, Share2, Check, Newspaper } from 'lucide-react';
import Navbar from '../beranda/Navbar';
import Footer from '../beranda/Footer';

export default function NewsDetailPage({ initialData = {} }) {
    const {
        routes = {},
        news = {},
    } = initialData;

    const [copied, setCopied] = useState(false);

    const handleShare = () => {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href);
            setCopied(true);
            setTimeout(() => setCopied(false), 2500);
        }
    };

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar */}
            <Navbar routes={routes} activePage="news" />

            {/* Main Content Area */}
            <main className="flex-grow w-full py-8 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
                {/* Breadcrumbs */}
                <nav className="flex items-center space-x-2 text-xs font-serif text-[#FFF4E8]/80 mb-6">
                    <a href={routes.home || '/'} className="hover:text-white transition">Beranda</a>
                    <span className="opacity-60">/</span>
                    <a href={routes.newsIndex || '/berita'} className="hover:text-white transition">Berita</a>
                    <span className="opacity-60">/</span>
                    <span className="text-white font-semibold truncate">{news.title || 'Detail Berita'}</span>
                </nav>

                {/* Article Card with Cream/Biscuit Background */}
                <article className="bg-[#FAF4ED] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-xl overflow-hidden p-6 sm:p-10 transition-colors">
                    {/* Meta Header */}
                    <div className="flex flex-wrap items-center gap-2.5 sm:gap-3 text-xs font-serif text-[#765F50] dark:text-[#BCAAA0] mb-4">
                        <span className="px-3 py-1 rounded-full bg-[#2A1307] text-[#FFF4E8] text-[11px] font-bold tracking-wide">
                            {news.category || 'Warta Desa'}
                        </span>
                        <span className="opacity-40">•</span>
                        <span className="inline-flex items-center gap-1.5">
                            <Calendar className="w-3.5 h-3.5 text-[#BD6E37]" />
                            <span>{news.published_at || 'Terbaru'}</span>
                        </span>
                        {news.author_name && (
                            <>
                                <span className="opacity-40">•</span>
                                <span className="inline-flex items-center gap-1.5">
                                    <User className="w-3.5 h-3.5 text-[#BD6E37]" />
                                    <span>Oleh: {news.author_name}</span>
                                </span>
                            </>
                        )}
                        {news.read_time && (
                            <>
                                <span className="opacity-40">•</span>
                                <span className="inline-flex items-center gap-1.5">
                                    <Clock className="w-3.5 h-3.5 text-[#BD6E37]" />
                                    <span>{news.read_time}</span>
                                </span>
                            </>
                        )}
                    </div>

                    {/* Headline Title */}
                    <h1 className="font-serif-title font-bold text-2xl sm:text-4xl text-[#38190C] dark:text-[#F8F1EB] leading-tight mb-6">
                        {news.title}
                    </h1>

                    {/* Featured Image */}
                    {news.image_url ? (
                        <div className="my-6 sm:my-8 w-full rounded-2xl overflow-hidden border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm max-h-[500px]">
                            <img 
                                src={news.image_url} 
                                alt={news.title} 
                                className="w-full h-full object-cover"
                            />
                        </div>
                    ) : (
                        <div className="my-6 sm:my-8 w-full h-64 sm:h-80 rounded-2xl bg-[#D7A376]/30 dark:bg-[#251B15] border border-[#EADBCC] dark:border-[#2A1E17] flex flex-col items-center justify-center text-center p-6 shadow-inner">
                            <Newspaper className="w-16 h-16 text-[#BD6E37] mb-2 opacity-80" />
                            <span className="font-serif font-bold text-sm text-[#38190C] dark:text-[#F8F1EB]">Pojok Berita Desa Ngadiluwih</span>
                        </div>
                    )}

                    {/* Article Body Content */}
                    <div className="font-serif text-[#38190C] dark:text-[#E6D7CD] text-sm sm:text-base leading-relaxed space-y-4 whitespace-pre-line py-2">
                        {news.content}
                    </div>

                    {/* Article Bottom Actions */}
                    <div className="mt-10 pt-6 border-t border-[#EADBCC]/80 dark:border-[#2A1E17] flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a 
                            href={routes.newsIndex || '/berita'} 
                            className="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-xs font-serif font-semibold text-[#38190C] dark:text-[#F8F1EB] bg-[#F5ECE1] dark:bg-[#221A14] hover:bg-[#EADBCC]/60 transition"
                        >
                            <ArrowLeft className="w-4 h-4" />
                            <span>Kembali ke Daftar Berita</span>
                        </a>

                        <div className="flex items-center space-x-2 text-xs font-serif text-[#765F50] dark:text-[#BCAAA0]">
                            <span>Bagikan:</span>
                            <button 
                                type="button" 
                                onClick={handleShare}
                                className="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#F5ECE1] dark:bg-[#221A14] hover:bg-[#BD6E37] hover:text-white dark:hover:bg-[#BD6E37] border border-[#EADBCC] dark:border-[#2A1E17] transition font-medium cursor-pointer"
                            >
                                {copied ? (
                                    <>
                                        <Check className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" />
                                        <span className="text-emerald-700 dark:text-emerald-400 font-bold">Tersalin!</span>
                                    </>
                                ) : (
                                    <>
                                        <Share2 className="w-3.5 h-3.5" />
                                        <span>Salin Tautan</span>
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </article>
            </main>

            {/* Bottom Footer */}
            <Footer routes={routes} />
        </div>
    );
}

