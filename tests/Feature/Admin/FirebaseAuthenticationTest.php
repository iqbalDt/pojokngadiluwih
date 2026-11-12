<?php

namespace Tests\Feature\Admin;

use App\Models\FirebaseAdmin;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FirebaseAuthenticationTest extends TestCase
{
    public function test_admin_dashboard_remains_accessible_after_firebase_session_reload_without_database(): void
    {
        $user = new FirebaseAdmin;
        $user->forceFill([
            'id' => 'admin@example.test',
            'name' => 'Admin',
            'email' => 'admin@example.test',
        ]);
        $user->setKeyType('string')->setIncrementing(false);

        $firebase = \Mockery::mock(FirebaseService::class);
        $firebase->shouldReceive('authenticateAdmin')
            ->once()
            ->with('admin@example.test', 'password')
            ->andReturn($user);
        $firebase->shouldReceive('findAdminById')
            ->once()
            ->with('admin@example.test')
            ->andReturn($user);
        $firebase->shouldReceive('getDashboardMetrics')
            ->once()
            ->andReturn([
                'approvedUmkmCount' => 0,
                'pendingUmkmCount' => 0,
                'aspirationCount' => 0,
                'newsCount' => 0,
                'recentUmkms' => collect(),
            ]);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->post(route('login.perform'), [
            'email' => 'admin@example.test',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        Auth::forgetGuards();

        $this->get(route('admin.dashboard'))->assertOk();
    }
}
