<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible_when_guest(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk Portal Admin')
            ->assertDontSee('value="admin@ngadiluwih.desa.id"', false)
            ->assertDontSee('value="password"', false)
            ->assertSee('name="remember" value="1"', false);
    }

    public function test_authenticated_user_is_redirected_away_from_login_page(): void
    {
        $this->actingAs(User::factory()->make())
            ->get(route('login'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_login_and_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@ngadiluwih.desa.id',
            'password' => bcrypt('password'),
        ]);

        $this->post(route('login.perform'), [
            'email' => 'admin@ngadiluwih.desa.id',
            'password' => 'password',
            'remember' => '1',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_rejects_an_incorrect_password_without_creating_a_demo_account(): void
    {
        $this->assertDatabaseMissing('users', ['email' => 'admin@ngadiluwih.desa.id']);

        $user = User::factory()->create([
            'email' => 'petugas@example.test',
            'password' => 'correct-password',
        ]);

        $this->from(route('login'))
            ->post(route('login.perform'), [
                'email' => $user->email,
                'password' => 'incorrect-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'email' => 'Email atau kata sandi tidak sesuai.',
            ]);

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'admin@ngadiluwih.desa.id']);
    }

    public function test_admin_can_logout_and_is_redirected_to_home(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_admin_routes_redirect_guests_to_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_login_does_not_apply_a_five_attempt_rate_limit(): void
    {
        $user = User::factory()->create([
            'email' => 'petugas@example.test',
            'password' => 'correct-password',
        ]);

        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->from(route('login'))
                ->post(route('login.perform'), [
                    'email' => $user->email,
                    'password' => 'incorrect-password',
                ])
                ->assertRedirect(route('login'));
        }

        $this->assertGuest();
    }

    public function test_admin_dashboard_is_accessible_when_authenticated(): void
    {
        $this->actingAs(User::factory()->make())
            ->get(route('admin.dashboard'))
            ->assertOk();
    }
}
