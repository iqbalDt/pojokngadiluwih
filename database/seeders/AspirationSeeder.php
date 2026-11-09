<?php

namespace Database\Seeders;

use App\Services\FirebaseService;
use Illuminate\Database\Seeder;
use RuntimeException;

class AspirationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(FirebaseService $firebase): void
    {
        $client = $firebase->firestore();
        if (! $client) {
            throw new RuntimeException('Firestore must be configured before seeding aspirations.');
        }

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
            $existingDocs = $client->collection('aspirations')
                ->where('title', '=', $item['title'])
                ->where('phone', '=', $item['phone'])
                ->limit(1)
                ->documents();

            $exists = false;
            foreach ($existingDocs as $doc) {
                if ($doc->exists()) {
                    $exists = true;
                    break;
                }
            }

            if (! $exists) {
                $client->collection('aspirations')->add([
                    ...$item,
                    'created_at' => now()->toIso8601String(),
                    'updated_at' => now()->toIso8601String(),
                ]);
            }
        }
    }
}
