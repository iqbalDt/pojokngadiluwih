@extends('layouts.admin')

@section('title', 'Manajemen Knowledge Base AI')
@section('header_title', 'Knowledge Base & Corpus Asisten AI')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Basis Pengetahuan Asisten AI PojokNgadiluwih</h2>
            <p class="text-xs text-slate-500 mt-1">Dokumen dan data referensi yang digunakan oleh model AI dalam menjawab pertanyaan warga.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
                🧠 5 Dokumen Terindeks di Vector DB
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Knowledge Form -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900">Tambah Pengetahuan Baru</h3>
            <p class="text-xs text-slate-500">Tambahkan informasi terbaru agar asisten virtual langsung dapat menjawab pertanyaan terkait.</p>

            <form action="{{ route('admin.ai-knowledge.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="topic" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Topik / Judul Dokumen <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="topic" name="topic" required placeholder="Contoh: SOP Surat Domisili 2026" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori Pengetahuan <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none bg-white text-slate-700">
                        <option value="Administrasi & Surat">Administrasi & Surat</option>
                        <option value="Regulasi & Perdes">Regulasi & Perdes</option>
                        <option value="Profil & Struktur Desa">Profil & Struktur Desa</option>
                        <option value="Katalog UMKM">Katalog UMKM</option>
                        <option value="Agenda & Kegiatan">Agenda & Kegiatan</option>
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Isi Teks / Penjelasan Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="content" name="content" rows="6" required placeholder="Tuliskan aturan, syarat, jam buka, atau jawaban lengkap yang harus dipahami AI..." class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-1 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition">
                    Simpan & Indeks ke AI
                </button>
            </form>
        </div>

        <!-- Indexed Knowledge List -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Koleksi Pengetahuan Terindeks</h3>
                <span class="text-xs text-slate-500">Sinkronisasi Python AI: <strong class="text-emerald-600">Real-time</strong></span>
            </div>

            <div class="divide-y divide-slate-100 text-xs">
                <!-- Item 1 -->
                <div class="p-4 hover:bg-slate-50/80 transition flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]">Administrasi & Surat</span>
                            <span class="text-[11px] text-slate-400">Diperbarui: 10 Okt 2026</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Persyaratan & Prosedur Surat Keterangan Usaha (SKU)</h4>
                        <p class="text-slate-600 text-xs leading-relaxed line-clamp-2">
                            Dokumen yang wajib dibawa pemohon: Fotokopi KTP Ngadiluwih, Fotokopi KK, Surat Pengantar RT/RW setempat, dan foto tempat usaha. Dilayani Senin-Jumat pukul 08.00 - 15.00 WIB.
                        </p>
                    </div>
                    <form action="{{ route('admin.ai-knowledge.destroy', 1) }}" method="POST" onsubmit="return confirm('Hapus dokumen knowledge ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold text-xs whitespace-nowrap">Hapus</button>
                    </form>
                </div>

                <!-- Item 2 -->
                <div class="p-4 hover:bg-slate-50/80 transition flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 font-bold text-[10px]">Profil & Struktur</span>
                            <span class="text-[11px] text-slate-400">Diperbarui: 05 Okt 2026</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Profil Geografis & Wilayah Desa Ngadiluwih</h4>
                        <p class="text-slate-600 text-xs leading-relaxed line-clamp-2">
                            Desa Ngadiluwih terdiri dari 4 dusun: Dusun Krajan (Pusat Pemerintahan), Dusun Wonorejo (Sentra UMKM Kuliner), Dusun Sukorejo (Pertanian), dan Dusun Karangrejo (Pengrajin).
                        </p>
                    </div>
                    <form action="{{ route('admin.ai-knowledge.destroy', 2) }}" method="POST" onsubmit="return confirm('Hapus dokumen knowledge ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold text-xs whitespace-nowrap">Hapus</button>
                    </form>
                </div>

                <!-- Item 3 -->
                <div class="p-4 hover:bg-slate-50/80 transition flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-bold text-[10px]">Katalog UMKM</span>
                            <span class="text-[11px] text-slate-400">Diperbarui: 02 Okt 2026</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Daftar Produk Unggulan & Kontak Pemesanan UMKM</h4>
                        <p class="text-slate-600 text-xs leading-relaxed line-clamp-2">
                            Informasi katalog produk unggulan desa: Kacang Oven Bu Sumi, Madu Randu Murni, Anyaman Bambu Berkah Jaya, dan Sambal Pecel Asli Kediri lengkap dengan nomor kontak WhatsApp pemesanan.
                        </p>
                    </div>
                    <form action="{{ route('admin.ai-knowledge.destroy', 3) }}" method="POST" onsubmit="return confirm('Hapus dokumen knowledge ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold text-xs whitespace-nowrap">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
