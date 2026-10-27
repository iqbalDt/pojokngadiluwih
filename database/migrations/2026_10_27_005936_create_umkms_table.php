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
        Schema::create('umkms', function (Blueprint $table): void {
            $table->id();
            $table->string('name'); // Nama Toko / Usaha UMKM
            $table->string('slug')->unique(); // Slug untuk URL, misal /umkm/madu-randu-berkah
            $table->string('owner_name'); // Nama Pemilik sesuai KTP
            $table->string('nik', 16); // NIK 16 digit
            $table->string('whatsapp', 25); // Nomor kontak WhatsApp
            $table->string('category'); // Kuliner & Camilan, Pertanian & Hasil Alam, dll.
            $table->string('dusun'); // Dusun Krajan, Wonorejo, Sukorejo, Karangrejo
            $table->string('address'); // Alamat Lengkap / RT RW
            $table->unsignedInteger('price')->nullable(); // Harga produk utama / kisaran harga
            $table->string('price_unit')->nullable()->default('pcs'); // Satuan: bks, botol, porsi, pcs
            $table->text('description'); // Deskripsi produk dan usaha
            $table->string('image_path')->nullable(); // Foto produk / logo usaha
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
