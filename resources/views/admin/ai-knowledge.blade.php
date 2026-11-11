@extends('layouts.admin')

@section('title', 'Manajemen Knowledge Base AI')
@section('header_title', 'Knowledge Base & Corpus Asisten AI')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between">
            <span>⚠️ {{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Basis Pengetahuan Asisten AI PojokNgadiluwih</h2>
            <p class="text-xs text-slate-500 mt-1">Dokumen dan data referensi yang digunakan oleh model AI dalam menjawab pertanyaan warga secara cerdas.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
                🧠 {{ $documents->count() }} Dokumen Terindeks di Firestore & AI
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
                        <option value="Umum & Layanan">Umum & Layanan</option>
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
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-900">Koleksi Pengetahuan Terindeks</h3>
                <span class="text-xs text-slate-500">Sinkronisasi Python AI: <strong class="text-emerald-600">Real-time</strong></span>
            </div>

            <div class="divide-y divide-slate-100 text-xs flex-1">
                @forelse($documents as $doc)
                    <div class="p-4 hover:bg-slate-50/80 transition flex items-start justify-between gap-4">
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center space-x-2">
                                @php
                                    $badgeColor = match($doc->category) {
                                        'Administrasi & Surat' => 'bg-emerald-50 text-emerald-700',
                                        'Profil & Struktur Desa' => 'bg-teal-50 text-teal-700',
                                        'Katalog UMKM' => 'bg-amber-50 text-amber-700',
                                        'Regulasi & Perdes' => 'bg-indigo-50 text-indigo-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-full font-bold text-[10px] {{ $badgeColor }}">
                                    {{ $doc->category }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    Diperbarui: {{ $doc->created_at->format('d M Y, H:i') }} WIB
                                </span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $doc->topic }}</h4>
                            <p class="text-slate-600 text-xs leading-relaxed line-clamp-2">
                                {{ $doc->content }}
                            </p>
                        </div>
                        <form action="{{ route('admin.ai-knowledge.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen knowledge ini dari Firestore & AI?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold text-xs whitespace-nowrap p-1">
                                Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-400 text-xs space-y-2">
                        <div class="text-3xl mb-2">📚</div>
                        <p class="font-semibold text-slate-600">Belum ada dokumen pengetahuan khusus di Firestore.</p>
                        <p class="text-slate-400">Tambahkan informasi atau SOP desa melalui formulir di sebelah kiri agar AI langsung mempelajarinya.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
