<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan akun admin utama tersedia
        User::firstOrCreate(
            ['email' => 'admin@ngadiluwih.desa.id'],
            [
                'name' => 'Admin Desa Ngadiluwih',
                'password' => bcrypt('password123'),
            ]
        );

        // Jalankan seeder konten desa
        $this->call([
            NewsSeeder::class,
            UmkmSeeder::class,
            AspirationSeeder::class,
        ]);
    }
}
