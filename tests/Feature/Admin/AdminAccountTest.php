<?php

namespace Tests\Feature\Admin;

use App\Models\FirebaseAdmin;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class AdminAccountTest extends TestCase
{
    public function test_admin_with_temporary_password_is_redirected_to_account_page(): void
    {
        $admin = (new FirebaseAdmin)->forceFill([
            'id' => 'operator@ngadiluwih.desa.id',
            'name' => 'Operator Desa',
            'email' => 'operator@ngadiluwih.desa.id',
            'password' => Hash::make('temp123456'),
            'must_change_password' => true,
        ]);
        $admin->exists = true;

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.account.index'))
            ->assertSessionHas('warning');

        $this->actingAs($admin)
            ->get(route('admin.account.index'))
            ->assertOk()
            ->assertSee('Akun Saya');
    }

    public function test_admin_can_update_profile_name(): void
    {
        $admin = (new FirebaseAdmin)->forceFill([
            'id' => 'operator@ngadiluwih.desa.id',
            'name' => 'Operator Lama',
            'email' => 'operator@ngadiluwih.desa.id',
            'password' => Hash::make('secret1234'),
            'must_change_password' => false,
        ]);
        $admin->exists = true;

        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldReceive('updateAdminProfile')
            ->once()
            ->with('operator@ngadiluwih.desa.id', ['name' => 'Operator Baru'])
            ->andReturnTrue();
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs($admin)
            ->put(route('admin.account.profile'), [
                'name' => 'Operator Baru',
            ])
            ->assertRedirect(route('admin.account.index'))
            ->assertSessionHas('success');
    }

    public function test_admin_can_update_password_and_clear_temporary_flag(): void
    {
        $admin = (new FirebaseAdmin)->forceFill([
            'id' => 'operator@ngadiluwih.desa.id',
            'name' => 'Operator Desa',
            'email' => 'operator@ngadiluwih.desa.id',
            'password' => Hash::make('temp123456'),
            'must_change_password' => true,
        ]);
        $admin->exists = true;

        $firebase = Mockery::mock(FirebaseService::class);
        $firebase->shouldReceive('updateAdminPassword')
            ->once()
            ->withArgs(fn (string $id, string $hashed, ?bool $mustChange): bool => $id === 'operator@ngadiluwih.desa.id'
                && Hash::check('NewSecurePass123', $hashed)
                && $mustChange === false);
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs($admin)
            ->put(route('admin.account.password'), [
                'current_password' => 'temp123456',
                'password' => 'NewSecurePass123',
                'password_confirmation' => 'NewSecurePass123',
            ])
            ->assertRedirect(route('admin.account.index'))
            ->assertSessionHas('success');
    }

    public function test_admin_password_update_rejects_wrong_current_password(): void
    {
        $admin = (new FirebaseAdmin)->forceFill([
            'id' => 'operator@ngadiluwih.desa.id',
            'name' => 'Operator Desa',
            'email' => 'operator@ngadiluwih.desa.id',
            'password' => Hash::make('temp123456'),
            'must_change_password' => true,
        ]);
        $admin->exists = true;

        $this->actingAs($admin)
            ->from(route('admin.account.index'))
            ->put(route('admin.account.password'), [
                'current_password' => 'wrong-password',
                'password' => 'NewSecurePass123',
                'password_confirmation' => 'NewSecurePass123',
            ])
            ->assertRedirect(route('admin.account.index'))
            ->assertSessionHasErrors('current_password');
    }
}
