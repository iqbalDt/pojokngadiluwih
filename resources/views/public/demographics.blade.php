@extends('layouts.app')

@section('title', 'Statistik & Demografi Desa')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Transparansi Data</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Statistik & Demografi Penduduk Ngadiluwih</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Visualisasi data kependudukan, sebaran mata pencaharian, tingkat pendidikan, dan wilayah rukun warga Desa Ngadiluwih secara terbuka dan berkala.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Quick Key Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Penduduk</span>
            <p class="text-3xl font-extrabold text-slate-900 mt-2">6.428</p>
            <span class="text-[11px] text-emerald-600 font-medium mt-1 block">Jiwa (Semester I 2026)</span>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kepala Keluarga</span>
            <p class="text-3xl font-extrabold text-slate-900 mt-2">1.842</p>
            <span class="text-[11px] text-emerald-600 font-medium mt-1 block">Kartu Keluarga (KK)</span>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Laki-Laki</span>
            <p class="text-3xl font-extrabold text-emerald-700 mt-2">3.240</p>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">50.4% proporsi</span>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Perempuan</span>
            <p class="text-3xl font-extrabold text-teal-700 mt-2">3.188</p>
            <span class="text-[11px] text-slate-500 font-medium mt-1 block">49.6% proporsi</span>
        </div>
    </div>

    <!-- Charts / Breakdown Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Mata Pencaharian -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center justify-between">
                <span>Mata Pencaharian Utama</span>
                <span class="text-xs text-slate-400 font-normal">Data BPS & Desa</span>
            </h2>
            <div class="space-y-4 text-xs">
                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Petani & Buruh Tani</span>
                        <span class="text-slate-900 font-bold">38% (1.420 jiwa)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 38%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Pelaku UMKM, Pedagang & Wiraswasta</span>
                        <span class="text-slate-900 font-bold">28% (1.045 jiwa)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-teal-500 h-2.5 rounded-full" style="width: 28%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Karyawan Swasta & Buruh Pabrik</span>
                        <span class="text-slate-900 font-bold">20% (746 jiwa)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-cyan-500 h-2.5 rounded-full" style="width: 20%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">PNS, Guru, & TNI/Polri</span>
                        <span class="text-slate-900 font-bold">8% (298 jiwa)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: 8%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Lainnya / Jasa Mandiri</span>
                        <span class="text-slate-900 font-bold">6% (224 jiwa)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-slate-400 h-2.5 rounded-full" style="width: 6%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sebaran Penduduk per Dusun -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center justify-between">
                <span>Sebaran Penduduk per Dusun</span>
                <span class="text-xs text-slate-400 font-normal">4 Dusun</span>
            </h2>
            <div class="space-y-4 text-xs">
                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Dusun Krajan (Pusat Pemerintahan)</span>
                        <span class="text-slate-900 font-bold">1.940 Jiwa (30.2%)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-emerald-600 h-2.5 rounded-full" style="width: 30.2%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Dusun Wonorejo (Sentra UMKM)</span>
                        <span class="text-slate-900 font-bold">1.680 Jiwa (26.1%)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-teal-500 h-2.5 rounded-full" style="width: 26.1%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Dusun Sukorejo (Kawasan Pertanian)</span>
                        <span class="text-slate-900 font-bold">1.518 Jiwa (23.6%)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: 23.6%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1 font-medium">
                        <span class="text-slate-700">Dusun Karangrejo</span>
                        <span class="text-slate-900 font-bold">1.290 Jiwa (20.1%)</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-indigo-500 h-2.5 rounded-full" style="width: 20.1%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
