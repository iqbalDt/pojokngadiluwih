<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use Illuminate\Database\Seeder;

class AspirationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aspirations = [
            [
                'name' => 'Joko Prasetyo',
                'phone' => '08123444555',
                'dusun' => 'Wonorejo',
                'category' => 'Infrastruktur & Jalan',
                'title' => 'Perbaikan Lampu Penerangan Jalan Dusun Wonorejo',
                'message' => 'Lampu jalan di pertigaan RT 02 Dusun Wonorejo padam sejak seminggu lalu. Mohon bantuan penggantian bohlam agar jalan tidak gelap saat malam.',
                'is_anonymous' => false,
                'status' => 'pending',
            ],
            [
                'name' => 'Nur Hayati',
                'phone' => '08567812345',
                'dusun' => 'Krajan',
                'category' => 'Kebersihan & Lingkungan',
                'title' => 'Jadwal Pengangkutan Sampah Mingguan',
                'message' => 'Usulan agar tempat penampungan sampah sementara di dekat pasar desa dapat diangkut 2 kali seminggu supaya tidak menumpuk dan menimbulkan bau.',
                'is_anonymous' => false,
                'status' => 'processed',
                'admin_notes' => 'Telah dikoordinasikan dengan petugas kebersihan desa untuk penambahan armada pengangkut di hari Rabu dan Sabtu.',
            ],
            [
                'name' => 'Warga Anonim',
                'phone' => '081399887766',
                'dusun' => 'Sukorejo',
                'category' => 'Irigasi & Pertanian',
                'title' => 'Pembersihan Endapan Lumpur Saluran Irigasi Tersier',
                'message' => 'Saluran irigasi sawah tersier di batas Dusun Sukorejo dangkal akibat endapan lumpur pasca hujan lebat, mohon diagendakan kerja bakti desa atau pengerukan.',
                'is_anonymous' => true,
                'status' => 'completed',
                'admin_notes' => 'Pembersihan gotong royong warga telah dilaksanakan bersama kelompok tani pada hari Minggu.',
            ],
        ];

        foreach ($aspirations as $item) {
            Aspiration::firstOrCreate(
                [
                    'title' => $item['title'],
                    'phone' => $item['phone'],
                ],
                $item
            );
        }
    }
}
