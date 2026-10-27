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
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <p class="font-bold mb-1">Terdapat kesalahan pada isian formulir:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm">
        <form action="{{ route('services.feedback.submit') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Identitas Pelapor -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama Anda" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400' : 'border-slate-300' }} text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                    @error('name')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor Kontak / WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('phone') ? 'border-rose-400' : 'border-slate-300' }} text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                    @error('phone')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Dusun & Kategori Aspirasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="dusun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Dusun Domisili <span class="text-rose-500">*</span>
                    </label>
                    <select id="dusun" name="dusun" required class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('dusun') ? 'border-rose-400' : 'border-slate-300' }} text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="">Pilih Dusun...</option>
                        <option value="Krajan" {{ old('dusun') === 'Krajan' ? 'selected' : '' }}>Dusun Krajan</option>
                        <option value="Wonorejo" {{ old('dusun') === 'Wonorejo' ? 'selected' : '' }}>Dusun Wonorejo</option>
                        <option value="Sukorejo" {{ old('dusun') === 'Sukorejo' ? 'selected' : '' }}>Dusun Sukorejo</option>
                        <option value="Karangrejo" {{ old('dusun') === 'Karangrejo' ? 'selected' : '' }}>Dusun Karangrejo</option>
                    </select>
                    @error('dusun')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori Aspirasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('category') ? 'border-rose-400' : 'border-slate-300' }} text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none bg-white">
                        <option value="">Pilih Kategori...</option>
                        <option value="Infrastruktur & Jalan" {{ old('category') === 'Infrastruktur & Jalan' ? 'selected' : '' }}>Infrastruktur & Jalan</option>
                        <option value="Irigasi & Pertanian" {{ old('category') === 'Irigasi & Pertanian' ? 'selected' : '' }}>Irigasi & Pertanian</option>
                        <option value="Kebersihan & Lingkungan" {{ old('category') === 'Kebersihan & Lingkungan' ? 'selected' : '' }}>Kebersihan & Lingkungan</option>
                        <option value="Pelayanan Administrasi" {{ old('category') === 'Pelayanan Administrasi' ? 'selected' : '' }}>Pelayanan Administrasi</option>
                        <option value="Keamanan & Ketertiban" {{ old('category') === 'Keamanan & Ketertiban' ? 'selected' : '' }}>Keamanan & Ketertiban</option>
                        <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Judul Aspirasi -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Judul Aspirasi / Laporan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Usulan Perbaikan Lampu Penerangan Jalan Dusun Wonorejo" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('title') ? 'border-rose-400' : 'border-slate-300' }} text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                @error('title')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Pesan Aspirasi -->
            <div>
                <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Rincian Aspirasi / Saran <span class="text-rose-500">*</span>
                </label>
                <textarea id="message" name="message" rows="5" required placeholder="Tuliskan secara lengkap lokasi, kronologi, atau usulan solusi yang Anda sampaikan..." class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('message') ? 'border-rose-400' : 'border-slate-300' }} text-xs focus:ring-1 focus:ring-emerald-500 focus:outline-none">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox Privasi -->
            <div class="flex items-start space-x-2 text-xs text-slate-600">
                <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }} class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500">
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
