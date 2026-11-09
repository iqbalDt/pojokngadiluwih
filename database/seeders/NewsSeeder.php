<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class NewsSeeder extends Seeder
{
    public function run(FirebaseService $firebase): void
    {
        $client = $firebase->firestore();
        if (! $client) {
            throw new RuntimeException('Firestore must be configured before seeding news.');
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@ngadiluwih.desa.id'],
            [
                'name' => 'Admin Desa Ngadiluwih',
                'password' => bcrypt('password123'),
            ]
        );

        for ($i = 1; $i <= 3; $i++) {
            $title = "Berita Contoh ke-$i: Kegiatan Desa Ngadiluwih";
            $slug = Str::slug($title);
            $existingDocs = $client->collection('news')
                ->where('slug', '=', $slug)
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
                $client->collection('news')->document($slug)->set([
                    'title' => $title,
                    'slug' => $slug,
                    'category' => 'Kegiatan',
                    'excerpt' => 'Ini adalah ringkasan pendek dari berita contoh ke-'.$i.' untuk keperluan testing backend.',
                    'content' => 'Ini adalah isi berita lengkap. Pemerintah Desa Ngadiluwih telah melaksanakan kegiatan yang sangat bermanfaat bagi warga. (Teks ini adalah data dummy).',
                    'image_path' => null,
                    'author_id' => $admin->id,
                    'published_at' => now()->toIso8601String(),
                    'status' => 'published',
                    'created_at' => now()->toIso8601String(),
                    'updated_at' => now()->toIso8601String(),
                ]);
            }
        }
    }
}
