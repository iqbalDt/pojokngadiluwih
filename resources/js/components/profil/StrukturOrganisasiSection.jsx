import React from 'react';

// Reusable 2-tier Org Card matching Image 3
function OrgCard({ role, name, className = '', style = {} }) {
    return (
        <div
            style={style}
            className={`inline-flex flex-col rounded-xl overflow-hidden shadow-sm border border-[#4A2411] text-center shrink-0 w-[142px] select-none ${className}`}
        >
            {/* Top Bar: Dark Brown */}
            <div className="bg-[#4A2411] text-white py-1 px-2 text-[11px] font-semibold tracking-wide whitespace-nowrap">
                {role}
            </div>
            {/* Bottom Bar: Warm Terracotta/Peach */}
            <div className="bg-[#DE9D6D] text-[#38190C] py-1.5 px-2 text-xs font-serif font-bold whitespace-nowrap">
                {name}
            </div>
        </div>
    );
}

export default function StrukturOrganisasiSection() {
    return (
        <section className="bg-[#BD6E37] pb-16 sm:pb-20 lg:pb-24 w-full">
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                {/* Title */}
                <div className="text-center mb-8 sm:mb-10">
                    <h2 className="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-[#2A1307] tracking-tight leading-tight">
                        Struktur Organisasi <br />
                        <span className="font-normal text-[#38190C]">Pemerintah Desa Ngadiluwih</span>
                    </h2>
                </div>

                {/* Main Cream Container Card */}
                <div className="bg-[#EFE1CF] rounded-[28px] sm:rounded-[36px] p-6 sm:p-8 lg:p-12 shadow-sm border border-[#DFCEB9] overflow-x-auto flex justify-center">
                    
                    {/* Fixed Coordinate Canvas (1000px x 520px) matching Image 3 */}
                    <div className="relative w-[1000px] h-[520px] shrink-0 my-2">
                        
                        {/* 1. EXACT SVG VECTOR LINES IN BACKGROUND */}
                        <svg
                            className="absolute inset-0 w-[1000px] h-[520px] pointer-events-none"
                            viewBox="0 0 1000 520"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            {/* Main Vertical Spine (from Kepala Desa bottom straight down to Staff IT crossbar) */}
                            <line x1="475" y1="58" x2="475" y2="415" stroke="#4A2411" strokeWidth="2.5" />

                            {/* Branch 1 to Sekretaris Desa */}
                            <line x1="475" y1="110" x2="699" y2="110" stroke="#4A2411" strokeWidth="2.5" />

                            {/* Drop from Sekretaris Desa to Kaur crossbar */}
                            <line x1="770" y1="133" x2="770" y2="175" stroke="#4A2411" strokeWidth="2.5" />
                            {/* Kaur horizontal crossbar */}
                            <line x1="620" y1="175" x2="920" y2="175" stroke="#4A2411" strokeWidth="2.5" />
                            {/* 3 Drop lines to Kaurs */}
                            <line x1="620" y1="175" x2="620" y2="207" stroke="#4A2411" strokeWidth="2.5" />
                            <line x1="770" y1="175" x2="770" y2="207" stroke="#4A2411" strokeWidth="2.5" />
                            <line x1="920" y1="175" x2="920" y2="207" stroke="#4A2411" strokeWidth="2.5" />

                            {/* Branch 2 to 3 Kasis */}
                            <line x1="75" y1="207" x2="475" y2="207" stroke="#4A2411" strokeWidth="2.5" />
                            {/* 3 Drop lines to Kasis */}
                            <line x1="75" y1="207" x2="75" y2="252" stroke="#4A2411" strokeWidth="2.5" />
                            <line x1="230" y1="207" x2="230" y2="252" stroke="#4A2411" strokeWidth="2.5" />
                            <line x1="385" y1="207" x2="385" y2="252" stroke="#4A2411" strokeWidth="2.5" />

                            {/* Branch 3 to 2 Kasuns */}
                            <line x1="475" y1="295" x2="770" y2="295" stroke="#4A2411" strokeWidth="2.5" />
                            {/* 2 Drop lines to Kasuns */}
                            <line x1="620" y1="295" x2="620" y2="337" stroke="#4A2411" strokeWidth="2.5" />
                            <line x1="770" y1="295" x2="770" y2="337" stroke="#4A2411" strokeWidth="2.5" />

                            {/* Branch 4 to 2 Staff IT Desa */}
                            <line x1="390" y1="415" x2="560" y2="415" stroke="#4A2411" strokeWidth="2.5" />
                            {/* 2 Drop lines to Staff IT */}
                            <line x1="390" y1="415" x2="390" y2="442" stroke="#4A2411" strokeWidth="2.5" />
                            <line x1="560" y1="415" x2="560" y2="442" stroke="#4A2411" strokeWidth="2.5" />
                        </svg>

                        {/* 2. ABSOLUTELY POSITIONED CARDS AT EXACT PIXEL COORDINATES */}
                        
                        {/* Top: Kepala Desa */}
                        <OrgCard
                            role="Kepala Desa"
                            name="L. Ragil Panca Yugha"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '475px', top: '35px', width: '155px' }}
                        />

                        {/* Level 1 Right: Sekretaris Desa */}
                        <OrgCard
                            role="Sekretaris Desa"
                            name="Lutfi Syarif"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '770px', top: '110px', width: '150px' }}
                        />

                        {/* Level 2 Right: 3 Kaurs */}
                        <OrgCard
                            role="Kaur TU & Umum"
                            name="M. H. Farhan F."
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '620px', top: '230px' }}
                        />
                        <OrgCard
                            role="Kaur Keuangan"
                            name="Sohibatul Ulum"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '770px', top: '230px' }}
                        />
                        <OrgCard
                            role="Kaur Perencanaan"
                            name="Syahrul Romadoni"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '920px', top: '230px' }}
                        />

                        {/* Level 2 Left: 3 Kasis */}
                        <OrgCard
                            role="Kasi Pemerintahan"
                            name="Siti Zulaihah"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '75px', top: '275px' }}
                        />
                        <OrgCard
                            role="Kasi Kesejahteraan"
                            name="Ahmad Fiore Yoke A."
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '230px', top: '275px' }}
                        />
                        <OrgCard
                            role="Kasi Pelayanan"
                            name="M. Rois Syaifudin"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '385px', top: '275px' }}
                        />

                        {/* Level 3 Right: 2 Kasuns */}
                        <OrgCard
                            role="Kasun Ngadiluwih"
                            name="Ahmad Shofiyulloh"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '620px', top: '360px' }}
                        />
                        <OrgCard
                            role="Kasun Ngadiloyo"
                            name="Mawardi"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '770px', top: '360px' }}
                        />

                        {/* Level 4 Bottom Center: 2 Staff IT Desa */}
                        <OrgCard
                            role="Staff IT Desa"
                            name="Wildan Hudzaifi"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '390px', top: '465px', width: '155px' }}
                        />
                        <OrgCard
                            role="Staff IT Desa"
                            name="Endah Triwahyuningsih"
                            className="absolute -translate-x-1/2 -translate-y-1/2"
                            style={{ left: '560px', top: '465px', width: '155px' }}
                        />

                    </div>

                </div>

                {/* Mobile scroll hint */}
                <div className="block lg:hidden text-center text-xs text-[#FFF9F3] font-serif italic pt-3 opacity-90">
                    💡 Geser bagan ke samping untuk melihat seluruh aparat desa secara utuh
                </div>
            </div>
        </section>
    );
}
