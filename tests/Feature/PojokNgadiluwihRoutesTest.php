<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Umkm;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PojokNgadiluwihRoutesTest extends TestCase
{
    /**
     * Test all public routes return 200 OK.
     */
    public function test_public_routes_are_accessible(): void
    {
        $this->bindFirebaseFixtures();

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
        $this->bindFirebaseFixtures();

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

    private function bindFirebaseFixtures(): void
    {
        $news = new News([
            'title' => 'Pelatihan Digitalisasi',
            'slug' => 'pelatihan-digitalisasi',
            'category' => 'Kegiatan',
            'excerpt' => 'Ringkasan pelatihan',
            'content' => 'Konten pelatihan lengkap',
            'author_id' => 1,
            'published_at' => now(),
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $news->id = 'firestore-news-id';
        $news->exists = true;
        $news->setRelation('author', new User(['name' => 'Admin Desa']));

        $umkm = new Umkm([
            'name' => 'Madu Murni Randu',
            'slug' => 'madu-murni-randu',
            'owner_name' => 'Pak Tani',
            'nik' => '3506123456780001',
            'whatsapp' => '081234567890',
            'category' => 'Pertanian',
            'dusun' => 'Krajan',
            'address' => 'Krajan',
            'description' => 'Madu murni',
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $umkm->id = 'firestore-umkm-id';
        $umkm->exists = true;
        $umkm->created_at = now();

        $firebase = new class($news, $umkm) extends FirebaseService
        {
            public function __construct(private News $news, private Umkm $umkm) {}

            public function getHomeData(): array
            {
                return [
                    'latestNews' => collect([$this->news]),
                    'featuredUmkm' => collect([$this->umkm]),
                    'source' => 'firebase',
                ];
            }

            public function getNewsPaginated(int $perPage = 9): LengthAwarePaginator
            {
                return new LengthAwarePaginator([$this->news], 1, $perPage);
            }

            public function findNewsBySlug(string $slug): News
            {
                return $this->news;
            }

            public function getApprovedUmkmsPaginated(?string $search = null, ?string $category = null, int $perPage = 12): LengthAwarePaginator
            {
                return new LengthAwarePaginator([$this->umkm], 1, $perPage);
            }

            public function findUmkmBySlug(string $slug): Umkm
            {
                return $this->umkm;
            }

            public function getAdminNewsPaginated(int $perPage = 15): LengthAwarePaginator
            {
                return new LengthAwarePaginator([$this->news], 1, $perPage);
            }

            public function getAdminUmkmsPaginated(int $perPage = 15): LengthAwarePaginator
            {
                return new LengthAwarePaginator([$this->umkm], 1, $perPage);
            }

            public function getAspirationsPaginated(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
            {
                return new LengthAwarePaginator([], 0, $perPage);
            }

            public function getDashboardMetrics(): array
            {
                return [
                    'approvedUmkmCount' => 1,
                    'pendingUmkmCount' => 0,
                    'aspirationCount' => 0,
                    'newsCount' => 1,
                    'recentUmkms' => collect([$this->umkm]),
                ];
            }
        };

        $this->app->instance(FirebaseService::class, $firebase);
    }
}
