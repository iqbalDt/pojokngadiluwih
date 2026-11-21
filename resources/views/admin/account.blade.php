@extends('layouts.admin')

@section('title', 'Akun Saya & Keamanan')

@section('custom_header_title')
<div class="py-1">
    <h1 class="font-serif-title text-xl sm:text-2xl lg:text-[26px] font-bold text-[#38190C] dark:text-[#F8F1EB] tracking-tight">
        Akun Saya &amp; <span class="italic font-normal">Keamanan</span>
    </h1>
    <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5 font-normal">
        Kelola nama petugas admin dan perbarui kata sandi akun Anda secara berkala
    </p>
</div>
@endsection

@section('content')
<div class="space-y-6">

    @if(session('warning') || ($admin && ($admin->must_change_password ?? false)))
        <div class="p-4 rounded-2xl bg-[#FEF9EE] dark:bg-amber-950/30 border border-[#FDE68A] dark:border-amber-800/60 text-[#B45309] dark:text-amber-300 text-xs font-semibold flex items-center space-x-2.5 shadow-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>{{ session('warning') ?? 'Anda sedang menggunakan kata sandi sementara. Silakan ganti kata sandi baru pada formulir di sebelah kanan.' }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900 text-rose-800 dark:text-rose-300 text-xs font-semibold shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card 1: Informasi Profil -->
        <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8 space-y-5">
            <div class="border-b border-[#EADBCC]/80 dark:border-[#2A1E17] pb-3">
                <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB]">
                    Informasi Profil Petugas
                </h3>
                <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-1">
                    Nama petugas akan ditampilkan di panel admin desa.
                </p>
            </div>

            <form action="{{ route('admin.account.profile') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="email" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Email Login
                    </label>
                    <input
                        type="email"
                        id="email"
                        value="{{ $admin->email ?? '' }}"
                        disabled
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] bg-[#F0E4D5]/60 dark:bg-[#221A14]/60 text-stone-500 dark:text-[#A8988C] cursor-not-allowed"
                    >
                    <p class="text-[11px] text-[#765F50] dark:text-[#BCAAA0] mt-1.5">
                        Email login dikelola oleh tim pengembang desa.
                    </p>
                </div>

                <div>
                    <label for="name" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Nama Lengkap Petugas <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $admin->name ?? '') }}"
                        required
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] bg-[#FAF4ED] dark:bg-[#221A14] text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] transition"
                    >
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="px-6 py-3 rounded-2xl bg-[#38190C] hover:bg-[#251007] text-white font-semibold text-xs sm:text-sm shadow-sm transition cursor-pointer"
                    >
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Ubah Kata Sandi -->
        <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8 space-y-5">
            <div class="border-b border-[#EADBCC]/80 dark:border-[#2A1E17] pb-3">
                <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB]">
                    Perbarui Kata Sandi
                </h3>
                <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-1">
                    Gunakan kombinasi huruf dan angka minimal 8 karakter agar akun aman.
                </p>
            </div>

            <form action="{{ route('admin.account.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi saat ini"
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] bg-[#FAF4ED] dark:bg-[#221A14] text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] transition"
                    >
                    @error('current_password')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] bg-[#FAF4ED] dark:bg-[#221A14] text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] transition"
                    >
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi baru"
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] bg-[#FAF4ED] dark:bg-[#221A14] text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] transition"
                    >
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#C07044] hover:bg-[#B06035] text-white font-semibold text-xs sm:text-sm shadow-md shadow-[#C07044]/25 transition cursor-pointer"
                    >
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
