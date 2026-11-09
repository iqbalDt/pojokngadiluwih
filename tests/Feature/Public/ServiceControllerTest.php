<?php

namespace Tests\Feature\Public;

use App\Models\Aspiration;
use App\Models\Umkm;
use App\Services\FirebaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    public function test_valid_umkm_registration_is_forwarded_to_firebase_as_pending(): void
    {
        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldReceive('createUmkm')
            ->once()
            ->with([
                'store_name' => 'Toko Contoh',
                'owner_name' => 'Budi Santoso',
                'nik' => '3506123456789012',
                'whatsapp' => '+628123456789',
                'category' => 'Kuliner & Camilan',
                'dusun' => 'Krajan',
                'address' => 'RT 01 RW 02, Krajan',
                'description' => 'Produk makanan olahan warga.',
                'status' => 'pending',
            ])
            ->andReturn(new Umkm);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->post(route('services.store-register.submit'), [
            'store_name' => 'Toko Contoh',
            'owner_name' => 'Budi Santoso',
            'nik' => '3506123456789012',
            'whatsapp' => '+628123456789',
            'category' => 'Kuliner & Camilan',
            'dusun' => 'Krajan',
            'address' => 'RT 01 RW 02, Krajan',
            'description' => 'Produk makanan olahan warga.',
            'status' => 'approved',
        ])
            ->assertRedirectToRoute('services.store-register')
            ->assertSessionHas('success');
    }

    public function test_umkm_registration_handles_image_upload_when_provided(): void
    {
        Storage::fake('public');

        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldReceive('createUmkm')
            ->once()
            ->with(Mockery::on(function (array $payload): bool {
                return $payload['store_name'] === 'Toko Gambar'
                    && isset($payload['image_path'])
                    && Storage::disk('public')->exists($payload['image_path'])
                    && $payload['status'] === 'pending';
            }))
            ->andReturn(new Umkm);
        $this->app->instance(FirebaseService::class, $firebase);

        $file = UploadedFile::fake()->image('produk.jpg');

        $this->post(route('services.store-register.submit'), [
            'store_name' => 'Toko Gambar',
            'owner_name' => 'Budi Santoso',
            'nik' => '3506123456789012',
            'whatsapp' => '+628123456789',
            'category' => 'Kuliner & Camilan',
            'dusun' => 'Krajan',
            'address' => 'RT 01 RW 02, Krajan',
            'description' => 'Produk makanan dengan foto.',
            'image' => $file,
        ])
            ->assertRedirectToRoute('services.store-register')
            ->assertSessionHas('success');
    }

    public function test_umkm_registration_rejects_invalid_identity_contact_and_choices(): void
    {
        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldNotReceive('createUmkm');
        $this->app->instance(FirebaseService::class, $firebase);

        $this->from(route('services.store-register'))
            ->post(route('services.store-register.submit'), [
                'store_name' => 'Toko Contoh',
                'owner_name' => 'Budi Santoso',
                'nik' => '35061234567890AB',
                'whatsapp' => '0812-34',
                'category' => 'Kategori Palsu',
                'dusun' => 'Dusun Palsu',
                'address' => 'RT 01 RW 02, Krajan',
                'description' => str_repeat('a', 10001),
            ])
            ->assertRedirectToRoute('services.store-register')
            ->assertSessionHasErrors([
                'nik' => 'NIK harus terdiri dari tepat 16 angka.',
                'whatsapp' => 'Nomor WhatsApp harus berisi 8 sampai 25 angka; tanda +, spasi, dan tanda hubung diperbolehkan.',
                'category' => 'Kategori produk yang dipilih tidak valid.',
                'dusun' => 'Dusun yang dipilih tidak valid.',
                'description' => 'Deskripsi usaha maksimal 10.000 karakter.',
            ]);
    }

    public function test_umkm_registration_requires_all_form_fields(): void
    {
        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldNotReceive('createUmkm');
        $this->app->instance(FirebaseService::class, $firebase);

        $this->from(route('services.store-register'))
            ->post(route('services.store-register.submit'))
            ->assertRedirectToRoute('services.store-register')
            ->assertSessionHasErrors([
                'store_name',
                'owner_name',
                'nik',
                'whatsapp',
                'category',
                'dusun',
                'address',
                'description',
            ]);
    }

    public function test_valid_aspiration_is_forwarded_to_firebase(): void
    {
        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldReceive('createAspiration')
            ->once()
            ->with([
                'name' => 'Warga Contoh',
                'phone' => '0812 3456-7890',
                'dusun' => 'Wonorejo',
                'category' => 'Infrastruktur & Jalan',
                'title' => 'Perbaikan jalan dusun',
                'message' => 'Mohon jalan di RT 02 segera diperbaiki.',
                'is_anonymous' => true,
            ])
            ->andReturn(new Aspiration);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->post(route('services.feedback.submit'), [
            'name' => 'Warga Contoh',
            'phone' => '0812 3456-7890',
            'dusun' => 'Wonorejo',
            'category' => 'Infrastruktur & Jalan',
            'title' => 'Perbaikan jalan dusun',
            'message' => 'Mohon jalan di RT 02 segera diperbaiki.',
            'is_anonymous' => '1',
            'status' => 'completed',
        ])
            ->assertRedirectToRoute('services.feedback')
            ->assertSessionHas('success');
    }

    public function test_aspiration_rejects_invalid_contact_and_choices_without_writing(): void
    {
        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldNotReceive('createAspiration');
        $this->app->instance(FirebaseService::class, $firebase);

        $this->from(route('services.feedback'))
            ->post(route('services.feedback.submit'), [
                'name' => 'Warga Contoh',
                'phone' => '0812-34',
                'dusun' => 'Dusun Palsu',
                'category' => 'Kategori Palsu',
                'title' => 'Laporan warga',
                'message' => str_repeat('a', 10001),
                'is_anonymous' => 'yes',
            ])
            ->assertRedirectToRoute('services.feedback')
            ->assertSessionHasErrors([
                'phone' => 'Nomor telepon/WhatsApp harus berisi 8 sampai 25 angka; tanda +, spasi, dan tanda hubung diperbolehkan.',
                'dusun' => 'Dusun yang dipilih tidak valid.',
                'category' => 'Kategori aspirasi yang dipilih tidak valid.',
                'message' => 'Rincian aspirasi maksimal 10.000 karakter.',
                'is_anonymous' => 'Pilihan kerahasiaan identitas tidak valid.',
            ]);
    }

    public function test_aspiration_requires_all_form_fields(): void
    {
        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldNotReceive('createAspiration');
        $this->app->instance(FirebaseService::class, $firebase);

        $this->from(route('services.feedback'))
            ->post(route('services.feedback.submit'))
            ->assertRedirectToRoute('services.feedback')
            ->assertSessionHasErrors([
                'name',
                'phone',
                'dusun',
                'category',
                'title',
                'message',
            ]);
    }
}
