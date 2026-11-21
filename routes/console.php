<?php

use App\Services\FirebaseService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
        ['ID / Document', 'Nama', 'Email', 'Wajib Ganti Sandi', 'Dibuat Pada'],
        $users->map(fn ($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'must_change' => (bool) ($u->must_change_password ?? false) ? 'Ya' : 'Tidak',
            'created_at' => (string) $u->created_at,
        ])->toArray()
    );

    return 0;
})->purpose('Menampilkan daftar akun admin yang terdaftar di Firestore');

Artisan::command('admin:create {email?} {--name=} {--password=} {--no-force-change}', function (FirebaseService $firebase) {
    $email = $this->argument('email') ?: $this->ask('Masukkan email admin');
    $name = $this->option('name') ?: $this->ask('Masukkan nama admin', 'Admin Desa Ngadiluwih');
    $password = $this->option('password') ?: $this->secret('Masukkan kata sandi sementara (kosongkan untuk generate otomatis)');

    if (! $email) {
        $this->error('Email wajib diisi.');

        return 1;
    }

    $isGenerated = false;
    if (! $password) {
        $password = Str::password(10, symbols: false);
        $isGenerated = true;
    }

    $mustChange = ! $this->option('no-force-change');

    $user = $firebase->saveAdmin([
        'email' => $email,
        'name' => $name,
        'password' => $password,
        'must_change_password' => $mustChange,
    ]);

    $this->info("✅ Akun admin berhasil disimpan: {$user->email}");
    $this->line('----------------------------------------');
    $this->line('URL Login : '.url('/login'));
    $this->line("Email     : {$user->email}");
    if ($isGenerated) {
        $this->line("Password Sementara : {$password}");
    }
    $this->line('Wajib ganti password saat login pertama: '.($mustChange ? 'Ya' : 'Tidak'));
    $this->line('----------------------------------------');

    return 0;
})->purpose('Membuat atau memperbarui akun admin di Firestore');

Artisan::command('admin:reset-password {email?} {--password=}', function (FirebaseService $firebase) {
    $email = $this->argument('email') ?: $this->ask('Masukkan email admin yang akan direset');

    if (! $email) {
        $this->error('Email wajib diisi.');

        return 1;
    }

    $tempPassword = $this->option('password') ?: Str::password(10, symbols: false);

    $admin = $firebase->resetAdminPassword($email, $tempPassword);

    if (! $admin) {
        $this->error("Akun admin dengan email '{$email}' tidak ditemukan.");

        return 1;
    }

    $this->info("✅ Kata sandi sementara berhasil dibuat untuk: {$admin->email}");
    $this->line('----------------------------------------');
    $this->line('URL Login          : '.url('/login'));
    $this->line("Email              : {$admin->email}");
    $this->line("Password Sementara : {$tempPassword}");
    $this->line('Catatan            : Admin akan diminta mengganti kata sandi setelah berhasil masuk.');
    $this->line('----------------------------------------');

    return 0;
})->purpose('Mereset kata sandi admin dan mewajibkan ganti sandi saat login berikutnya');
