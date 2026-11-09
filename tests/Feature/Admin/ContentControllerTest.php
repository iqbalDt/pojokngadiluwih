<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\User;
use App\Services\FirebaseService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Build a fake News model hydrated the same way FirebaseService does it.
     *
     * @param  array<string, mixed>  $attributes
     */
    private function fakeNews(string $id, array $attributes = []): News
    {
        $defaults = [
            'title' => 'Berita Contoh',
            'slug' => 'berita-contoh',
            'category' => 'Kegiatan Desa',
            'excerpt' => 'Ringkasan berita',
            'content' => 'Isi berita lengkap di sini.',
            'status' => 'published',
            'published_at' => Carbon::parse('2026-11-01T00:00:00+00:00'),
            'created_at' => Carbon::parse('2026-11-01T00:00:00+00:00'),
        ];

        $data = array_merge($defaults, $attributes);

        $news = new News;
        $news->exists = true;
        $news->setKeyType('string')->setIncrementing(false);
        $news->id = $id;

        foreach ($data as $key => $value) {
            $news->setAttribute($key, $value);
        }

        return $news;
    }

    /**
     * Build a minimal FirebaseService stub for the news CMS.
     *
     * @param  list<News>  $items
     */
    private function fakeFirebaseWithNews(array $items = [], int $perPage = 15): FirebaseService
    {
        return new class($items, $perPage) extends FirebaseService
        {
            /** @param list<News> $items */
            public function __construct(private readonly array $items, private readonly int $perPage) {}

            public function getAdminNewsPaginated(int $perPage = 15): LengthAwarePaginator
            {
                return new LengthAwarePaginator($this->items, count($this->items), $this->perPage);
            }

            public function findNewsById(string|int $id): News
            {
                foreach ($this->items as $item) {
                    if ((string) $item->id === (string) $id) {
                        return $item;
                    }
                }

                throw new ModelNotFoundException;
            }

            public function createNews(array $data): News
            {
                $news = new News;
                $news->exists = true;
                $news->setKeyType('string')->setIncrementing(false);
                $news->id = 'new_doc_id';
                foreach ($data as $key => $value) {
                    $news->setAttribute($key, $value);
                }

                return $news;
            }

            public function updateNews(string|int $id, array $data): bool
            {
                return true;
            }

            public function deleteNews(string|int $id): bool
            {
                return true;
            }
        };
    }

    // -------------------------------------------------------------------------
    // index
    // -------------------------------------------------------------------------

    public function test_news_index_requires_authentication(): void
    {
        $this->get(route('admin.news.index'))
            ->assertRedirect(route('login'));
    }

    public function test_news_index_renders_for_authenticated_admin(): void
    {
        $item = $this->fakeNews('abc123');
        $firebase = $this->fakeFirebaseWithNews([$item]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.news.index'))
            ->assertOk()
            ->assertSee('CMS Berita')
            ->assertSee('Berita Contoh');
    }

    public function test_news_index_shows_empty_state_when_no_news(): void
    {
        $firebase = $this->fakeFirebaseWithNews([]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.news.index'))
            ->assertOk()
            ->assertSee('Belum ada berita');
    }

    // -------------------------------------------------------------------------
    // create
    // -------------------------------------------------------------------------

    public function test_news_create_page_is_accessible_to_admin(): void
    {
        $this->actingAs(User::factory()->make())
            ->get(route('admin.news.create'))
            ->assertOk()
            ->assertSee('Formulir Publikasi Berita')
            ->assertSee('name="status"', false)
            ->assertSee('name="published_at"', false);
    }

    // -------------------------------------------------------------------------
    // store
    // -------------------------------------------------------------------------

    public function test_news_store_redirects_to_index_on_success(): void
    {
        $firebase = $this->fakeFirebaseWithNews([]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.news.store'), [
                'title' => 'Berita Baru Test',
                'category' => 'Kegiatan Desa',
                'content' => 'Konten berita baru untuk pengujian.',
                'published_at' => '2026-11-08',
                'status' => 'published',
            ])
            ->assertRedirect(route('admin.news.index'))
            ->assertSessionHas('success');
    }

    public function test_news_store_passes_published_date_and_authenticated_author_to_firestore(): void
    {
        $firebase = new class extends FirebaseService
        {
            public ?array $createdData = null;

            public function createNews(array $data): News
            {
                $this->createdData = $data;

                return new News($data);
            }
        };
        $this->app->instance(FirebaseService::class, $firebase);
        $user = User::factory()->make(['id' => 42]);

        $this->actingAs($user)
            ->post(route('admin.news.store'), [
                'title' => 'Berita Uji',
                'category' => 'Kegiatan Desa',
                'content' => 'Isi berita untuk pengujian.',
                'published_at' => '2026-11-08',
                'status' => 'draft',
            ])
            ->assertRedirect(route('admin.news.index'));

        $this->assertSame(42, $firebase->createdData['author_id']);
        $this->assertSame('2026-11-08', $firebase->createdData['published_at']);
        $this->assertSame('draft', $firebase->createdData['status']);
    }

    public function test_news_store_validates_required_fields(): void
    {
        $firebase = $this->fakeFirebaseWithNews([]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.news.store'), [])
            ->assertSessionHasErrors(['title', 'category', 'content', 'status', 'published_at']);
    }

    public function test_news_store_rejects_invalid_status(): void
    {
        $firebase = $this->fakeFirebaseWithNews([]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.news.store'), [
                'title' => 'Judul',
                'category' => 'Kegiatan Desa',
                'content' => 'Konten',
                'status' => 'invalid_status',
            ])
            ->assertSessionHasErrors(['status']);
    }

    // -------------------------------------------------------------------------
    // edit
    // -------------------------------------------------------------------------

    public function test_news_edit_page_loads_data_from_firebase(): void
    {
        $item = $this->fakeNews('doc_edit_01', ['title' => 'Judul Yang Mau Diedit']);
        $firebase = $this->fakeFirebaseWithNews([$item]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.news.edit', 'doc_edit_01'))
            ->assertOk()
            ->assertSee('Judul Yang Mau Diedit')
            ->assertSee('Simpan Perubahan');
    }

    public function test_news_edit_returns_404_for_unknown_id(): void
    {
        $firebase = $this->fakeFirebaseWithNews([]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.news.edit', 'nonexistent_doc'))
            ->assertNotFound();
    }

    // -------------------------------------------------------------------------
    // update
    // -------------------------------------------------------------------------

    public function test_news_update_redirects_to_index_on_success(): void
    {
        $item = $this->fakeNews('doc_upd_01');
        $firebase = $this->fakeFirebaseWithNews([$item]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->put(route('admin.news.update', 'doc_upd_01'), [
                'title' => 'Judul Diperbarui',
                'category' => 'Pengumuman',
                'content' => 'Konten baru.',
                'published_at' => '2026-11-08',
                'status' => 'draft',
            ])
            ->assertRedirect(route('admin.news.index'))
            ->assertSessionHas('success');
    }

    public function test_news_update_validates_required_fields(): void
    {
        $item = $this->fakeNews('doc_upd_02');
        $firebase = $this->fakeFirebaseWithNews([$item]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->put(route('admin.news.update', 'doc_upd_02'), [])
            ->assertSessionHasErrors(['title', 'category', 'content', 'status', 'published_at']);
    }

    // -------------------------------------------------------------------------
    // destroy
    // -------------------------------------------------------------------------

    public function test_news_destroy_redirects_to_index_on_success(): void
    {
        $firebase = $this->fakeFirebaseWithNews([]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->delete(route('admin.news.destroy', 'doc_del_01'))
            ->assertRedirect(route('admin.news.index'))
            ->assertSessionHas('success');
    }

    public function test_news_destroy_returns_404_when_document_not_found(): void
    {
        $firebase = new class extends FirebaseService
        {
            public function deleteNews(string|int $id): bool
            {
                return false;
            }
        };
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->delete(route('admin.news.destroy', 'does_not_exist'))
            ->assertNotFound();
    }

    public function test_news_store_handles_image_upload_to_public_storage(): void
    {
        Storage::fake('public');

        $capturedData = null;
        $firebase = new class($capturedData) extends FirebaseService
        {
            public function __construct(public ?array &$ref) {}

            public function createNews(array $data): News
            {
                $this->ref = $data;

                return new News($data);
            }
        };
        $this->app->instance(FirebaseService::class, $firebase);

        $file = UploadedFile::fake()->image('berita.jpg', 600, 400);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.news.store'), [
                'title' => 'Berita Gambar',
                'category' => 'Kegiatan Desa',
                'content' => 'Isi berita dengan gambar.',
                'published_at' => '2026-11-09',
                'status' => 'published',
                'image' => $file,
            ])
            ->assertRedirect(route('admin.news.index'));

        $this->assertNotNull($capturedData['image_path']);
        Storage::disk('public')->assertExists($capturedData['image_path']);
    }

    public function test_news_update_handles_image_upload_and_replaces_old_image(): void
    {
        Storage::fake('public');
        $oldFile = 'news/old-image.jpg';
        Storage::disk('public')->put($oldFile, 'old content');

        $item = $this->fakeNews('doc_img_01', ['image_path' => $oldFile]);
        $capturedUpdate = null;
        $firebase = new class($item, $capturedUpdate) extends FirebaseService
        {
            public function __construct(private News $news, public ?array &$ref) {}

            public function findNewsById(string|int $id): News
            {
                return $this->news;
            }

            public function updateNews(string|int $id, array $data): bool
            {
                $this->ref = $data;

                return true;
            }
        };
        $this->app->instance(FirebaseService::class, $firebase);

        $newFile = UploadedFile::fake()->image('new-image.png');

        $this->actingAs(User::factory()->make())
            ->put(route('admin.news.update', 'doc_img_01'), [
                'title' => 'Judul Baru',
                'category' => 'Kegiatan Desa',
                'content' => 'Konten baru.',
                'published_at' => '2026-11-09',
                'status' => 'published',
                'image' => $newFile,
            ])
            ->assertRedirect(route('admin.news.index'));

        $this->assertNotNull($capturedUpdate['image_path']);
        Storage::disk('public')->assertMissing($oldFile);
        Storage::disk('public')->assertExists($capturedUpdate['image_path']);
    }
}
