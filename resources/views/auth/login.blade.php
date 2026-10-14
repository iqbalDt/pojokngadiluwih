@extends('layouts.app')

@section('title', 'Masuk Panel Petugas')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div class="text-center">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-xl flex items-center justify-center mx-auto shadow-md shadow-emerald-500/20">
                PN
            </div>
            <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Masuk Portal Admin</h2>
            <p class="mt-2 text-xs text-slate-500">
                Akses khusus pamong & perangkat Desa Ngadiluwih
            </p>
        </div>

        <form class="mt-8 space-y-4" action="{{ route('login.perform') }}" method="POST">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Petugas</label>
                <input id="email" name="email" type="email" value="admin@ngadiluwih.desa.id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                <input id="password" name="password" type="password" value="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs text-slate-500">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-2">Ingat saya</span>
                </label>
                <a href="{{ route('home') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Kembali ke Beranda</a>
            </div>

            <div>
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition">
                    Masuk ke Panel Admin
                </button>
            </div>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center">
            <p class="text-[11px] text-slate-400">
                Mode Demo: Form telah terisi otomatis. Klik tombol di atas untuk masuk langsung sebagai Admin Desa.
            </p>
        </div>
    </div>
</div>
@endsection
