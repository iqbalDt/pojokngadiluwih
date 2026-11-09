<?php

use App\Services\FirebaseService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:list', function (FirebaseService $firebase) {
    $users = $firebase->getAdmins();

    if ($users->isEmpty()) {
        $this->warn('Belum ada akun admin terdaftar di Firestore/database.');
        $this->line('Jalankan `php artisan admin:create` atau `php artisan db:seed` untuk membuatnya.');

        return 0;
    }

    $this->info('Daftar Akun Admin Terdaftar:');
    $this->table(
        ['ID / Document', 'Nama', 'Email', 'Dibuat Pada'],
        $users->map(fn ($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'created_at' => (string) $u->created_at,
        ])->toArray()
    );

    return 0;
})->purpose('Menampilkan daftar akun admin yang terdaftar di Firestore');

Artisan::command('admin:create {email?} {--name=} {--password=}', function (FirebaseService $firebase) {
    $email = $this->argument('email') ?: $this->ask('Masukkan email admin');
    $name = $this->option('name') ?: $this->ask('Masukkan nama admin', 'Admin Desa Ngadiluwih');
    $password = $this->option('password') ?: $this->secret('Masukkan kata sandi admin');

    if (! $email || ! $password) {
        $this->error('Email dan kata sandi wajib diisi.');

        return 1;
    }

    $user = $firebase->saveAdmin([
        'email' => $email,
        'name' => $name,
        'password' => $password,
    ]);

    $this->info("✅ Akun admin berhasil disimpan ke Firestore & database: {$user->email}");

    return 0;
})->purpose('Membuat atau memperbarui akun admin di Firestore');
