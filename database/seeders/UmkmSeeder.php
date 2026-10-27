<?php

namespace Database\Seeders;

use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $umkms = [
            [
                'name' => 'Kacang Oven Gurih Bu Sumi',
                'owner_name' => 'Siti Sumarni',
                'nik' => '3506124809800001',
                'whatsapp' => '081234567890',
                'category' => 'Kuliner & Camilan',
                'dusun' => 'Wonorejo',
                'address' => 'RT 02 RW 01, Dusun Wonorejo',
                'price' => 15000,
                'price_unit' => 'bks',
                'description' => 'Kacang tanah pilihan khas Ngadiluwih yang diolah secara higienis melalui proses pemanggangan oven tanpa minyak goreng berlebih. Renyah, gurih, dan tahan lama.',
                'status' => 'approved',
            ],
            [
                'name' => 'Madu Murni Randu Ngadiluwih',
                'owner_name' => 'Ahmad Fauzi',
                'nik' => '3506121503850002',
                'whatsapp' => '081234567891',
                'category' => 'Pertanian & Hasil Alam',
                'dusun' => 'Krajan',
                'address' => 'RT 04 RW 02, Dusun Krajan',
                'price' => 75000,
                'price_unit' => 'botol',
                'description' => 'Madu asli ternak lebah nektar bunga randu dengan kemurnian 100% tanpa campuran gula atau bahan pengawet. Berkhasiat menjaga imunitas dan kesehatan tubuh.',
                'status' => 'approved',
            ],
            [
                'name' => 'Keripik Pisang Tanduk Bu Siti',
                'owner_name' => 'Siti Rohmah',
                'nik' => '3506125206920003',
                'whatsapp' => '081234567892',
                'category' => 'Kuliner & Camilan',
                'dusun' => 'Sukorejo',
                'address' => 'RT 01 RW 03, Dusun Sukorejo',
                'price' => 12000,
                'price_unit' => 'bks',
                'description' => 'Keripik pisang tanduk renyah dengan racikan bumbu khas manis gurih. Menggunakan pisang tanduk segar hasil panen kebun lokal Ngadiluwih.',
                'status' => 'approved',
            ],
            [
                'name' => 'Anyaman Bambu Berkah Lestari',
                'owner_name' => 'Bambang Sutrisno',
                'nik' => '3506121011780004',
                'whatsapp' => '081234567893',
                'category' => 'Kerajinan Tangan',
                'dusun' => 'Karangrejo',
                'address' => 'RT 03 RW 01, Dusun Karangrejo',
                'price' => 35000,
                'price_unit' => 'pcs',
                'description' => 'Produk kerajinan besek, tampah, dan wadah serbaguna yang dianyam secara tradisional menggunakan bambu apus pilihan. Kuat, rapi, dan ramah lingkungan.',
                'status' => 'approved',
            ],
            [
                'name' => 'Bengkel Las & Bubut Mandiri',
                'owner_name' => 'Supriyanto',
                'nik' => '3506120504810005',
                'whatsapp' => '081234567894',
                'category' => 'Jasa & Servis Lokal',
                'dusun' => 'Krajan',
                'address' => 'Jl. Raya Ngadiluwih No. 45',
                'price' => 50000,
                'price_unit' => 'jasa',
                'description' => 'Melayani pembuatan kanopi, pagar teralis, perbaikan alat pertanian, dan bubut logam dengan pengerjaan presisi dan harga bersahabat.',
                'status' => 'pending', // Menunggu persetujuan admin untuk testing CMS Admin
            ],
        ];

        foreach ($umkms as $item) {
            Umkm::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'owner_name' => $item['owner_name'],
                    'nik' => $item['nik'],
                    'whatsapp' => $item['whatsapp'],
                    'category' => $item['category'],
                    'dusun' => $item['dusun'],
                    'address' => $item['address'],
                    'price' => $item['price'],
                    'price_unit' => $item['price_unit'],
                    'description' => $item['description'],
                    'status' => $item['status'],
                ]
            );
        }
    }
}
