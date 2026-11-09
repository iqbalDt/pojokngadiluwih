<?php

namespace Tests\Feature\Admin;

use App\Models\Umkm;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UmkmApprovalControllerTest extends TestCase
{
    public function test_admin_umkm_page_renders_firestore_document_ids_as_strings(): void
    {
        $firebase = new class extends FirebaseService
        {
            public function getAdminUmkmsPaginated(int $perPage = 15): LengthAwarePaginator
            {
                return new LengthAwarePaginator(
                    [
                        $this->hydrateUmkm('3e23ace109ba4d699091', [
                            'name' => 'Toko Contoh',
                            'slug' => 'toko-contoh',
                            'owner_name' => 'Pemilik',
                            'nik' => '1234567890123456',
                            'whatsapp' => '08123456789',
                            'category' => 'Kuliner',
                            'dusun' => 'Krajan',
                            'address' => 'Krajan',
                            'description' => 'Produk contoh',
                            'status' => 'pending',
                            'created_at' => '2026-11-02T00:00:00+00:00',
                        ]),
                    ],
                    1,
                    $perPage
                );
            }

            public function getDashboardMetrics(): array
            {
                return ['pendingUmkmCount' => 1];
            }
        };
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.umkm.index'))
            ->assertOk()
            ->assertSee('/admin/umkm/3e23ace109ba4d699091/approve', false);
    }

    public function test_admin_umkm_page_shows_pending_applications_only(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'pending-doc' => [
                'name' => 'Toko Menunggu',
                'owner_name' => 'Pemilik',
                'nik' => '1234567890123456',
                'whatsapp' => '08123456789',
                'category' => 'Kuliner',
                'dusun' => 'Krajan',
                'status' => 'pending',
                'created_at' => '2026-11-02T00:00:00+00:00',
            ],
            'approved-doc' => [
                'name' => 'Toko Disetujui',
                'owner_name' => 'Pemilik Lain',
                'status' => 'approved',
            ],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.umkm.index'))
            ->assertOk()
            ->assertSee('Toko Menunggu')
            ->assertDontSee('Toko Disetujui')
            ->assertSee('Setujui');
    }

    public function test_admin_can_approve_a_pending_umkm_application(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'pending-doc' => ['name' => 'Toko Menunggu', 'status' => 'pending'],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.umkm.approve', 'pending-doc'))
            ->assertRedirect(route('admin.umkm.index'))
            ->assertSessionHas('success');

        $this->assertSame('approved', $firebase->documents['pending-doc']['status']);
    }

    public function test_admin_can_reject_a_pending_umkm_application(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'pending-doc' => ['name' => 'Toko Menunggu', 'status' => 'pending'],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.umkm.reject', 'pending-doc'))
            ->assertRedirect(route('admin.umkm.index'))
            ->assertSessionHas('success');

        $this->assertSame('rejected', $firebase->documents['pending-doc']['status']);
    }

    public function test_approval_returns_not_found_for_a_missing_or_already_reviewed_application(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'approved-doc' => ['name' => 'Toko Disetujui', 'status' => 'approved'],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.umkm.approve', 'missing-doc'))
            ->assertNotFound();

        $this->post(route('admin.umkm.reject', 'approved-doc'))
            ->assertNotFound();

        $this->assertSame('approved', $firebase->documents['approved-doc']['status']);
    }

    public function test_admin_can_view_approved_umkm_list(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'pending-doc' => ['name' => 'Toko Menunggu', 'status' => 'pending'],
            'approved-doc' => [
                'name' => 'Toko Tatakan',
                'owner_name' => 'Pemilik',
                'whatsapp' => '08123456789',
                'category' => 'Kerajinan Tangan',
                'dusun' => 'Karangrejo',
                'status' => 'approved',
                'price' => 15000,
                'price_unit' => 'pcs',
            ],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.umkm.index', ['status' => 'approved']))
            ->assertOk()
            ->assertSee('Toko Tatakan')
            ->assertDontSee('Toko Menunggu')
            ->assertSee('Rp 15.000');
    }

    public function test_admin_can_view_edit_umkm_page(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'doc-1' => [
                'name' => 'Toko Tatakan',
                'owner_name' => 'Pemilik Toko',
                'whatsapp' => '08123456789',
                'category' => 'Kerajinan Tangan',
                'dusun' => 'Karangrejo',
                'address' => 'RT 01 RW 01',
                'price' => 25000,
                'price_unit' => 'pcs',
                'description' => 'Deskripsi kerajinan tatakan',
                'status' => 'approved',
            ],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.umkm.edit', 'doc-1'))
            ->assertOk()
            ->assertSee('Perbarui Profil & Katalog UMKM')
            ->assertSee('value="Toko Tatakan"', false);
    }

    public function test_admin_can_update_umkm_details_and_price(): void
    {
        Storage::fake('public');
        $firebase = new FakeUmkmApprovalFirebaseService([
            'doc-1' => [
                'name' => 'Toko Lama',
                'owner_name' => 'Pemilik Lama',
                'whatsapp' => '08123456789',
                'category' => 'Kerajinan Tangan',
                'dusun' => 'Karangrejo',
                'address' => 'RT 01 RW 01',
                'price' => 10000,
                'price_unit' => 'pcs',
                'description' => 'Deskripsi lama',
                'status' => 'approved',
            ],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $file = UploadedFile::fake()->image('produk-baru.jpg');

        $this->actingAs(User::factory()->make())
            ->put(route('admin.umkm.update', 'doc-1'), [
                'name' => 'Toko Diperbarui',
                'owner_name' => 'Pemilik Baru',
                'whatsapp' => '08987654321',
                'category' => 'Kerajinan Tangan',
                'dusun' => 'Karangrejo',
                'address' => 'RT 02 RW 02',
                'price' => 35000,
                'price_unit' => 'buah',
                'description' => 'Deskripsi baru yang lebih lengkap.',
                'status' => 'approved',
                'image' => $file,
            ])
            ->assertRedirect(route('admin.umkm.index', ['status' => 'approved']))
            ->assertSessionHas('success');

        $this->assertSame('Toko Diperbarui', $firebase->documents['doc-1']['name']);
        $this->assertSame(35000, $firebase->documents['doc-1']['price']);
        $this->assertSame('buah', $firebase->documents['doc-1']['price_unit']);
        $this->assertNotNull($firebase->documents['doc-1']['image_path']);
        Storage::disk('public')->assertExists($firebase->documents['doc-1']['image_path']);
    }

    public function test_admin_can_delete_umkm(): void
    {
        $firebase = new FakeUmkmApprovalFirebaseService([
            'doc-1' => ['name' => 'Toko Untuk Dihapus', 'status' => 'approved'],
        ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->delete(route('admin.umkm.destroy', 'doc-1'))
            ->assertRedirect(route('admin.umkm.index'))
            ->assertSessionHas('success');

        $this->assertArrayNotHasKey('doc-1', $firebase->documents);
    }
}

class FakeUmkmApprovalFirebaseService extends FirebaseService
{
    /**
     * @param  array<string, array<string, mixed>>  $documents
     */
    public function __construct(public array $documents = []) {}

    public function getAdminUmkmsPaginated(int $perPage = 15, ?string $status = 'pending'): LengthAwarePaginator
    {
        $items = [];
        foreach ($this->documents as $id => $data) {
            $docStatus = $data['status'] ?? null;
            if (! $status || $status === 'all' || $docStatus === $status) {
                $items[] = $this->hydrateUmkm($id, $data);
            }
        }

        return new LengthAwarePaginator($items, count($items), $perPage);
    }

    public function findUmkmById(string|int $id): Umkm
    {
        $key = (string) $id;
        if (! isset($this->documents[$key])) {
            throw (new ModelNotFoundException)->setModel(Umkm::class, [$id]);
        }

        return $this->hydrateUmkm($key, $this->documents[$key]);
    }

    public function getDashboardMetrics(): array
    {
        $pending = count(array_filter(
            $this->documents,
            fn (array $data): bool => ($data['status'] ?? null) === 'pending'
        ));
        $approved = count(array_filter(
            $this->documents,
            fn (array $data): bool => ($data['status'] ?? null) === 'approved'
        ));

        return [
            'pendingUmkmCount' => $pending,
            'approvedUmkmCount' => $approved,
        ];
    }

    public function updateUmkmStatus(string|int $id, string $status): bool
    {
        $key = (string) $id;
        if (! isset($this->documents[$key]) || ($this->documents[$key]['status'] ?? null) !== 'pending') {
            return false;
        }

        $this->documents[$key]['status'] = $status;

        return true;
    }

    public function updateUmkm(string|int $id, array $data): bool
    {
        $key = (string) $id;
        if (! isset($this->documents[$key])) {
            return false;
        }

        $this->documents[$key] = array_merge($this->documents[$key], $data);

        return true;
    }

    public function deleteUmkm(string|int $id): bool
    {
        $key = (string) $id;
        if (! isset($this->documents[$key])) {
            return false;
        }

        unset($this->documents[$key]);

        return true;
    }
}
