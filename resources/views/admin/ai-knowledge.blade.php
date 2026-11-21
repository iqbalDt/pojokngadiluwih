@extends('layouts.admin')

@section('title', 'Manajemen Knowledge Base AI')

@section('custom_header_title')
<div class="py-1">
    <h1 class="font-serif-title text-xl sm:text-2xl lg:text-[26px] font-bold text-[#38190C] dark:text-[#F8F1EB] tracking-tight">
        Manajemen Knowledge Base <span class="italic font-normal">AI</span>
    </h1>
    <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5 font-normal">
        Kelola korpus informasi desa, dokumen pedoman, dan data acuan untuk asisten AI warga
    </p>
</div>
@endsection

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-[#ECFDF5] dark:bg-[#064E3B]/30 border border-[#A7F3D0] dark:border-[#065F46] text-[#065F46] dark:text-[#A7F3D0] text-xs font-semibold flex items-center justify-between shadow-sm">
            <span>✅ {{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900 text-rose-800 dark:text-rose-300 text-xs font-semibold flex items-center justify-between shadow-sm">
            <span>⚠️ {{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Formulir Tambah Pengetahuan Baru -->
        <div class="bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8 space-y-5">
            <div class="border-b border-[#EADBCC]/80 dark:border-[#2A1E17] pb-3">
                <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB]">
                    Tambah Pengetahuan Baru
                </h3>
                <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-1">
                    Tambahkan informasi terbaru agar asisten virtual desa langsung dapat menjawab pertanyaan warga.
                </p>
            </div>

            <form action="{{ route('admin.ai-knowledge.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="topic" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Topik / Judul Dokumen <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="topic" 
                        name="topic" 
                        required 
                        placeholder="Contoh: SOP Surat Domisili 2026" 
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition"
                    >
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Kategori Pengetahuan <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        required 
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-stone-800 dark:text-[#F8F1EB] focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition"
                    >
                        <option value="Administrasi & Surat">Administrasi & Surat</option>
                        <option value="Regulasi & Perdes">Regulasi & Perdes</option>
                        <option value="Profil & Struktur Desa">Profil & Struktur Desa</option>
                        <option value="Katalog UMKM">Katalog UMKM</option>
                        <option value="Agenda & Kegiatan">Agenda & Kegiatan</option>
                        <option value="Umum & Layanan">Umum & Layanan</option>
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-xs font-bold text-[#38190C] dark:text-[#F8F1EB] uppercase tracking-wider mb-2 font-serif-title">
                        Isi Teks / Penjelasan Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="6" 
                        required 
                        placeholder="Tuliskan aturan, syarat, jam buka, atau jawaban lengkap yang harus dipahami AI..." 
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17] text-stone-800 dark:text-[#F8F1EB] placeholder-stone-400 focus:outline-none focus:border-[#C07044] focus:ring-1 focus:ring-[#C07044] bg-[#FAF4ED] dark:bg-[#221A14] transition"
                    ></textarea>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3.5 px-6 rounded-2xl bg-[#C07044] hover:bg-[#B06035] text-white font-semibold text-xs sm:text-sm shadow-md shadow-[#C07044]/25 transition duration-150 cursor-pointer"
                    >
                        Simpan & Indeks ke AI
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Koleksi Pengetahuan Terindeks -->
        <div class="lg:col-span-2 bg-[#FBF4EC] dark:bg-[#18120D] rounded-3xl border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm p-6 sm:p-8 flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#EADBCC]/80 dark:border-[#2A1E17] gap-2 mb-4">
                    <div>
                        <h3 class="font-serif-title text-base sm:text-lg font-bold text-[#38190C] dark:text-[#F8F1EB]">
                            Koleksi Pengetahuan Terindeks
                        </h3>
                        <p class="text-xs text-[#765F50] dark:text-[#BCAAA0] mt-0.5">
                            Sinkronisasi Python AI: <strong class="text-[#059669]">Real-time</strong>
                        </p>
                    </div>
                    <span class="px-3.5 py-1.5 rounded-2xl bg-[#FAF4ED] dark:bg-[#221A14] border border-[#EADBCC] dark:border-[#2A1E17] text-stone-700 dark:text-[#F8F1EB] text-xs font-medium self-start sm:self-auto shadow-sm">
                        🧠 <strong>{{ $documents->count() }} Dokumen</strong> Terindeks
                    </span>
                </div>

                <div class="space-y-3.5">
                    @forelse($documents as $doc)
                        <div class="p-5 rounded-2xl bg-[#FAF4ED] dark:bg-[#1E1712] border border-[#EADBCC] dark:border-[#2A1E17] shadow-sm hover:border-[#C07044] hover:bg-[#F3E7DA] dark:hover:bg-[#251D17] transition flex items-start justify-between gap-4">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-3 py-0.5 rounded-full font-bold text-[10px] bg-[#F5ECE1] dark:bg-[#2D211A] border border-[#EADBCC] dark:border-[#3D2C22] text-[#B45309] dark:text-[#FBBF24]">
                                        {{ $doc->category }}
                                    </span>
                                    <span class="text-[11px] text-stone-400">
                                        Diperbarui: {{ $doc->created_at ? $doc->created_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                                <h4 class="font-serif-title font-bold text-sm sm:text-base text-[#38190C] dark:text-[#F8F1EB]">
                                    {{ $doc->topic }}
                                </h4>
                                <p class="text-stone-600 dark:text-[#D1C2B8] text-xs leading-relaxed line-clamp-3">
                                    {{ $doc->content }}
                                </p>
                            </div>
                            <form action="{{ route('admin.ai-knowledge.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen knowledge ini dari Firestore & AI?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-700 font-bold text-xs whitespace-nowrap p-1 cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="p-12 text-center text-stone-400 text-xs space-y-2 bg-[#FAF4ED] dark:bg-[#1E1712] rounded-2xl border border-[#EADBCC] dark:border-[#2A1E17]">
                            <div class="text-3xl mb-2">📚</div>
                            <p class="font-semibold text-stone-700 dark:text-[#F8F1EB] text-sm">Belum ada dokumen pengetahuan khusus di Firestore.</p>
                            <p class="text-stone-400">Tambahkan informasi atau pedoman desa melalui formulir di sebelah kiri agar AI langsung mempelajarinya.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Footer Info -->
            <div class="pt-6 border-t border-[#EADBCC]/80 dark:border-[#2A1E17] mt-6 flex items-center justify-between text-xs text-[#765F50] dark:text-[#BCAAA0]">
                <span>Basis Pengetahuan AI PojokNgadiluwih</span>
                <span class="text-stone-400 text-[11px]">Firestore Cloud Datastore</span>
            </div>
        </div>

    </div>
</div>
@endsection
