@extends('layouts.app')

@section('title', 'Profil & Struktur Desa')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Mengenal Lebih Dekat</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Profil & Struktur Pemerintahan Desa Ngadiluwih</h1>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Informasi lengkap sejarah, visi misi pembangunan, letak geografis, serta jajaran aparatur Pemerintah Desa Ngadiluwih, Kecamatan Ngadiluwih, Kabupaten Kediri.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Visi & Misi Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg mb-4">
                🎯
            </div>
            <h2 class="text-xl font-bold text-slate-900 mb-3">Visi Desa Ngadiluwih</h2>
            <blockquote class="italic text-slate-700 border-l-4 border-emerald-500 pl-4 py-2 bg-emerald-50/50 rounded-r-xl text-sm leading-relaxed">
                "Terwujudnya Desa Ngadiluwih yang Mandiri, Sejahtera, Berkarakter, dan Berbasis Digitalisasi Layanan Masyarakat Menuju Masyarakat yang Adil dan Makmur."
            </blockquote>
        </div>

        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-lg mb-4">
                🚀
            </div>
            <h2 class="text-xl font-bold text-slate-900 mb-3">Misi Pembangunan</h2>
            <ul class="space-y-2.5 text-xs text-slate-600 leading-relaxed list-disc list-inside">
                <li>Meningkatkan kualitas tata kelola pemerintahan desa yang transparan, akuntabel, dan berbasis teknologi digital.</li>
                <li>Mengembangkan potensi perekonomian warga melalui pemberdayaan UMKM lokal dan sektor pertanian produktif.</li>
                <li>Meningkatkan kualitas sarana prasarana infrastruktur umum, irigasi, dan fasilitas sosial desa.</li>
                <li>Mewujudkan masyarakat yang religius, guyub rukun, dan berdaya saing tinggi.</li>
            </ul>
        </div>
    </section>

    <!-- Struktur Organisasi Section -->
    <section class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Aparatur Desa</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">Struktur Organisasi Pemerintah Desa Ngadiluwih</h2>
            <p class="text-xs text-slate-500 mt-2">Jajaran pamong desa yang berdedikasi melayani seluruh kebutuhan masyarakat desa.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Kepala Desa -->
            <div class="border border-emerald-200 bg-emerald-50/30 rounded-2xl p-5 text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-emerald-600 text-white flex items-center justify-center text-2xl font-bold mb-3 shadow-md">
                    KD
                </div>
                <h3 class="font-bold text-slate-900 text-sm">H. Bambang Sutrisno, S.E.</h3>
                <span class="text-xs font-semibold text-emerald-700 mt-0.5">Kepala Desa</span>
                <p class="text-[11px] text-slate-500 mt-2">Penanggung jawab utama jalannya pemerintahan dan pembangunan desa.</p>
            </div>

            <!-- Sekretaris Desa -->
            <div class="border border-slate-200 rounded-2xl p-5 text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-2xl font-bold mb-3">
                    SD
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Ahmad Fauzi, S.AP.</h3>
                <span class="text-xs font-semibold text-slate-600 mt-0.5">Sekretaris Desa</span>
                <p class="text-[11px] text-slate-500 mt-2">Koordinator urusan administrasi, kepegawaian, dan penyusunan regulasi.</p>
            </div>

            <!-- Kasi Pemerintahan -->
            <div class="border border-slate-200 rounded-2xl p-5 text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-2xl font-bold mb-3">
                    KP
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Wahyu Hidayat, S.H.</h3>
                <span class="text-xs font-semibold text-slate-600 mt-0.5">Kasi Pemerintahan</span>
                <p class="text-[11px] text-slate-500 mt-2">Pengelolaan administrasi kependudukan dan pertanahan desa.</p>
            </div>

            <!-- Kasi Kesejahteraan -->
            <div class="border border-slate-200 rounded-2xl p-5 text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-2xl font-bold mb-3">
                    KK
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Siti Masruroh, S.Sos.</h3>
                <span class="text-xs font-semibold text-slate-600 mt-0.5">Kasi Kesejahteraan</span>
                <p class="text-[11px] text-slate-500 mt-2">Pelaksanaan pembangunan, pemberdayaan masyarakat, dan bantuan sosial.</p>
            </div>
        </div>
    </section>

    <!-- Geografis & Wilayah Section -->
    <section class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h2 class="text-xl font-bold text-slate-900 mb-3">Kondisi Geografis</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Desa Ngadiluwih terletak di bagian selatan Kabupaten Kediri, dilalui jalur utama penghubung Kediri - Tulungagung. Memiliki luas wilayah sekitar 340 hektar dengan topografi dataran rendah subur yang sangat potensial untuk pertanian dan sentra perdagangan mikro.
            </p>
        </div>
        <div>
            <h3 class="font-bold text-sm text-slate-900 mb-2">Batas Wilayah</h3>
            <ul class="space-y-1.5 text-xs text-slate-600">
                <li><strong class="text-slate-800">Utara:</strong> Desa Rembang & Desa Banjarejo</li>
                <li><strong class="text-slate-800">Timur:</strong> Desa Slumbung</li>
                <li><strong class="text-slate-800">Selatan:</strong> Desa Dukuh & Sungai Brantas</li>
                <li><strong class="text-slate-800">Barat:</strong> Kecamatan Mojo</li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold text-sm text-slate-900 mb-2">Pembagian Dusun</h3>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="font-semibold text-slate-800 block">Dusun Krajan</span>
                    <span class="text-slate-500 text-[11px]">Pusat balai desa</span>
                </div>
                <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="font-semibold text-slate-800 block">Dusun Wonorejo</span>
                    <span class="text-slate-500 text-[11px]">Sentra UMKM kuliner</span>
                </div>
                <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="font-semibold text-slate-800 block">Dusun Sukorejo</span>
                    <span class="text-slate-500 text-[11px]">Kawasan pertanian</span>
                </div>
                <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="font-semibold text-slate-800 block">Dusun Karangrejo</span>
                    <span class="text-slate-500 text-[11px]">Pengrajin lokal</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
