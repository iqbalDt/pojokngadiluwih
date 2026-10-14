<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PojokNgadiluwihRoutesTest extends TestCase
{
    /**
     * Test all public routes return 200 OK.
     */
    public function test_public_routes_are_accessible(): void
    {
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
