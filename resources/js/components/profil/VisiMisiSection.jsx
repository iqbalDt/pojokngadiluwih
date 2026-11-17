import React from 'react';

export default function VisiMisiSection() {
    const misiList = [
        'Meningkatkan kualitas tata kelola pemerintahan desa yang transparan, akuntabel, dan berbasis teknologi digital.',
        'Mengembangkan potensi perekonomian warga melalui pemberdayaan UMKM lokal dan sektor pertanian produktif.',
        'Meningkatkan kualitas sarana prasarana infrastruktur umum, irigasi, dan fasilitas sosial desa.',
        'Mewujudkan masyarakat yang religius, guyub rukun, dan berdaya saing tinggi.',
    ];

    return (
        <section className="bg-[#BD6E37] pb-12 sm:pb-16 lg:pb-20 w-full">
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-10 items-stretch">
                    
                    {/* Left Card: Visi Desa Ngadiluwih */}
                    <div className="bg-[#EFE1CF] rounded-[28px] sm:rounded-[36px] p-6 sm:p-8 xl:p-10 shadow-sm border border-[#DFCEB9] flex flex-col justify-between h-full">
                        <div>
                            <h2 className="font-serif text-2xl sm:text-3xl font-bold text-[#38190C] mb-5 tracking-tight">
                                Visi desa Ngadiluwih
                            </h2>

                            {/* Inset Quote Box */}
                            <div className="border-l-4 border-[#4A2411] bg-[#FAF1E6] rounded-r-2xl rounded-l-md p-5 sm:p-7 shadow-sm">
                                <p className="font-serif text-sm sm:text-base lg:text-lg text-[#38190C] leading-relaxed">
                                    Terwujudnya Desa Ngadiluwih yang mandiri, sejahtera, berkarakter, dan berdaya saing berbasis potensi pertanian menuju masyarakat yang adil dan makmur.
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Right Card: Misi Desa Ngadiluwih */}
                    <div className="bg-[#EFE1CF] rounded-[28px] sm:rounded-[36px] p-6 sm:p-8 xl:p-10 shadow-sm border border-[#DFCEB9] flex flex-col justify-between h-full">
                        <div>
                            <h2 className="font-serif text-2xl sm:text-3xl font-bold text-[#38190C] mb-5 tracking-tight">
                                Misi desa Ngadiluwih
                            </h2>

                            {/* Inset Numbered List Box */}
                            <div className="bg-[#FAF1E6] rounded-2xl p-5 sm:p-7 border border-[#EBDBC9] shadow-sm">
                                <ol className="font-serif space-y-3 sm:space-y-3.5 text-xs sm:text-sm lg:text-base text-[#38190C] leading-relaxed list-decimal list-outside pl-5 font-normal">
                                    {misiList.map((item, idx) => (
                                        <li key={idx} className="pl-1">
                                            {item}
                                        </li>
                                    ))}
                                </ol>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    );
}
