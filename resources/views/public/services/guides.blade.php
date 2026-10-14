@extends('layouts.app')

@section('title', 'Panduan Pengurusan Surat Desa')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Layanan Administrasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Panduan Persyaratan Surat Desa Ngadiluwih</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Ketahui kelengkapan berkas dan alur permohonan surat pengantar administrasi sebelum datang ke Balai Desa Ngadiluwih.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Surat 1 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-base mb-4">
                    🏢
                </div>
                <h2 class="text-base font-bold text-slate-900">Surat Keterangan Usaha (SKU)</h2>
                <p class="text-xs text-slate-500 mt-1">Untuk keperluan perizinan usaha, pengajuan KUR bank, atau legalitas bisnis mikro.</p>
                
                <h3 class="text-xs font-bold text-slate-700 mt-4 mb-2">Persyaratan:</h3>
                <ul class="text-xs text-slate-600 space-y-1.5 list-disc list-inside">
                    <li>Fotokopi KTP Pemohon (warga Ngadiluwih)</li>
                    <li>Fotokopi Kartu Keluarga (KK)</li>
                    <li>Surat Pengantar dari RT/RW setempat</li>
                    <li>Foto tempat / kegiatan usaha</li>
                </ul>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100">
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Estimasi: 15-30 Menit</span>
            </div>
        </div>

        <!-- Surat 2 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-base mb-4">
                    🛡️
                </div>
                <h2 class="text-base font-bold text-slate-900">Pengantar SKCK Kepolisian</h2>
                <p class="text-xs text-slate-500 mt-1">Surat pengantar desa untuk pembuatan SKCK di Polsek Ngadiluwih / Polres Kediri.</p>
                
                <h3 class="text-xs font-bold text-slate-700 mt-4 mb-2">Persyaratan:</h3>
                <ul class="text-xs text-slate-600 space-y-1.5 list-disc list-inside">
                    <li>Fotokopi KTP & KK Pemohon</li>
                    <li>Surat Pengantar RT/RW</li>
                    <li>Pas foto 4x6 latar belakang merah (2 lembar)</li>
                    <li>Fotokopi Akta Kelahiran / Ijazah Terakhir</li>
                </ul>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100">
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Estimasi: 15 Menit</span>
            </div>
        </div>

        <!-- Surat 3 -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-base mb-4">
                    🏠
                </div>
                <h2 class="text-base font-bold text-slate-900">Surat Keterangan Domisili</h2>
                <p class="text-xs text-slate-500 mt-1">Surat bukti tempat tinggal bagi warga penduduk tetap maupun pendatang sementara.</p>
                
                <h3 class="text-xs font-bold text-slate-700 mt-4 mb-2">Persyaratan:</h3>
                <ul class="text-xs text-slate-600 space-y-1.5 list-disc list-inside">
                    <li>Fotokopi KTP & KK</li>
                    <li>Surat Pengantar RT/RW setempat</li>
                    <li>Surat pernyataan pemilik kontrakan (bagi penyewa)</li>
                </ul>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100">
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">Estimasi: 15 Menit</span>
            </div>
        </div>
    </div>

    <!-- Step Flow -->
    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 mb-6 text-center">4 Langkah Mudah Pengurusan Surat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center mx-auto mb-2">1</div>
                <h3 class="font-bold text-xs text-slate-900">Pengantar RT/RW</h3>
                <p class="text-[11px] text-slate-500 mt-1">Minta surat keterangan / pengantar dari ketua RT & RW domisili Anda.</p>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center mx-auto mb-2">2</div>
                <h3 class="font-bold text-xs text-slate-900">Siapkan Berkas</h3>
                <p class="text-[11px] text-slate-500 mt-1">Bawa dokumen persyaratan seperti KTP, KK, dan berkas pendukung lainnya.</p>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center mx-auto mb-2">3</div>
                <h3 class="font-bold text-xs text-slate-900">Loket Balai Desa</h3>
                <p class="text-[11px] text-slate-500 mt-1">Serahkan ke petugas pelayanan di Balai Desa Ngadiluwih pada jam kerja.</p>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center mx-auto mb-2">4</div>
                <h3 class="font-bold text-xs text-slate-900">Surat Selesai</h3>
                <p class="text-[11px] text-slate-500 mt-1">Surat ditandatangani Kepala Desa dan dibubuhi stempel resmi.</p>
            </div>
        </div>
    </div>
</div>
@endsection
