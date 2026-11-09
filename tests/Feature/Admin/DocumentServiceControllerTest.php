<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class DocumentServiceControllerTest extends TestCase
{
    public function test_aspiration_status_rejects_missing_or_invalid_values(): void
    {
        $firebase = new FakeDocumentServiceFirebaseService;
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->from(route('admin.services.index'))
            ->post(route('admin.services.status', 'aspiration-doc-1'))
            ->assertRedirect(route('admin.services.index'))
            ->assertSessionHasErrors('status');

        $this->from(route('admin.services.index'))
            ->post(route('admin.services.status', 'aspiration-doc-1'), [
                'status' => 'invalid',
            ])
            ->assertRedirect(route('admin.services.index'))
            ->assertSessionHasErrors('status');

        $this->assertSame([], $firebase->statusUpdates);
    }

    public function test_aspiration_status_update_persists_status_and_admin_notes(): void
    {
        $firebase = new FakeDocumentServiceFirebaseService;
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.services.status', 'aspiration-doc-1'), [
                'status' => 'processed',
                'admin_notes' => 'Sedang ditindaklanjuti.',
            ])
            ->assertRedirect(route('admin.services.index'))
            ->assertSessionHas('success');

        $this->assertSame([
            'aspiration-doc-1' => [
                'status' => 'processed',
                'notes' => 'Sedang ditindaklanjuti.',
            ],
        ], $firebase->statusUpdates);
    }

    public function test_aspiration_status_update_returns_not_found_for_a_missing_document(): void
    {
        $firebase = new FakeDocumentServiceFirebaseService;
        $firebase->documentExists = false;
        $this->app->instance(FirebaseService::class, $firebase);

        $this->actingAs(User::factory()->make())
            ->post(route('admin.services.status', 'missing-aspiration'), [
                'status' => 'completed',
            ])
            ->assertNotFound();
    }
}

class FakeDocumentServiceFirebaseService extends FirebaseService
{
    /**
     * @var array<string, array{status: string, notes: ?string}>
     */
    public array $statusUpdates = [];

    public bool $documentExists = true;

    public function getAspirationsPaginated(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        return new LengthAwarePaginator([], 0, $perPage);
    }

    public function getDashboardMetrics(): array
    {
        return ['aspirationCount' => 0];
    }

    public function updateAspirationStatus(string|int $id, string $status, ?string $notes = null): bool
    {
        if (! $this->documentExists) {
            return false;
        }

        $this->statusUpdates[(string) $id] = [
            'status' => $status,
            'notes' => $notes,
        ];

        return true;
    }
}
