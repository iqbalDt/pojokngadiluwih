<?php

namespace Database\Seeders;

use App\Services\FirebaseService;
use Illuminate\Database\Seeder;

class FirebaseSeeder extends Seeder
{
    /**
     * Run the database seeds for Firebase Firestore.
     */
    public function run(FirebaseService $firebase): void
    {
        $this->command->info('Memulai seeding data ke Firebase Firestore...');

        $client = $firebase->firestore();

        if (! $client) {
            $this->command->warn('Firebase Firestore belum terhubung atau file credential.json belum ada di storage/app/firebase/credential.json.');
            $this->command->info('Data akan disinkronkan ke database lokal sebagai gantinya.');

            $this->call([
                NewsSeeder::class,
                UmkmSeeder::class,
                AspirationSeeder::class,
            ]);

            return;
        }

        // 1. Seed Berita ke Firebase Firestore
        $this->command->info('1. Seeding koleksi "news"...');
        $newsItems = [
            [
                'title' => 'Pelatihan Digitalisasi & Pemasaran Online bagi UMKM Desa Ngadiluwih',
                'slug' => 'pelatihan-digitalisasi-dan-pemasaran-online-bagi-umkm-desa-ngadiluwih',
                'category' => 'Kegiatan',
                'excerpt' => 'Pemerintah Desa Ngadiluwih menggelar bimbingan teknis pemasaran digital dan foto produk untuk memajukan produk unggulan warga desa.',
                'content' => '<p>Pemerintah Desa Ngadiluwih bekerjasama dengan komunitas kreatif menyelenggarakan lokakarya digitalisasi pemasaran untuk para pelaku usaha mikro, kecil, dan menengah (UMKM). Kegiatan ini bertujuan membekali warga dengan keterampilan memanfaatkan media sosial, fotografi produk menggunakan ponsel, serta integrasi pemesanan langsung melalui WhatsApp dan platform desa.</p><p>Kepala Desa Ngadiluwih menyampaikan bahwa era digital menuntut transparansi dan akses pasar yang lebih luas bagi produsen lokal, mulai dari pengrajin bambu hingga produsen olahan pangan rumahan.</p>',
                'image_path' => null,
                'status' => 'published',
                'published_at' => now()->subDays(2)->toIso8601String(),
                'created_at' => now()->subDays(2)->toIso8601String(),
            ],
            [
                'title' => 'Jadwal Posyandu Balita dan Pemeriksaan Kesehatan Lansia Bulan Ini',
                'slug' => 'jadwal-posyandu-balita-dan-pemeriksaan-kesehatan-lansia-bulan-ini',
                'category' => 'Pengumuman',
                'excerpt' => 'Informasi lengkap jadwal pelayanan kesehatan rutin posyandu balita dan lansia di seluruh pos RW Desa Ngadiluwih.',
                'content' => '<p>Diberitahukan kepada seluruh warga Desa Ngadiluwih bahwa pelayanan rutin Posyandu Balita dan Posbindu Lansia akan dilaksanakan serentak mulai pekan depan di masing-masing balai dusun. Mohon para orang tua membawa KMS dan buku KIA.</p>',
                'image_path' => null,
                'status' => 'published',
                'published_at' => now()->subDays(5)->toIso8601String(),
                'created_at' => now()->subDays(5)->toIso8601String(),
            ],
            [
                'title' => 'Peningkatan Saluran Irigasi Pertanian di Wilayah Persawahan Ngadiluwih',
                'slug' => 'peningkatan-saluran-irigasi-pertanian-di-wilayah-persawahan-ngadiluwih',
                'category' => 'Pembangunan',
                'excerpt' => 'Realisasi proyek pemeliharaan dan pengedapan saluran irigasi guna mengoptimalkan pasokan air bagi para petani desa.',
                'content' => '<p>Pemerintah Desa bersama kelompok tani (Poktan) telah memulai pengerjaan revitalisasi saluran irigasi sekunder. Proyek ini didanai melalui alokasi dana desa guna mengantisipasi musim tanam dan memastikan ketersediaan air yang merata.</p>',
                'image_path' => null,
                'status' => 'published',
                'published_at' => now()->subDays(10)->toIso8601String(),
                'created_at' => now()->subDays(10)->toIso8601String(),
            ],
        ];

        foreach ($newsItems as $news) {
            $client->collection('news')->document($news['slug'])->set($news, ['merge' => true]);
        }

        // 2. Seed UMKM ke Firebase Firestore
        $this->command->info('2. Seeding koleksi "umkms"...');
        $umkmItems = [
            [
                'name' => 'Keripik Tempe Renyah Bu Siti',
                'slug' => 'keripik-tempe-renyah-bu-siti',
                'owner_name' => 'Siti Aminah',
                'nik' => '3506123456780001',
                'whatsapp' => '081234567890',
                'category' => 'Kuliner',
                'dusun' => 'Krajan',
                'address' => 'Jl. Mawar No. 12, RT 02 RW 01, Dusun Krajan',
                'price' => 15000,
                'price_unit' => 'bungkus',
                'description' => 'Keripik tempe kedelai murni dengan bumbu rempah tradisional pilihan, digoreng renyah tanpa bahan pengawet.',
                'status' => 'approved',
                'created_at' => now()->subDays(3)->toIso8601String(),
            ],
            [
                'name' => 'Anyaman Bambu Berkah',
                'slug' => 'anyaman-bambu-berkah',
                'owner_name' => 'Bambang Sutrisno',
                'nik' => '3506123456780002',
                'whatsapp' => '085712345678',
                'category' => 'Kerajinan',
                'dusun' => 'Ngadiluwih Timur',
                'address' => 'Gang Melati RT 01 RW 03, Dusun Ngadiluwih Timur',
                'price' => 35000,
                'price_unit' => 'buah',
                'description' => 'Keranjang hias, besek modern, dan wadah serbaguna yang dianyam secara teliti dari bambu apus kualitas unggul.',
                'status' => 'approved',
                'created_at' => now()->subDays(4)->toIso8601String(),
            ],
            [
                'name' => 'Madu Murni Sari Bunga Klanceng',
                'slug' => 'madu-murni-sari-bunga-klanceng',
                'owner_name' => 'Pak Joko Santoso',
                'nik' => '3506123456780003',
                'whatsapp' => '082198765432',
                'category' => 'Pertanian',
                'dusun' => 'Branggahan',
                'address' => 'Jl. Kebun Klanceng No. 5, Dusun Branggahan',
                'price' => 85000,
                'price_unit' => 'botol 250ml',
                'description' => 'Madu murni hasil budidaya lebah Trigona/Klanceng di kebun herbal desa. Kaya antioksidan dan baik untuk imunitas tubuh.',
                'status' => 'approved',
                'created_at' => now()->subDays(6)->toIso8601String(),
            ],
            [
                'name' => 'Batik Tulis Motif Khas Ngadiluwih',
                'slug' => 'batik-tulis-motif-khas-ngadiluwih',
                'owner_name' => 'Ibu Rahayu',
                'nik' => '3506123456780004',
                'whatsapp' => '081345678912',
                'category' => 'Fashion',
                'dusun' => 'Krajan',
                'address' => 'Jl. Dahlia No. 8, RT 04 RW 02, Dusun Krajan',
                'price' => 250000,
                'price_unit' => 'lembar kain',
                'description' => 'Kain batik tulis canting tradisional dengan pewarna alami ramah lingkungan dan motif flora kearifan lokal.',
                'status' => 'approved',
                'created_at' => now()->subDays(8)->toIso8601String(),
            ],
            [
                'name' => 'Warung Kopi & Sambal Belut Mbok Darmi',
                'slug' => 'warung-kopi-dan-sambal-belut-mbok-darmi',
                'owner_name' => 'Darmiati',
                'nik' => '3506123456780005',
                'whatsapp' => '087812345678',
                'category' => 'Kuliner',
                'dusun' => 'Ngadiluwih Barat',
                'address' => 'Pinggir Sawah RT 03 RW 02, Dusun Ngadiluwih Barat',
                'price' => 20000,
                'price_unit' => 'porsi',
                'description' => 'Kuliner pedas khas sawah desa, belut goreng gurih disajikan dengan sambal terasi segar dan lalapan mentah.',
                'status' => 'pending',
                'created_at' => now()->subHours(5)->toIso8601String(),
            ],
        ];

        foreach ($umkmItems as $umkm) {
            $client->collection('umkms')->document($umkm['slug'])->set($umkm, ['merge' => true]);
        }

        // 3. Seed Aspirasi ke Firebase Firestore
        $this->command->info('3. Seeding koleksi "aspirations"...');
        $aspirations = [
            [
                'name' => 'Hendra Setiawan',
                'phone' => '081234567891',
                'dusun' => 'Krajan',
                'category' => 'Infrastruktur',
                'title' => 'Penerangan Jalan di Sekitar Lapangan Dusun Krajan',
                'message' => 'Mohon ditambah lampu penerangan jalan di sepanjang jalan menuju lapangan dusun krajan agar tidak gelap saat malam hari.',
                'is_anonymous' => false,
                'status' => 'pending',
                'created_at' => now()->subDay()->toIso8601String(),
            ],
            [
                'name' => 'Warga Peduli Lingkungan',
                'phone' => '085798765432',
                'dusun' => 'Branggahan',
                'category' => 'Lingkungan Hidup',
                'title' => 'Usulan Pengadaan Bank Sampah Dusun',
                'message' => 'Kami dari paguyuban pemuda mengusulkan program edukasi pemilihan sampah dan pembuatan bank sampah tingkat RW.',
                'is_anonymous' => true,
                'status' => 'processed',
                'created_at' => now()->subDays(3)->toIso8601String(),
            ],
        ];

        foreach ($aspirations as $index => $asp) {
            $client->collection('aspirations')->document('aspiration_'.($index + 1))->set($asp, ['merge' => true]);
        }

        $this->command->info('✅ Berhasil menyuntikkan data contoh ke koleksi Firebase Firestore: news, umkms, dan aspirations!');
    }
}
