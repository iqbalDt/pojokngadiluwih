<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    public function test_dashboard_displays_firestore_metrics(): void
    {
        $this->app->instance(FirebaseService::class, new FakeDashboardFirebaseService);

        $this->actingAs(User::factory()->make())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Toko aktif di katalog')
            ->assertSee('>4</p>', false)
            ->assertSee('>3</p>', false)
            ->assertSee('>12</p>', false)
            ->assertSee('Total berita di CMS')
            ->assertSee('>7</p>', false);
    }
}

class FakeDashboardFirebaseService extends FirebaseService
{
    public function getDashboardMetrics(): array
    {
        return [
            'approvedUmkmCount' => 4,
            'pendingUmkmCount' => 3,
            'aspirationCount' => 12,
            'newsCount' => 7,
            'recentUmkms' => new Collection,
        ];
    }
}
