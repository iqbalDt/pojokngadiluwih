import React, { useState, useRef, useEffect } from 'react';
import { Sun, Moon, Menu, X, ChevronDown, FileText, Store, MessageSquareQuote } from 'lucide-react';

export default function Navbar({ routes = {}, activePage = 'home', activeSubpage = '' }) {
    const [mobileOpen, setMobileOpen] = useState(false);
    const [darkMode, setDarkMode] = useState(false);
    const [servicesDropdownOpen, setServicesDropdownOpen] = useState(false);
    const [mobileServicesOpen, setMobileServicesOpen] = useState(activePage === 'services');
    const dropdownRef = useRef(null);

    const serviceSubLinks = [
        {
            key: 'guides',
            label: 'Panduan Surat',
            desc: 'Persyaratan & alur surat pengantar',
            href: routes.servicesGuides || '/layanan/panduan',
            icon: FileText,
        },
        {
            key: 'store-register',
            label: 'Daftar Toko UMKM',
            desc: 'Pendaftaran toko ke katalog desa',
            href: routes.servicesStoreRegister || '/layanan/daftar-toko',
            icon: Store,
        },
        {
            key: 'feedback',
            label: 'Aspirasi & Pengaduan',
            desc: 'Saran, aduan & masukan warga',
            href: routes.servicesFeedback || '/layanan/aspirasi',
            icon: MessageSquareQuote,
        },
    ];

    const navLinks = [
        { key: 'home', label: 'Beranda', href: routes.home || '/' },
        { key: 'profile', label: 'Profil Desa', href: routes.profile || '/profil' },
        { key: 'news', label: 'Berita', href: routes.newsIndex || '/berita' },
        { key: 'umkm', label: 'Katalog UMKM', href: routes.umkmIndex || '/umkm' },
        { key: 'services', label: 'Layanan', hasDropdown: true },
        { key: 'demographics', label: 'Demografi', href: routes.demographics || '/demografi' },
    ];

    // Sync theme on mount
    useEffect(() => {
        const stored = localStorage.getItem('theme');
        if (stored === 'dark' || (!stored && document.documentElement.classList.contains('dark'))) {
            setDarkMode(true);
            document.documentElement.classList.add('dark');
        } else {
            setDarkMode(false);
            document.documentElement.classList.remove('dark');
        }
    }, []);

    const toggleTheme = () => {
        setDarkMode((prev) => {
            const next = !prev;
            if (next) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
            return next;
        });
    };

    // Close desktop dropdown on click outside
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setServicesDropdownOpen(false);
            }
        };
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    return (
        <header className={`sticky top-0 z-50 backdrop-blur-md border-b transition-colors duration-300 w-full ${
            darkMode
                ? 'bg-[#1C0F08]/95 border-[#3E1F11]'
                : 'bg-[#F5EFE6]/95 border-[#E7DAC9]'
        }`}>
            {/* Full-width container with responsive horizontal edge padding */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                <div className="flex items-center justify-between h-20">
                    {/* Brand Logo - Rata Kiri */}
                    <a href={routes.home || '/'} className="flex items-center gap-2 group shrink-0">
                        <span className={`font-serif italic font-bold text-2xl sm:text-3xl tracking-tight transition ${
                            darkMode ? 'text-[#FAF1E6] group-hover:text-[#E89E6C]' : 'text-[#3D1E0F] group-hover:text-[#BD6E37]'
                        }`}>
                            PojokNgadiluwih
                        </span>
                    </a>

                    {/* Desktop Navigation */}
                    <nav className="hidden lg:flex items-center gap-6 xl:gap-9">
                        {navLinks.map((item) => {
                            if (item.hasDropdown) {
                                const isServicesActive = activePage === 'services';
                                return (
                                    <div
                                        key={item.key}
                                        ref={dropdownRef}
                                        className="relative"
                                        onMouseEnter={() => setServicesDropdownOpen(true)}
                                        onMouseLeave={() => setServicesDropdownOpen(false)}
                                    >
                                        <button
                                            type="button"
                                            onClick={() => setServicesDropdownOpen(!servicesDropdownOpen)}
                                            aria-expanded={servicesDropdownOpen}
                                            className={`flex items-center gap-1.5 text-sm lg:text-base font-medium transition-all py-2 cursor-pointer ${
                                                isServicesActive
                                                    ? 'text-[#3D1E0F] font-bold border-b-2 border-[#3D1E0F] pb-1'
                                                    : 'text-[#6E5343] hover:text-[#BD6E37]'
                                            }`}
                                        >
                                            <span>{item.label}</span>
                                            <ChevronDown
                                                className={`w-4 h-4 transition-transform duration-200 ${
                                                    servicesDropdownOpen ? 'rotate-180 text-[#BD6E37]' : ''
                                                }`}
                                            />
                                        </button>

                                        {/* Dropdown Menu Container */}
                                        {servicesDropdownOpen && (
                                            <div className="absolute top-full left-1/2 -translate-x-1/2 pt-2 w-72 z-50 animate-fadeIn">
                                                <div className="bg-[#FAF1E6] rounded-2xl shadow-xl border border-[#DECBB8] p-2 space-y-1">
                                                    {serviceSubLinks.map((sub) => {
                                                        const isSubActive = isServicesActive && activeSubpage === sub.key;
                                                        const IconComp = sub.icon;
                                                        return (
                                                            <a
                                                                key={sub.key}
                                                                href={sub.href}
                                                                className={`flex items-start gap-3 p-3 rounded-xl transition group ${
                                                                    isSubActive
                                                                        ? 'bg-[#EFE1CF] text-[#2A1307]'
                                                                        : 'hover:bg-[#EFE1CF]/80 text-[#3D1E0F]'
                                                                }`}
                                                            >
                                                                <div className="w-8 h-8 rounded-lg bg-[#E2D2BE] flex items-center justify-center text-[#2A1307] group-hover:bg-[#BD6E37] group-hover:text-white transition shrink-0 mt-0.5">
                                                                    <IconComp className="w-4 h-4" />
                                                                </div>
                                                                <div>
                                                                    <div className="font-serif font-bold text-sm text-[#2A1307] group-hover:text-[#BD6E37] transition">
                                                                        {sub.label}
                                                                    </div>
                                                                    <div className="text-[11px] text-[#6E4F3E] leading-snug">
                                                                        {sub.desc}
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        );
                                                    })}
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                );
                            }

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

                    {/* Right Controls: Theme Toggle & Mobile Menu */}
                    <div className="flex items-center gap-3 shrink-0">
                        {/* Dark/Light mode toggle pill - interactive and responsive */}
                        <button
                            type="button"
                            onClick={toggleTheme}
                            aria-label={darkMode ? 'Beralih ke mode terang' : 'Beralih ke mode gelap'}
                            title={darkMode ? 'Mode Gelap Aktif (Klik untuk Mode Terang)' : 'Mode Terang Aktif (Klik untuk Mode Gelap)'}
                            className={`relative w-16 h-8 rounded-full p-1 flex items-center justify-between transition-colors duration-300 shadow-inner cursor-pointer select-none border ${
                                darkMode
                                    ? 'bg-[#2E180E] border-[#5C2E18] text-[#FAF1E6]'
                                    : 'bg-[#E5D5C3] border-[#D5C2AF] text-[#3D1E0F]'
                            }`}
                        >
                            <span className="flex items-center justify-center w-6 h-6 z-0">
                                <Sun className={`w-3.5 h-3.5 transition-opacity duration-200 ${darkMode ? 'text-[#8C6D58] opacity-80' : 'opacity-0'}`} />
                            </span>
                            <span className="flex items-center justify-center w-6 h-6 z-0">
                                <Moon className={`w-3.5 h-3.5 transition-opacity duration-200 ${darkMode ? 'opacity-0' : 'text-[#7C5F4D] opacity-80'}`} />
                            </span>
                            <span
                                className={`absolute top-1 left-1 w-6 h-6 rounded-full shadow-md transform transition-all duration-300 ease-out flex items-center justify-center z-10 ${
                                    darkMode
                                        ? 'translate-x-8 bg-[#FAF1E6] text-[#2A1307]'
                                        : 'translate-x-0 bg-[#3D1E0F] text-[#FAF3EA]'
                                }`}
                            >
                                {darkMode ? (
                                    <Moon className="w-3.5 h-3.5 fill-current" />
                                ) : (
                                    <Sun className="w-3.5 h-3.5 fill-current" />
                                )}
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
                        if (item.hasDropdown) {
                            const isServicesActive = activePage === 'services';
                            return (
                                <div key={item.key} className="space-y-1">
                                    <button
                                        type="button"
                                        onClick={() => setMobileServicesOpen(!mobileServicesOpen)}
                                        className={`w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium ${
                                            isServicesActive
                                                ? 'bg-[#3D1E0F] text-white font-bold'
                                                : 'text-[#5C4233] hover:bg-[#EADBCE]'
                                        }`}
                                    >
                                        <span>{item.label}</span>
                                        <ChevronDown
                                            className={`w-4 h-4 transition-transform duration-200 ${
                                                mobileServicesOpen ? 'rotate-180' : ''
                                            }`}
                                        />
                                    </button>

                                    {/* Mobile Submenu Accordion */}
                                    {mobileServicesOpen && (
                                        <div className="pl-4 pr-1 py-1 space-y-1 bg-[#EFE1CF]/50 rounded-xl">
                                            {serviceSubLinks.map((sub) => {
                                                const isSubActive = isServicesActive && activeSubpage === sub.key;
                                                return (
                                                    <a
                                                        key={sub.key}
                                                        href={sub.href}
                                                        onClick={() => setMobileOpen(false)}
                                                        className={`block px-3 py-2 rounded-lg text-xs font-medium transition ${
                                                            isSubActive
                                                                ? 'text-[#BD6E37] font-bold bg-white/70'
                                                                : 'text-[#4D2E1E] hover:bg-white/50'
                                                        }`}
                                                    >
                                                        {sub.label}
                                                    </a>
                                                );
                                            })}
                                        </div>
                                    )}
                                </div>
                            );
                        }

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
