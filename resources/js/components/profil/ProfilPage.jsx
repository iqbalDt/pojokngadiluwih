import React from 'react';
import Navbar from '../beranda/Navbar';
import ProfileHeroSection from './ProfileHeroSection';
import VisiMisiSection from './VisiMisiSection';
import SejarahGeografisSection from './SejarahGeografisSection';
import StrukturOrganisasiSection from './StrukturOrganisasiSection';
import Footer from '../beranda/Footer';

export default function ProfilPage({ initialData = {} }) {
    const { routes = {} } = initialData;

    return (
        <div className="min-h-screen bg-[#F5EFE6] text-[#3D1E0F] flex flex-col font-sans selection:bg-[#BD6E37] selection:text-white w-full">
            {/* Top Navbar with 'profile' active */}
            <Navbar routes={routes} activePage="profile" />

            {/* Main Content Sections */}
            <main className="flex-grow w-full">
                {/* 1. Hero Section Profil Desa */}
                <ProfileHeroSection />

                {/* 2. Visi & Misi Desa */}
                <VisiMisiSection />

                {/* 3. Sejarah Singkat & Kondisi Geografis */}
                <SejarahGeografisSection />

                {/* 4. Struktur Organisasi Pemerintah Desa */}
                <StrukturOrganisasiSection />
            </main>

            {/* Bottom Footer */}
            <Footer routes={routes} />
        </div>
    );
}

