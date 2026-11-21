<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PojokNgadiluwih') - Portal Digital Desa Ngadiluwih</title>
    <meta name="description" content="@yield('meta_description', 'Portal Digital Desa Ngadiluwih: Layanan Informasi, Pengurusan Surat, Direktori UMKM Lokal, dan Asisten AI.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts and Styles -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased selection:bg-[#BD6E37] selection:text-white {{ request()->routeIs('home', 'profile', 'news.*', 'umkm.*', 'services.*', 'demographics', 'privacy') ? 'bg-[#BD6E37]' : 'bg-slate-50' }}">

    <!-- Navbar -->
    @if(!request()->routeIs('home', 'profile', 'news.*', 'umkm.*', 'services.*', 'demographics', 'privacy'))
        @include('layouts.components.navbar')
    @endif

    <!-- Flash message notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex items-center space-x-3 text-emerald-800 text-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @if(!request()->routeIs('home', 'profile', 'news.*', 'umkm.*', 'services.*', 'demographics', 'privacy'))
        @include('layouts.components.footer')
    @endif

    <!-- Chatbot Widget -->
    @include('layouts.components.chatbot-widget')

    @stack('scripts')
</body>
</html>
