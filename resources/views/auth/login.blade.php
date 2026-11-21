<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk Portal Admin - PojokNgadiluwih</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #FFFFFF;
        }
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>
</head>
<body class="min-h-screen bg-white text-[#38190C] antialiased overflow-x-hidden selection:bg-[#B8683B] selection:text-white">
    <div class="min-h-screen flex flex-col lg:flex-row relative">
        
        <!-- Sisi Kiri: Visual Lengkungan Coklat & Lingkaran Gradasi Persis Desain Screenshot -->
        <div class="relative w-full lg:w-[52%] xl:w-[50%] min-h-[380px] sm:min-h-[440px] lg:min-h-screen flex flex-col justify-center px-8 sm:px-14 lg:px-16 xl:px-20 py-12 lg:py-0 overflow-hidden shrink-0 z-10">
            
            <!-- Lengkungan Raksasa Cembung ke Kanan (Main Curved Background) -->
            <div class="absolute inset-y-0 left-0 -right-12 sm:-right-20 lg:-right-28 bg-gradient-to-br from-[#BD693A] via-[#A65427] to-[#5A250E] rounded-b-[4rem] lg:rounded-b-none lg:rounded-r-[100%] shadow-2xl pointer-events-none transform origin-left"></div>

            <!-- Lingkaran Kedua (Pojok Kiri Bawah Terpotong Sesuai Screenshot) -->
            <div class="absolute -bottom-16 -left-16 sm:-bottom-20 sm:-left-20 w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96 rounded-full bg-gradient-to-tr from-[#381608] to-[#8C431D] shadow-xl pointer-events-none z-10"></div>

            <!-- Lingkaran Utama Menonjol (Yang Diberi Tanda Biru di Screenshot User) -->
            <div class="absolute bottom-6 right-2 sm:bottom-8 sm:right-6 lg:bottom-12 lg:-right-14 xl:-right-10 w-64 h-64 sm:w-72 sm:h-72 lg:w-88 lg:h-88 xl:w-96 xl:h-96 rounded-full bg-gradient-to-b from-[#B86333] via-[#853C17] to-[#481E0C] shadow-2xl pointer-events-none z-20"></div>

            <!-- Konten Teks Sisi Kiri -->
            <div class="relative z-30 max-w-lg my-auto py-6">
                <h1 class="font-serif-title text-3xl sm:text-4xl lg:text-[42px] xl:text-5xl font-extrabold uppercase tracking-wide text-white drop-shadow-sm leading-tight">
                    SELAMAT DATANG
                </h1>
                <h2 class="font-serif-title text-xl sm:text-2xl font-semibold text-white/95 mt-3 sm:mt-4 tracking-normal">
                    Portal Admin PojokNgadiluwih
                </h2>
                <p class="text-xs sm:text-sm text-white/80 mt-4 sm:mt-5 leading-relaxed font-normal max-w-md">
                    Kelola data pengguna, pantau aktivitas sistem, dan atur konfigurasi layanan secara terpusat dan aman dalam satu dasbor terpadu
                </p>

                <!-- Tombol Kembali Bersih di Bawah Teks -->
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-medium text-white/80 hover:text-white transition group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Web Desa
                    </a>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Masuk Portal Admin (Persis Desain Screenshot) -->
        <div class="w-full lg:w-[48%] xl:w-[50%] flex items-center justify-center px-6 sm:px-12 lg:px-16 xl:px-24 py-12 lg:py-0 bg-white z-20">
            <div class="w-full max-w-md space-y-6">
                
                <!-- Judul Form Sesuai Gambar -->
                <div>
                    <h2 class="font-serif-title text-3xl sm:text-4xl font-bold text-[#38190C] tracking-tight">
                        Masuk Portal Admin
                    </h2>
                    <p class="text-xs sm:text-sm text-[#5A331E] mt-1.5 font-normal tracking-wide">
                        Akses Khusus Perangkat Desa Ngadiluwih
                    </p>
                </div>

                <!-- Alert Error jika ada kesalahan -->
                @if($errors->any())
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        <div class="flex items-center space-x-2 font-semibold">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.perform') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Petugas Input -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#38190C] mb-2 font-serif-title">
                            Email Petugas
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email', 'admin@ngadiluwih.desa.id') }}" 
                            autocomplete="username" 
                            required 
                            placeholder="admin@ngadiluwih.desa.id"
                            class="w-full px-4 py-3 sm:py-3.5 rounded-2xl border border-stone-300 text-xs sm:text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#B8683B] focus:ring-1 focus:ring-[#B8683B] transition bg-white"
                        >
                    </div>

                    <!-- Kata Sandi Input dengan Toggle Ikon Mata Coret Sesuai Screenshot -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-[#38190C] mb-2 font-serif-title">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                value="password123"
                                autocomplete="current-password" 
                                required 
                                placeholder="••••••••"
                                class="w-full px-4 py-3 sm:py-3.5 pr-12 rounded-2xl border border-stone-300 text-xs sm:text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#B8683B] focus:ring-1 focus:ring-[#B8683B] transition bg-white"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-stone-400 hover:text-stone-600 transition"
                                title="Lihat / Sembunyikan Kata Sandi"
                            >
                                <!-- Eye Off Icon (Mata Coret Sesuai Screenshot) -->
                                <svg id="eye-off-icon" class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                                <!-- Eye Open Icon -->
                                <svg id="eye-icon" class="w-5 h-5 text-stone-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Ingatkan Saya Checkbox -->
                    <div class="flex items-center text-xs text-stone-600 pt-0.5">
                        <label class="flex items-center cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                value="1" 
                                checked
                                class="w-4 h-4 rounded border-stone-300 text-[#B8683B] focus:ring-[#B8683B]"
                            >
                            <span class="ml-2 text-stone-700 text-xs">Ingatkan saya</span>
                        </label>
                    </div>

                    <!-- Tombol Masuk Terracotta Persis Screenshot -->
                    <div class="pt-3">
                        <button 
                            type="submit" 
                            class="w-full py-3.5 px-6 rounded-2xl bg-[#C07044] hover:bg-[#B06035] text-[#38190C] font-semibold text-xs sm:text-sm shadow-md shadow-[#C07044]/25 transition duration-150 transform active:scale-[0.99] flex items-center justify-center cursor-pointer"
                        >
                            <span>Masuk ke portal admin</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
