<?php

namespace Tests\Unit\Services;

use App\Services\FirebaseService;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\DB;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class FirebaseServiceTest extends TestCase
{
    public function test_firestore_update_publishes_umkm_even_if_local_mirror_is_unavailable(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();
        $snapshot->shouldReceive('data')->once()->andReturn(['slug' => 'madu-randu']);

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);
        $document->shouldReceive('set')
            ->once()
            ->withArgs(fn (array $data, array $options): bool => $data['status'] === 'approved' && $options === ['merge' => true]);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')->once()->with('firestore-document-id')->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('umkms')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $this->assertTrue($service->updateUmkmStatus('firestore-document-id', 'approved'));
    }

    public function test_firestore_failure_does_not_report_umkm_status_update_as_successful(): void
    {
        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')
            ->once()
            ->with('umkms')
            ->andThrow(new RuntimeException('Firestore unavailable.'));

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $this->assertFalse($service->updateUmkmStatus('firestore-document-id', 'approved'));
    }

    public function test_missing_firestore_document_does_not_fall_back_to_local_status_update(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnFalse();

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')->once()->with('firestore-document-id')->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('umkms')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $this->assertFalse($service->updateUmkmStatus('firestore-document-id', 'approved'));
    }
}
