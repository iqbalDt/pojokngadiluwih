@extends('layouts.app')

@section('title', 'Kanal Aspirasi & Pengaduan Warga')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Partisipasi Warga</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Kanal Aspirasi & Pengaduan Masyarakat</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Sampaikan usulan pembangunan, aspirasi sosial, maupun laporan kendala fasilitas umum secara langsung kepada jajaran aparatur Desa Ngadiluwih.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('services.feedback.submit') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Identitas Pelapor -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required placeholder="Nama Anda" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor Kontak / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="phone" name="phone" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Dusun & Kategori Aspirasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="dusun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Dusun Domisili <span class="text-rose-500">*</span>
                    </label>
                    <select id="dusun" name="dusun" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="">Pilih Dusun...</option>
                        <option value="Krajan">Dusun Krajan</option>
                        <option value="Wonorejo">Dusun Wonorejo</option>
                        <option value="Sukorejo">Dusun Sukorejo</option>
                        <option value="Karangrejo">Dusun Karangrejo</option>
                    </select>
                </div>
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori Aspirasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="">Pilih Kategori...</option>
                        <option value="Infrastruktur & Jalan">Infrastruktur & Jalan</option>
                        <option value="Irigasi & Pertanian">Irigasi & Pertanian</option>
                        <option value="Kebersihan & Lingkungan">Kebersihan & Lingkungan</option>
                        <option value="Pelayanan Administrasi">Pelayanan Administrasi</option>
                        <option value="Keamanan & Ketertiban">Keamanan & Ketertiban</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Judul Aspirasi -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Judul Aspirasi / Laporan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title" required placeholder="Contoh: Usulan Perbaikan Lampu Penerangan Jalan Dusun Wonorejo" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
            </div>

            <!-- Isi Pesan Aspirasi -->
            <div>
                <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Rincian Aspirasi / Saran <span class="text-rose-500">*</span>
                </label>
                <textarea id="message" name="message" rows="5" required placeholder="Tuliskan secara lengkap lokasi, kronologi, atau usulan solusi yang Anda sampaikan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none"></textarea>
            </div>

            <!-- Checkbox Privasi -->
            <div class="flex items-start space-x-2 text-xs text-slate-600">
                <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500">
                <label for="is_anonymous">Rahasiakan identitas saya (hanya dilihat oleh Kepala Desa dan admin resmi desa).</label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/25 transition">
                    Kirim Aspirasi Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
