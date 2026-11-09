<?php

namespace Tests\Unit\Services;

use App\Services\FirebaseService;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Hash;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class FirebaseServiceTest extends TestCase
{
    public function test_firestore_status_update_does_not_write_to_local_database(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();
        $snapshot->shouldReceive('data')->once()->andReturn(['status' => 'pending']);

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

    public function test_firestore_failure_is_not_reported_as_a_successful_umkm_update(): void
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

        $this->expectException(RuntimeException::class);

        $service->updateUmkmStatus('firestore-document-id', 'approved');
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

    public function test_non_pending_umkm_cannot_be_reviewed_again(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();
        $snapshot->shouldReceive('data')->once()->andReturn(['status' => 'approved']);

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);
        $document->shouldNotReceive('set');

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')->once()->with('reviewed-doc')->andReturn($document);

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

        $this->assertFalse($service->updateUmkmStatus('reviewed-doc', 'rejected'));
    }

    public function test_admin_umkm_query_selects_only_pending_firestore_documents(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();
        $snapshot->shouldReceive('id')->once()->andReturn('pending-doc');
        $snapshot->shouldReceive('data')->once()->andReturn([
            'name' => 'Toko Menunggu',
            'status' => 'pending',
        ]);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('where')
            ->once()
            ->with('status', '=', 'pending')
            ->andReturnSelf();
        $collection->shouldReceive('documents')
            ->once()
            ->andReturn(new \ArrayIterator([$snapshot]));

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

        $result = $service->getAdminUmkmsPaginated();

        $this->assertCount(1, $result->items());
        $this->assertSame('pending-doc', $result->items()[0]->id);
        $this->assertSame('pending', $result->items()[0]->status);
    }

    public function test_dashboard_metrics_count_firestore_documents_by_status(): void
    {
        $approvedUmkm = Mockery::mock(DocumentSnapshot::class);
        $approvedUmkm->shouldReceive('exists')->once()->andReturnTrue();
        $approvedUmkm->shouldReceive('id')->once()->andReturn('approved-doc');
        $approvedUmkm->shouldReceive('data')->once()->andReturn([
            'name' => 'Toko Disetujui',
            'status' => 'approved',
            'created_at' => '2026-11-07T00:00:00+00:00',
        ]);

        $pendingUmkm = Mockery::mock(DocumentSnapshot::class);
        $pendingUmkm->shouldReceive('exists')->once()->andReturnTrue();
        $pendingUmkm->shouldReceive('id')->once()->andReturn('pending-doc');
        $pendingUmkm->shouldReceive('data')->once()->andReturn([
            'name' => 'Toko Menunggu',
            'status' => 'pending',
            'created_at' => '2026-11-06T00:00:00+00:00',
        ]);

        $rejectedUmkm = Mockery::mock(DocumentSnapshot::class);
        $rejectedUmkm->shouldReceive('exists')->once()->andReturnTrue();
        $rejectedUmkm->shouldReceive('id')->once()->andReturn('rejected-doc');
        $rejectedUmkm->shouldReceive('data')->once()->andReturn([
            'name' => 'Toko Ditolak',
            'status' => 'rejected',
        ]);

        $aspirationOne = Mockery::mock(DocumentSnapshot::class);
        $aspirationOne->shouldReceive('exists')->once()->andReturnTrue();
        $aspirationTwo = Mockery::mock(DocumentSnapshot::class);
        $aspirationTwo->shouldReceive('exists')->once()->andReturnTrue();

        $newsOne = Mockery::mock(DocumentSnapshot::class);
        $newsOne->shouldReceive('exists')->once()->andReturnTrue();
        $newsTwo = Mockery::mock(DocumentSnapshot::class);
        $newsTwo->shouldReceive('exists')->once()->andReturnTrue();
        $newsThree = Mockery::mock(DocumentSnapshot::class);
        $newsThree->shouldReceive('exists')->once()->andReturnTrue();

        $umkmCollection = Mockery::mock(CollectionReference::class);
        $umkmCollection->shouldReceive('documents')
            ->once()
            ->andReturn(new \ArrayIterator([$approvedUmkm, $pendingUmkm, $rejectedUmkm]));
        $aspirationCollection = Mockery::mock(CollectionReference::class);
        $aspirationCollection->shouldReceive('documents')
            ->once()
            ->andReturn(new \ArrayIterator([$aspirationOne, $aspirationTwo]));
        $newsCollection = Mockery::mock(CollectionReference::class);
        $newsCollection->shouldReceive('documents')
            ->once()
            ->andReturn(new \ArrayIterator([$newsOne, $newsTwo, $newsThree]));

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('umkms')->andReturn($umkmCollection);
        $firestore->shouldReceive('collection')->once()->with('aspirations')->andReturn($aspirationCollection);
        $firestore->shouldReceive('collection')->once()->with('news')->andReturn($newsCollection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $metrics = $service->getDashboardMetrics();

        $this->assertSame(1, $metrics['approvedUmkmCount']);
        $this->assertSame(1, $metrics['pendingUmkmCount']);
        $this->assertSame(2, $metrics['aspirationCount']);
        $this->assertSame(3, $metrics['newsCount']);
    }

    public function test_news_read_fails_when_firestore_is_not_configured(): void
    {
        $service = new class extends FirebaseService
        {
            public function firestore(): ?FirestoreClient
            {
                return null;
            }
        };

        $this->expectException(RuntimeException::class);

        $service->getNewsPaginated();
    }

    public function test_news_update_refreshes_slug_when_title_changes(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);
        $document->shouldReceive('set')
            ->once()
            ->withArgs(fn (array $data, array $options): bool => $data['title'] === 'Judul Berita Baru'
                && $data['slug'] === 'judul-berita-baru'
                && $options === ['merge' => true]);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')->once()->with('news-doc-1')->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('news')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $this->assertTrue($service->updateNews('news-doc-1', [
            'title' => 'Judul Berita Baru',
        ]));
    }

    public function test_aspiration_write_does_not_succeed_when_firestore_write_fails(): void
    {
        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')
            ->once()
            ->with('aspirations')
            ->andThrow(new RuntimeException('Firestore unavailable.'));

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $this->expectException(RuntimeException::class);

        $service->createAspiration([
            'name' => 'Warga',
            'phone' => '08123456789',
            'dusun' => 'Krajan',
            'category' => 'Infrastruktur',
            'title' => 'Jalan rusak',
            'message' => 'Mohon diperbaiki.',
        ]);
    }

    public function test_valid_aspiration_is_saved_to_firestore_with_pending_status(): void
    {
        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('id')->once()->andReturn('aspiration-document-id');

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('add')
            ->once()
            ->with(Mockery::on(fn (array $payload): bool => $payload['name'] === 'Warga'
                && $payload['status'] === 'pending'
                && $payload['is_anonymous'] === true))
            ->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('aspirations')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $aspiration = $service->createAspiration([
            'name' => 'Warga',
            'phone' => '08123456789',
            'dusun' => 'Krajan',
            'category' => 'Infrastruktur',
            'title' => 'Perbaikan jalan',
            'message' => 'Mohon diperbaiki.',
            'is_anonymous' => true,
        ]);

        $this->assertSame('aspiration-document-id', $aspiration->id);
        $this->assertSame('pending', $aspiration->status);
    }

    public function test_authenticate_admin_succeeds_when_firestore_admin_credentials_match(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();
        $snapshot->shouldReceive('id')->once()->andReturn('admin@ngadiluwih.desa.id');
        $snapshot->shouldReceive('data')->once()->andReturn([
            'name' => 'Admin Desa Ngadiluwih',
            'email' => 'admin@ngadiluwih.desa.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')
            ->once()
            ->with('admin@ngadiluwih.desa.id')
            ->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('admins')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $admin = $service->authenticateAdmin('admin@ngadiluwih.desa.id', 'password123');

        $this->assertNotNull($admin);
        $this->assertSame('admin@ngadiluwih.desa.id', $admin->email);
        $this->assertSame('Admin Desa Ngadiluwih', $admin->name);
    }

    public function test_authenticate_admin_fails_when_password_does_not_match(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnTrue();
        $snapshot->shouldReceive('id')->once()->andReturn('admin@ngadiluwih.desa.id');
        $snapshot->shouldReceive('data')->once()->andReturn([
            'name' => 'Admin Desa Ngadiluwih',
            'email' => 'admin@ngadiluwih.desa.id',
            'password' => Hash::make('password123'),
        ]);

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')
            ->once()
            ->with('admin@ngadiluwih.desa.id')
            ->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('admins')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $admin = $service->authenticateAdmin('admin@ngadiluwih.desa.id', 'wrong-password');

        $this->assertNull($admin);
    }

    public function test_save_admin_writes_to_firestore_admins_collection(): void
    {
        $snapshot = Mockery::mock(DocumentSnapshot::class);
        $snapshot->shouldReceive('exists')->once()->andReturnFalse();

        $document = Mockery::mock(DocumentReference::class);
        $document->shouldReceive('snapshot')->once()->andReturn($snapshot);
        $document->shouldReceive('set')
            ->once()
            ->with(Mockery::on(function (array $payload): bool {
                return $payload['email'] === 'petugas@ngadiluwih.desa.id'
                    && $payload['name'] === 'Petugas Layanan'
                    && Hash::check('secret123', $payload['password'])
                    && $payload['role'] === 'admin';
            }), ['merge' => true]);

        $collection = Mockery::mock(CollectionReference::class);
        $collection->shouldReceive('document')
            ->once()
            ->with('petugas@ngadiluwih.desa.id')
            ->andReturn($document);

        $firestore = Mockery::mock(FirestoreClient::class);
        $firestore->shouldReceive('collection')->once()->with('admins')->andReturn($collection);

        $service = new class($firestore) extends FirebaseService
        {
            public function __construct(private FirestoreClient $client) {}

            public function firestore(): ?FirestoreClient
            {
                return $this->client;
            }
        };

        $admin = $service->saveAdmin([
            'name' => 'Petugas Layanan',
            'email' => 'petugas@ngadiluwih.desa.id',
            'password' => 'secret123',
        ]);

        $this->assertSame('petugas@ngadiluwih.desa.id', $admin->email);
        $this->assertSame('Petugas Layanan', $admin->name);
    }
}
