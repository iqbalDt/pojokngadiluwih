import React from 'react';
import { ArrowRight, Lightbulb, Sparkles } from 'lucide-react';

export default function AiAssistantSection() {
    const popularQuestions = [
        'Syarat bikin SKCK Desa',
        'Cara urus surat domisili?',
        'Jam pelayanan balai desa',
        'Syarat daftarkan UMKM',
    ];

    const handlePromptClick = (questionText) => {
        if (typeof window.sendQuickPrompt === 'function') {
            window.sendQuickPrompt(questionText);
        } else if (typeof window.toggleChatbot === 'function') {
            window.toggleChatbot();
        }
    };

    const handleStartChat = () => {
        if (typeof window.toggleChatbot === 'function') {
            window.toggleChatbot();
        }
    };

    return (
        <section className="py-12 sm:py-16 lg:py-20 bg-[#F5EFE6] w-full">
            {/* Full-width container: mengisi dari ujung kiri ke ujung kanan */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-stretch">
                    
                    {/* Left Column: Dark Brown Hero Card (Rata Kiri) */}
                    <div className="lg:col-span-7 xl:col-span-7 bg-[#38190C] text-white rounded-3xl p-8 sm:p-10 xl:p-14 shadow-xl border border-[#4E2412] relative overflow-hidden flex flex-col justify-between">
                        {/* Decorative background glow */}
                        <div className="absolute -top-16 -right-16 w-64 h-64 bg-[#BD6E37]/25 rounded-full blur-3xl pointer-events-none" />

                        <div className="relative z-10 space-y-4 sm:space-y-6">
                            <span className="text-xs sm:text-sm uppercase font-semibold tracking-wider text-[#D5A07A] block">
                                Fitur Cerdas AI
                            </span>

                            <h2 className="font-serif text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold leading-[1.15] text-[#FFF8F3]">
                                Butuh Bantuan <br />
                                Administrasi & Informasi <br />
                                Cepat?
                            </h2>

                            <p className="text-sm sm:text-base lg:text-lg text-[#E5D2C3] leading-relaxed font-light pt-2 max-w-2xl text-justify sm:text-left">
                                Asisten AI PojokNgadiluwih siap menjawab semua pertanyaanmu seputar syarat dokumen, jam buka kantor balai desa, hingga info produk UMKM warga selama 24 jam nonstop.
                            </p>
                        </div>
                    </div>

                    {/* Right Column: Pertanyaan Populer & CTA Button (Rata Kanan) */}
                    <div className="lg:col-span-5 xl:col-span-5 flex flex-col justify-between h-full gap-4">
                        <div className="space-y-3">
                            <span className="text-xs sm:text-sm font-bold tracking-wider text-[#5C4233] uppercase block">
                                PERTANYAAN POPULER WARGA:
                            </span>

                            {/* List of Prompt Pill Buttons */}
                            <div className="flex flex-col gap-2.5 sm:gap-3">
                                {popularQuestions.map((q, idx) => (
                                    <button
                                        key={idx}
                                        type="button"
                                        onClick={() => handlePromptClick(q)}
                                        className="w-full bg-[#E7D6C5] hover:bg-[#DCBEA5] text-[#3D1E0F] rounded-full px-5 sm:px-6 py-3.5 text-xs sm:text-sm font-medium flex items-center gap-3 border border-[#D5C0AD] transition text-left shadow-sm group active:scale-[0.99]"
                                    >
                                        <Lightbulb className="w-4 h-4 text-[#BD6E37] shrink-0 group-hover:scale-110 transition-transform" />
                                        <span className="truncate">{q}</span>
                                    </button>
                                ))}
                            </div>
                        </div>

                        <div className="space-y-3 pt-2">
                            {/* Primary Action Button */}
                            <button
                                type="button"
                                onClick={handleStartChat}
                                className="w-full bg-[#38190C] hover:bg-[#251006] text-white rounded-full px-6 sm:px-8 py-4 sm:py-4.5 text-sm sm:text-base font-semibold flex items-center justify-between shadow-lg hover:shadow-xl transition-all duration-200 group active:scale-[0.98]"
                            >
                                <span className="flex items-center gap-2.5">
                                    <Sparkles className="w-5 h-5 text-[#E2B992]" />
                                    <span>Mulai Percakapan dengan AI</span>
                                </span>
                                <ArrowRight className="w-5 h-5 text-[#E2B992] group-hover:translate-x-1.5 transition-transform" />
                            </button>

                            {/* Status Active 24/7 */}
                            <div className="flex items-center justify-center sm:justify-start gap-2 text-xs sm:text-sm font-medium text-[#2E7D32] pt-1">
                                <span className="w-2.5 h-2.5 rounded-full bg-[#2E7D32] animate-pulse" />
                                <span>Aktif 24/7 dan Siap Melayani Warga</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    );
}
