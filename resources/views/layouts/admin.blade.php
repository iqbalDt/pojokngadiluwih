<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#FAF7F2]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - PojokNgadiluwih</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Vite Assets -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @stack('styles')
</head>
<body class="h-full flex overflow-hidden bg-[#FAF7F2] text-[#38190C] antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 z-40 bg-[#38190C]/50 backdrop-blur-sm lg:hidden hidden transition-opacity"></div>

    <!-- Sidebar Terracotta (Persis Desain Screenshot) -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-[#C47247] text-white flex flex-col transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 shadow-xl lg:shadow-none shrink-0">
        
        <!-- Sidebar Header / Logo -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/15">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-9 h-9 rounded-full bg-[#38190C] text-[#FFF8F0] flex items-center justify-center font-bold text-sm shadow">
                    <svg class="w-5 h-5 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="font-serif-title font-bold text-lg text-white tracking-wide group-hover:text-amber-100 transition">
                    Admin Ngadiluwih
                </span>
            </a>
            <button onclick="toggleAdminSidebar()" class="lg:hidden p-1.5 rounded-lg text-white/80 hover:text-white hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto text-xs font-medium">
            <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-amber-100/75">
                Menu Utama
            </div>

            <!-- Overview Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-3 rounded-2xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#FFFBF5] text-[#38190C] font-semibold shadow-sm' : 'text-white/90 hover:bg-white/15 hover:text-white' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-[#C47247]' : 'text-amber-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Overview Dashboard</span>
            </a>

            <!-- CMS Berita & Informasi -->
            <a href="{{ route('admin.news.index') }}" class="flex items-center px-3.5 py-3 rounded-2xl transition {{ request()->routeIs('admin.news.*') ? 'bg-[#FFFBF5] text-[#38190C] font-semibold shadow-sm' : 'text-white/90 hover:bg-white/15 hover:text-white' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ request()->routeIs('admin.news.*') ? 'text-[#C47247]' : 'text-amber-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>CMS Berita dan Informasi</span>
            </a>

            <!-- Verifikasi Toko UMKM -->
            <a href="{{ route('admin.umkm.index') }}" class="flex items-center px-3.5 py-3 rounded-2xl transition {{ request()->routeIs('admin.umkm.*') ? 'bg-[#FFFBF5] text-[#38190C] font-semibold shadow-sm' : 'text-white/90 hover:bg-white/15 hover:text-white' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ request()->routeIs('admin.umkm.*') ? 'text-[#C47247]' : 'text-amber-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Verifikasi Toko UMKM</span>
            </a>

            <!-- Arsip Layanan & Aspirasi -->
            <a href="{{ route('admin.services.index') }}" class="flex items-center px-3.5 py-3 rounded-2xl transition {{ request()->routeIs('admin.services.*') ? 'bg-[#FFFBF5] text-[#38190C] font-semibold shadow-sm' : 'text-white/90 hover:bg-white/15 hover:text-white' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ request()->routeIs('admin.services.*') ? 'text-[#C47247]' : 'text-amber-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Arsip Layanan & Aspirasi</span>
            </a>

            <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-amber-100/75">
                Data Science
            </div>

            <!-- Insight Kebijakan -->
            <a href="{{ route('admin.insights') }}" class="flex items-center px-3.5 py-3 rounded-2xl transition {{ request()->routeIs('admin.insights') ? 'bg-[#FFFBF5] text-[#38190C] font-semibold shadow-sm' : 'text-white/90 hover:bg-white/15 hover:text-white' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ request()->routeIs('admin.insights') ? 'text-[#C47247]' : 'text-amber-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Insight Kebijakan</span>
            </a>

            <!-- Knowledge Base AI -->
            <a href="{{ route('admin.ai-knowledge.index') }}" class="flex items-center px-3.5 py-3 rounded-2xl transition {{ request()->routeIs('admin.ai-knowledge.*') ? 'bg-[#FFFBF5] text-[#38190C] font-semibold shadow-sm' : 'text-white/90 hover:bg-white/15 hover:text-white' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ request()->routeIs('admin.ai-knowledge.*') ? 'text-[#C47247]' : 'text-amber-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Knowledge Base AI</span>
            </a>
        </nav>

        <!-- Footer / Kembali ke Web Publik (Pill Coklat Gelap) -->
        <div class="p-5 border-t border-white/15">
            <a href="{{ route('home') }}" class="flex items-center justify-center w-full px-4 py-3 text-xs font-semibold rounded-2xl text-[#FFF8F0] bg-[#38190C] hover:bg-[#251007] shadow-sm transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Web Publik
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#FAF7F2]">
        
        <!-- Scrollable content wrapper -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            
            <!-- Top Bar / Header Card (Persis Desain Screenshot) -->
            <header class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-4 sm:px-6 mb-6 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 transition-colors">
                
                <!-- Left: Hamburger (Mobile) + Search Bar Pill / Custom Header Title -->
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <button onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-xl text-[#38190C] dark:text-[#F8F1EB] hover:bg-[#FDF7F0] dark:hover:bg-[#221A14] shrink-0 border border-[#EADBCC] dark:border-[#2A1E17]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    @hasSection('custom_header_title')
                        <div>
                            @yield('custom_header_title')
                        </div>
                    @else
                        <!-- Search Input Pill -->
                        <div class="relative w-full sm:w-80 lg:w-96">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                id="admin-search-input"
                                type="text" 
                                placeholder="@yield('search_placeholder', 'Cari judul berita yang diinginkan')" 
                                class="w-full pl-10 pr-4 py-2.5 rounded-full bg-[#FAF4ED] dark:bg-[#221A14] border border-[#EADBCC] dark:border-[#2A1E17] text-xs text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C47247] focus:ring-1 focus:ring-[#C47247] transition"
                            >
                        </div>
                    @endif
                </div>

                <!-- Right: Mode Switcher, Avatar & Logout -->
                <div class="flex items-center justify-end space-x-3 shrink-0">
                    
                    <!-- Dark/Light Mode Visual Switch -->
                    <button 
                        type="button" 
                        onclick="toggleAdminTheme()" 
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-[#C47247] transition-colors duration-200 ease-in-out focus:outline-none"
                        title="Ganti Tema"
                    >
                        <span class="sr-only">Toggle theme</span>
                        <span id="theme-toggle-dot" class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>

                    <!-- User Avatar -->
                    <div class="w-8 h-8 rounded-full bg-[#FDF7F0] border border-[#EADBCC] text-[#38190C] flex items-center justify-center font-bold text-xs" title="{{ Auth::user()?->email }}">
                        <svg class="w-4 h-4 text-[#38190C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <!-- Tombol Keluar (Merah / Terracotta) -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 text-xs font-semibold rounded-full text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/60 transition flex items-center space-x-1.5" title="Keluar">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Flash messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-[#E8F5E9] border border-[#C8E6C9] text-[#2E7D32] text-xs flex items-center space-x-2">
                    <svg class="w-4 h-4 shrink-0 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Halaman Konten Utama -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            
            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function syncAdminThemeUI() {
            const dot = document.getElementById('theme-toggle-dot');
            if (!dot) return;
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                dot.classList.remove('translate-x-5');
                dot.classList.add('translate-x-0');
            } else {
                dot.classList.remove('translate-x-0');
                dot.classList.add('translate-x-5');
            }
        }

        function toggleAdminTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            if (isDark) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
            syncAdminThemeUI();
        }

        document.addEventListener('DOMContentLoaded', syncAdminThemeUI);
    </script>
    @stack('scripts')
</body>
</html>
