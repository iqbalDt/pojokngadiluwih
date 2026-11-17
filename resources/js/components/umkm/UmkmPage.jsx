import React, { useState } from 'react';
import Navbar from '../beranda/Navbar';
import UmkmHeroSection from './UmkmHeroSection';
import UmkmGridSection from './UmkmGridSection';
import Footer from '../beranda/Footer';

export default function UmkmPage({ initialData = {} }) {
    const {
        routes = {},
        currentSearch = '',
        currentCategory = '',
        umkms = [],
        pagination = {},
    } = initialData;

    const [activeCategory, setActiveCategory] = useState(currentCategory);

    const handleSearchSubmit = (searchTerm) => {
        const url = new URL(routes.umkmIndex || window.location.pathname, window.location.origin);
        if (searchTerm) {
            url.searchParams.set('q', searchTerm);
        } else {
            url.searchParams.delete('q');
        }
        if (activeCategory) {
            url.searchParams.set('category', activeCategory);
        }
        window.location.href = url.toString();
    };

    const handleCategoryChange = (categoryVal) => {
        setActiveCategory(categoryVal);
        const url = new URL(routes.umkmIndex || window.location.pathname, window.location.origin);
        if (currentSearch) {
            url.searchParams.set('q', currentSearch);
        }
        if (categoryVal) {
            url.searchParams.set('category', categoryVal);
        } else {
            url.searchParams.delete('category');
        }
        window.location.href = url.toString();
    };

    return (
        <div className="min-h-screen bg-[#BD6E37] text-[#2A1307] flex flex-col font-sans selection:bg-[#2A1307] selection:text-white w-full">
            {/* Top Navbar with 'umkm' active */}
            <Navbar routes={routes} activePage="umkm" />

            {/* Main Content */}
            <main className="flex-grow w-full bg-[#BD6E37]">
                {/* 1. Hero: Breadcrumb, Title, Search, Category Pills */}
                <UmkmHeroSection
                    currentSearch={currentSearch}
                    currentCategory={activeCategory}
                    onSearchSubmit={handleSearchSubmit}
                    onCategoryChange={handleCategoryChange}
                    routes={routes}
                />

                {/* 2. Product Cards Grid */}
                <UmkmGridSection
                    umkms={umkms}
                    pagination={pagination}
                    routes={routes}
                />
            </main>

            {/* Footer */}
            <Footer routes={routes} />
        </div>
    );
}

