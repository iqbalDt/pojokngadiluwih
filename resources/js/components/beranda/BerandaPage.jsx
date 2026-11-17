import React from 'react';
import Navbar from './Navbar';
import HeroSection from './HeroSection';
import AgendaAndStatsSection from './AgendaAndStatsSection';
import UmkmAndNewsSection from './UmkmAndNewsSection';
import AiAssistantSection from './AiAssistantSection';
import Footer from './Footer';

export default function BerandaPage({ initialData = {} }) {
    const {
        latestNews = [],
        featuredUmkm = [],
        routes = {},
    } = initialData;

    return (
        <div className="min-h-screen bg-[#F5EFE6] text-[#3D1E0F] flex flex-col font-sans selection:bg-[#BD6E37] selection:text-white">
            {/* Top Navbar */}
            <Navbar routes={routes} />

            {/* Main Content Sections */}
            <main className="flex-grow">
                {/* 1. Hero Section (MacBook Air - 1) */}
                <HeroSection routes={routes} />

                {/* 2. Agenda Terkini & Tentang Website + Stats (MacBook Air - 2) */}
                <AgendaAndStatsSection />

                {/* 3. Katalog UMKM & Kabar Desa (MacBook Air - 6) */}
                <UmkmAndNewsSection
                    featuredUmkm={featuredUmkm}
                    latestNews={latestNews}
                    routes={routes}
                />

                {/* 4. Fitur Cerdas AI Assistance Banner (Frame 13) */}
                <AiAssistantSection />
            </main>

            {/* Bottom Footer */}
            <Footer routes={routes} />
        </div>
    );
}

