<nav class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Brand / Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 font-bold text-lg">
                        PN
                    </span>
                    <span class="font-bold text-xl tracking-tight text-slate-800">
                        Pojok<span class="text-emerald-600">Ngadiluwih</span>
                    </span>
                </a>
            </div>

            <!-- Desktop Nav Items -->
            <div class="hidden md:flex items-center space-x-1 lg:space-x-2 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:text-emerald-600 hover:bg-slate-50 transition {{ request()->routeIs('home') ? 'text-emerald-600 bg-emerald-50/70' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('profile') }}" class="px-3 py-2 rounded-lg hover:text-emerald-600 hover:bg-slate-50 transition {{ request()->routeIs('profile') ? 'text-emerald-600 bg-emerald-50/70' : '' }}">
                    Profil Desa
                </a>
                <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-600 hover:bg-slate-50 transition {{ request()->routeIs('news.*') ? 'text-emerald-600 bg-emerald-50/70' : '' }}">
                    Berita
                </a>
                <a href="{{ route('umkm.index') }}" class="px-3 py-2 rounded-lg hover:text-emerald-600 hover:bg-slate-50 transition {{ request()->routeIs('umkm.*') ? 'text-emerald-600 bg-emerald-50/70' : '' }}">
                    Katalog UMKM
                </a>

                <!-- Dropdown Layanan -->
                <div class="relative group">
                    <button class="px-3 py-2 rounded-lg hover:text-emerald-600 hover:bg-slate-50 transition flex items-center space-x-1 {{ request()->routeIs('services.*') ? 'text-emerald-600 bg-emerald-50/70' : '' }}">
                        <span>Layanan</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-slate-100 py-2 hidden group-hover:block transition duration-150 z-50">
                        <a href="{{ route('services.guides') }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                            Panduan Surat Desa
                        </a>
                        <a href="{{ route('services.store-register') }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                            Daftar Toko UMKM
                        </a>
                        <a href="{{ route('services.feedback') }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                            Aspirasi & Pengaduan
                        </a>
                    </div>
                </div>

                <a href="{{ route('demographics') }}" class="px-3 py-2 rounded-lg hover:text-emerald-600 hover:bg-slate-50 transition {{ request()->routeIs('demographics') ? 'text-emerald-600 bg-emerald-50/70' : '' }}">
                    Demografi
                </a>
            </div>

            <!-- Right Actions -->
            <div class="hidden sm:flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                    <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Portal Admin
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 rounded-lg text-slate-600 hover:text-emerald-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-2 pb-4 space-y-1 text-sm font-medium">
        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Beranda</a>
        <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Profil Desa</a>
        <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Berita</a>
        <a href="{{ route('umkm.index') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Katalog UMKM</a>
        <a href="{{ route('services.guides') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Panduan Surat</a>
        <a href="{{ route('services.store-register') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Daftar Toko UMKM</a>
        <a href="{{ route('services.feedback') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Aspirasi & Pengaduan</a>
        <a href="{{ route('demographics') }}" class="block px-3 py-2 rounded-md hover:bg-slate-50">Demografi</a>
        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-emerald-700 bg-emerald-50 font-semibold mt-2">Masuk Portal Admin</a>
    </div>
</nav>
