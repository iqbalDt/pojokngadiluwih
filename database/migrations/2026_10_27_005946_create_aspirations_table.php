<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aspirations', function (Blueprint $table): void {
            $table->id();
            $table->string('name'); // Nama Lengkap Warga
            $table->string('phone', 25); // Nomor Kontak / WhatsApp
            $table->string('dusun'); // Dusun Domisili
            $table->string('category'); // Infrastruktur & Jalan, Irigasi, dll.
            $table->string('title'); // Judul Aspirasi / Laporan
            $table->text('message'); // Rincian Aspirasi / Saran
            $table->boolean('is_anonymous')->default(false); // Rahasiakan identitas
            $table->enum('status', ['pending', 'processed', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable(); // Catatan penanganan oleh aparatur desa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirations');
    }
};
