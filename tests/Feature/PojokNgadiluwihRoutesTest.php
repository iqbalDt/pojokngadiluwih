<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Umkm;
use App\Models\User;
use Tests\TestCase;

class PojokNgadiluwihRoutesTest extends TestCase
{
    /**
     * Test all public routes return 200 OK.
     */
    public function test_public_routes_are_accessible(): void
    {
        // Pastikan record sampel ada agar URL detail tidak 404
        $admin = User::firstOrCreate(
            ['email' => 'admin@ngadiluwih.desa.id'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        News::firstOrCreate(
            ['slug' => 'pelatihan-digitalisasi'],
            [
                'title' => 'Pelatihan Digitalisasi',
                'category' => 'Kegiatan',
                'excerpt' => 'Ringkasan pelatihan',
                'content' => 'Konten pelatihan lengkap',
                'author_id' => $admin->id,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        Umkm::firstOrCreate(
            ['slug' => 'madu-murni-randu'],
            [
                'name' => 'Madu Murni Randu',
                'owner_name' => 'Pak Tani',
                'nik' => '3506123456780001',
                'whatsapp' => '081234567890',
                'category' => 'Pertanian',
                'dusun' => 'Krajan',
                'address' => 'Krajan',
                'description' => 'Madu murni',
                'status' => 'approved',
            ]
        );

        $routes = [
            '/',
            '/profil',
            '/berita',
            '/berita/pelatihan-digitalisasi',
            '/umkm',
            '/umkm/madu-murni-randu',
            '/layanan/panduan',
            '/layanan/daftar-toko',
            '/layanan/aspirasi',
            '/demografi',
            '/firebase/ping',
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    /**
     * Test public chatbot API endpoint.
     */
    public function test_chatbot_api_responds_with_json(): void
    {
        $response = $this->postJson('/api/chatbot/message', [
            'message' => 'Halo apa syarat membuat surat SKU?',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'reply']);
    }

    /**
     * Test unauthenticated access to admin routes redirects to login.
     */
    public function test_unauthenticated_user_redirected_from_admin(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated admin can access admin dashboard and subpages.
     */
    public function test_authenticated_admin_can_access_admin_portal(): void
    {
        $user = User::factory()->make();

        $adminUrls = [
            '/admin/dashboard',
            '/admin/berita',
            '/admin/berita/buat',
            '/admin/umkm',
            '/admin/layanan',
            '/admin/insights',
            '/admin/ai-knowledge',
        ];

        foreach ($adminUrls as $url) {
            $response = $this->actingAs($user)->get($url);
            $response->assertStatus(200);
        }
    }
}
