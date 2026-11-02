<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
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
}
