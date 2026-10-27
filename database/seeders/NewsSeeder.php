<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // User admin untuk jadi penulis
        $admin = User::firstOrCreate(
            ['email' => 'admin@ngadiluwih.desa.id'],
            [
                'name' => 'Admin Desa Ngadiluwih',
                'password' => bcrypt('password123'),
            ]
        );

        // 3 berita dummy dengan firstOrCreate agar aman dijalankan berulang kali
        for ($i = 1; $i <= 3; $i++) {
            $title = "Berita Contoh ke-$i: Kegiatan Desa Ngadiluwih";
            $slug = Str::slug($title);

            News::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'category' => 'Kegiatan',
                    'excerpt' => 'Ini adalah ringkasan pendek dari berita contoh ke-'.$i.' untuk keperluan testing backend.',
                    'content' => 'Ini adalah isi berita lengkap. Pemerintah Desa Ngadiluwih telah melaksanakan kegiatan yang sangat bermanfaat bagi warga. (Teks ini adalah data dummy).',
                    'author_id' => $admin->id,
                    'published_at' => now(),
                    'status' => 'published',
                ]
            );
        }
    }
}