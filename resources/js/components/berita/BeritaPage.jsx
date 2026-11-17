import React, { useState } from 'react';
import Navbar from '../beranda/Navbar';
import NewsHeroSection from './NewsHeroSection';
import NewsGridSection from './NewsGridSection';
import Footer from '../beranda/Footer';

export default function BeritaPage({ initialData = {} }) {
    const {
        routes = {},
        currentSearch = '',
        currentCategory = '',
        news = [],
        pagination = {},
    } = initialData;

    const [activeCategory, setActiveCategory] = useState(currentCategory);

    const handleSearchSubmit = (searchTerm) => {
        const url = new URL(routes.newsIndex || window.location.pathname, window.location.origin);
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
        const url = new URL(routes.newsIndex || window.location.pathname, window.location.origin);
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
            {/* Top Navbar with 'news' active */}
            <Navbar routes={routes} activePage="news" />

            {/* Main Content Sections on Terracotta Background */}
            <main className="flex-grow w-full bg-[#BD6E37]">
                {/* 1. Hero Section: Informative Pill, Large Serif Title, Search & Filter Bar */}
                <NewsHeroSection
                    currentSearch={currentSearch}
                    currentCategory={activeCategory}
                    onSearchSubmit={handleSearchSubmit}
                    onCategoryChange={handleCategoryChange}
                />

                {/* 2. News Cards Grid: 3-column responsive grid matching design screenshot */}
                <NewsGridSection
                    news={news}
                    pagination={pagination}
                    routes={routes}
                />
            </main>

            {/* Bottom Footer with Cream Background */}
            <Footer routes={routes} />
        </div>
    );
}

