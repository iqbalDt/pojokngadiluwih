import React, { useState } from 'react';
import { Sun, Moon, Menu, X } from 'lucide-react';

export default function Navbar({ routes = {}, activePage = 'home' }) {
    const [mobileOpen, setMobileOpen] = useState(false);
    const [darkMode, setDarkMode] = useState(false);

    const navLinks = [
        { key: 'home', label: 'Beranda', href: routes.home || '/' },
        { key: 'profile', label: 'Profil Desa', href: routes.profile || '/profil' },
        { key: 'news', label: 'Berita', href: routes.newsIndex || '/berita' },
        { key: 'umkm', label: 'Katalog UMKM', href: routes.umkmIndex || '/umkm' },
        { key: 'services', label: 'Layanan', href: routes.servicesGuides || '/layanan/panduan' },
        { key: 'demographics', label: 'Demografi', href: routes.demographics || '/demografi' },
    ];

    const toggleTheme = () => {
        setDarkMode(!darkMode);
        document.documentElement.classList.toggle('dark');
    };

    return (
        <header className="sticky top-0 z-40 bg-[#F5EFE6]/95 backdrop-blur-md border-b border-[#E7DAC9] transition-colors w-full">
            {/* Full-width container with responsive horizontal edge padding */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                <div className="flex items-center justify-between h-20">
                    {/* Brand Logo - Rata Kiri */}
                    <a href={routes.home || '/'} className="flex items-center gap-2 group shrink-0">
                        <span className="font-serif italic font-bold text-2xl sm:text-3xl text-[#3D1E0F] tracking-tight group-hover:text-[#BD6E37] transition">
                            PojokNgadiluwih
                        </span>
                    </a>

                    {/* Desktop Navigation - Tersebar Proporsional */}
                    <nav className="hidden lg:flex items-center gap-7 xl:gap-10">
                        {navLinks.map((item) => {
                            const isActive = item.key === activePage;
                            return (
                                <a
                                    key={item.key}
                                    href={item.href}
                                    className={`text-sm lg:text-base font-medium transition-all ${
                                        isActive
                                            ? 'text-[#3D1E0F] font-bold border-b-2 border-[#3D1E0F] pb-1'
                                            : 'text-[#6E5343] hover:text-[#BD6E37]'
                                    }`}
                                >
                                    {item.label}
                                </a>
                            );
                        })}
                    </nav>

                    {/* Right Controls: Theme Toggle & Mobile Menu - Rata Kanan */}
                    <div className="flex items-center gap-3 shrink-0">
                        {/* Dark/Light mode toggle pill */}
                        <button
                            type="button"
                            onClick={toggleTheme}
                            aria-label="Toggle theme"
                            className="relative w-16 h-8 rounded-full bg-[#E4D5C3] p-1 flex items-center justify-between text-[#7C5F4D] hover:bg-[#DBCABA] transition shadow-inner"
                        >
                            <Sun className="w-4 h-4 ml-0.5 text-amber-700" />
                            <Moon className="w-4 h-4 mr-0.5 text-[#5C4233]" />
                            <span
                                className={`absolute top-1 w-6 h-6 rounded-full bg-[#3D1E0F] shadow-sm transform transition-transform duration-200 flex items-center justify-center text-white ${
                                    darkMode ? 'translate-x-8 bg-[#BD6E37]' : 'translate-x-0'
                                }`}
                            >
                                {darkMode ? <Moon className="w-3 h-3" /> : <Sun className="w-3 h-3" />}
                            </span>
                        </button>

                        {/* Mobile Hamburger */}
                        <button
                            type="button"
                            onClick={() => setMobileOpen(!mobileOpen)}
                            className="lg:hidden p-2 rounded-xl text-[#3D1E0F] hover:bg-[#EADBCE] transition"
                            aria-label="Toggle Navigation Menu"
                        >
                            {mobileOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
                        </button>
                    </div>
                </div>
            </div>

            {/* Mobile Dropdown */}
            {mobileOpen && (
                <div className="lg:hidden bg-[#F5EFE6] border-b border-[#E7DAC9] px-4 sm:px-8 pt-2 pb-6 space-y-2">
                    {navLinks.map((item) => {
                        const isActive = item.key === activePage;
                        return (
                            <a
                                key={item.key}
                                href={item.href}
                                onClick={() => setMobileOpen(false)}
                                className={`block px-4 py-2.5 rounded-xl text-sm font-medium ${
                                    isActive
                                        ? 'bg-[#3D1E0F] text-white font-bold'
                                        : 'text-[#5C4233] hover:bg-[#EADBCE]'
                                }`}
                            >
                                {item.label}
                            </a>
                        );
                    })}
                </div>
            )}
        </header>
    );
}
