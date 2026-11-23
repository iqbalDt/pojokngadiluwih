<?php

namespace App\Services;

use App\Models\Aspiration;
use App\Models\FirebaseAdmin;
use App\Models\News;
use App\Models\Umkm;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Storage;
use RuntimeException;
use Throwable;

class FirebaseService
{
    protected ?FirestoreClient $firestoreClient = null;

    protected bool $testedConnection = false;

    protected bool $isConnected = false;

    protected const CACHE_TTL_SECONDS = 300;

    /**
     * Build a versioned cache key for Firestore read operations.
     */
    protected function cacheKey(string $key): string
    {
        $version = (int) Cache::get('firebase_cache_version', 1);

        return "firebase_v{$version}_{$key}";
    }

    /**
     * Cache Firestore read operations while keeping unit tests isolated.
     */
    protected function rememberFirestore(string $key, Closure $callback): mixed
    {
        if (app()->runningUnitTests()) {
            return $callback();
        }

        return Cache::remember($this->cacheKey($key), self::CACHE_TTL_SECONDS, $callback);
    }

    /**
     * Immediately invalidate all cached Firestore responses after any write operation.
     */
    public function flushCache(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        $version = (int) Cache::get('firebase_cache_version', 1);
        Cache::forever('firebase_cache_version', $version + 1);
    }

    /**
     * Check if Firebase credentials are configured in the environment.
     */
    public function isConfigured(): bool
    {
        $credentials = config('firebase.projects.app.credentials');

        if (! $credentials) {
            return false;
        }

        if (is_string($credentials) && str_starts_with(trim($credentials), '{')) {
            return true;
        }

        $path = is_string($credentials) ? base_path($credentials) : null;

        if ($path === null || ! file_exists($path)) {
            return false;
        }

        if (is_readable($path)) {
            return true;
        }

        $handle = @fopen($path, 'r');
        if ($handle !== false) {
            fclose($handle);

            return true;
        }

        return false;
    }

    /**
     * Get the resolved credentials file path (if relative or set).
     */
    public function getCredentialsPath(): ?string
    {
        $credentials = config('firebase.projects.app.credentials');

        if (! $credentials || ! is_string($credentials)) {
            return null;
        }

        if (str_starts_with(trim($credentials), '{')) {
            return 'JSON String in .env';
        }

        return base_path($credentials);
    }

    /**
     * Get or initialize Firestore client instance.
     */
    public function firestore(): ?FirestoreClient
    {
        if ($this->firestoreClient !== null) {
            return $this->firestoreClient;
        }

        if (! $this->isConfigured()) {
            return null;
        }

        try {
            /** @var Firestore $firebaseFirestore */
            $firebaseFirestore = app('firebase.firestore');
            $this->firestoreClient = $firebaseFirestore->database();
            $this->isConnected = true;

            return $this->firestoreClient;
        } catch (Throwable $e) {
            Log::warning('Firebase Firestore initialization failed: '.$e->getMessage());
            $this->isConnected = false;

            return null;
        }
    }

    /**
     * Resolve Firestore as the authoritative store for application data.
     */
    protected function firestoreOrFail(): FirestoreClient
    {
        return $this->firestore()
            ?? throw new RuntimeException('Firestore is unavailable. Configure Firebase credentials and verify the Firestore connection.');
    }

    /**
     * Get Realtime Database contract instance if configured.
     */
    public function database(): ?Database
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            return app('firebase.database');
        } catch (Throwable $e) {
            Log::warning('Firebase Realtime Database initialization failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Get Storage contract instance if configured.
     */
    public function storage(): ?Storage
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            return app('firebase.storage');
        } catch (Throwable $e) {
            Log::warning('Firebase Storage initialization failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Test connection to Firestore.
     */
    public function testConnection(): array
    {
        $configured = $this->isConfigured();
        $path = $this->getCredentialsPath();
        $fileExists = $path !== null && file_exists($path);

        if (! $configured) {
            return [
                'status' => 'not_configured',
                'configured' => false,
                'credentials_path' => $path,
                'credentials_file_exists' => $fileExists,
                'message' => 'Kredensial Firebase belum dikonfigurasi atau file JSON belum diletakkan di storage/app/firebase/credential.json.',
            ];
        }

        try {
            $client = $this->firestore();

            if (! $client) {
                return [
                    'status' => 'error',
                    'configured' => true,
                    'credentials_path' => $path,
                    'credentials_file_exists' => $fileExists,
                    'message' => 'Gagal menginisialisasi Firestore client.',
                ];
            }

            // Test ping write and delete in _diagnostics collection
            $testDoc = $client->collection('_diagnostics')->document('ping_test');
            $testDoc->set([
                'ping' => true,
                'timestamp' => time(),
                'platform' => 'PojokNgadiluwih Laravel',
            ]);
            $testDoc->delete();

            return [
                'status' => 'connected',
                'configured' => true,
                'credentials_path' => $path,
                'credentials_file_exists' => $fileExists,
                'message' => 'Berhasil terhubung ke Firebase Firestore!',
            ];
        } catch (Throwable $e) {
            return [
                'status' => 'connection_failed',
                'configured' => true,
                'credentials_path' => $path,
                'credentials_file_exists' => $fileExists,
                'error' => $e->getMessage(),
                'message' => 'Kredensial ditemukan, tetapi gagal berkomunikasi dengan Firestore. Pastikan Firestore Database sudah diaktifkan di Firebase Console.',
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HOME DATA
    |--------------------------------------------------------------------------
    */

    public function getHomeData(): array
    {
        $client = $this->firestoreOrFail();

        $raw = $this->rememberFirestore('home_data', function () use ($client) {
            $newsDocs = $client->collection('news')
                ->where('status', '=', 'published')
                ->documents();

            $newsRows = [];
            foreach ($newsDocs as $doc) {
                if ($doc->exists()) {
                    $newsRows[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            $umkmDocs = $client->collection('umkms')
                ->where('status', '=', 'approved')
                ->documents();

            $umkmRows = [];
            foreach ($umkmDocs as $doc) {
                if ($doc->exists()) {
                    $umkmRows[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            return [
                'newsRows' => $newsRows,
                'umkmRows' => $umkmRows,
            ];
        });

        $latestNews = collect($raw['newsRows'])
            ->map(fn (array $row) => $this->hydrateNews($row['id'], $row['data']))
            ->sortByDesc(fn ($item) => $item->published_at ? $item->published_at->timestamp : 0)
            ->take(3)
            ->values();

        $featuredUmkm = collect($raw['umkmRows'])
            ->map(fn (array $row) => $this->hydrateUmkm($row['id'], $row['data']))
            ->sortByDesc(fn ($item) => $item->created_at ? $item->created_at->timestamp : 0)
            ->take(4)
            ->values();

        return [
            'latestNews' => $latestNews,
            'featuredUmkm' => $featuredUmkm,
            'source' => 'firebase',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | NEWS MODULE
    |--------------------------------------------------------------------------
    */

    public function getNewsPaginated(?string $search = null, ?string $category = null, int $perPage = 9): LengthAwarePaginator
    {
        $client = $this->firestoreOrFail();

        $rows = $this->rememberFirestore('published_news_all', function () use ($client) {
            $docs = $client->collection('news')
                ->where('status', '=', 'published')
                ->documents();

            $list = [];
            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $list[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            return $list;
        });

        $collection = collect($rows)->map(fn (array $row) => $this->hydrateNews($row['id'], $row['data']));

        if ($category && trim($category) !== '') {
            $catNeedle = mb_strtolower(trim($category));
            $collection = $collection->filter(function ($n) use ($catNeedle) {
                $newsCat = mb_strtolower(trim((string) ($n->category ?? '')));

                return $newsCat === $catNeedle
                    || str_contains($newsCat, $catNeedle)
                    || str_contains($catNeedle, $newsCat);
            });
        }

        if ($search && trim($search) !== '') {
            $needle = mb_strtolower(trim($search));
            $collection = $collection->filter(function ($n) use ($needle) {
                return str_contains(mb_strtolower($n->title ?? ''), $needle)
                    || str_contains(mb_strtolower($n->excerpt ?? ''), $needle)
                    || str_contains(mb_strtolower($n->content ?? ''), $needle)
                    || str_contains(mb_strtolower($n->category ?? ''), $needle);
            });
        }

        $collection = $collection->sortByDesc(fn ($n) => $n->published_at ? $n->published_at->timestamp : 0)->values();

        return $this->paginateCollection($collection, $perPage);
    }

    public function findNewsBySlug(string $slug): News
    {
        $docs = $this->firestoreOrFail()->collection('news')
            ->where('slug', '=', $slug)
            ->where('status', '=', 'published')
            ->limit(1)
            ->documents();

        foreach ($docs as $doc) {
            if ($doc->exists()) {
                return $this->hydrateNews($doc->id(), $doc->data());
            }
        }

        throw (new ModelNotFoundException)->setModel(News::class);
    }

    public function findNewsById(string|int $id): News
    {
        $doc = $this->firestoreOrFail()->collection('news')->document((string) $id)->snapshot();
        if ($doc->exists()) {
            return $this->hydrateNews($doc->id(), $doc->data());
        }

        throw (new ModelNotFoundException)->setModel(News::class, [$id]);
    }

    public function getAdminNewsPaginated(int $perPage = 15): LengthAwarePaginator
    {
        $client = $this->firestoreOrFail();

        $rows = $this->rememberFirestore('admin_news_all', function () use ($client) {
            $docs = $client->collection('news')->documents();
            $list = [];
            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $list[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            return $list;
        });

        $collection = collect($rows)
            ->map(fn (array $row) => $this->hydrateNews($row['id'], $row['data']))
            ->sortByDesc(fn ($n) => $n->created_at ? $n->created_at->timestamp : 0)
            ->values();

        return $this->paginateCollection($collection, $perPage);
    }

    public function createNews(array $data): News
    {
        $slug = $data['slug'] ?? Str::slug($data['title']);
        $payload = [
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'] ?? 'Kegiatan',
            'excerpt' => $data['excerpt'] ?? Str::limit(strip_tags($data['content'] ?? ''), 150),
            'content' => $data['content'] ?? '',
            'image_path' => $data['image_path'] ?? null,
            'author_id' => $data['author_id'] ?? 1,
            'published_at' => $data['published_at'] ?? now()->toIso8601String(),
            'status' => $data['status'] ?? 'published',
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ];

        $docRef = $this->firestoreOrFail()->collection('news')->add($payload);
        $this->flushCache();

        return $this->hydrateNews($docRef->id(), $payload);
    }

    public function updateNews(string|int $id, array $data): bool
    {
        $docRef = $this->firestoreOrFail()->collection('news')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['updated_at'] = now()->toIso8601String();
        $docRef->set($data, ['merge' => true]);
        $this->flushCache();

        return true;
    }

    public function deleteNews(string|int $id): bool
    {
        $docRef = $this->firestoreOrFail()->collection('news')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        $docRef->delete();
        $this->flushCache();

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | UMKM MODULE
    |--------------------------------------------------------------------------
    */

    public function getApprovedUmkmsPaginated(?string $search = null, ?string $category = null, int $perPage = 12): LengthAwarePaginator
    {
        $client = $this->firestoreOrFail();
        $cacheKey = 'approved_umkms_all';

        $rows = $this->rememberFirestore($cacheKey, function () use ($client) {
            $docs = $client->collection('umkms')->where('status', '=', 'approved')->documents();
            $list = [];

            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $list[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            return $list;
        });

        $collection = collect($rows)->map(fn (array $row) => $this->hydrateUmkm($row['id'], $row['data']));

        if ($category && trim($category) !== '') {
            $catNeedle = mb_strtolower(trim($category));
            $collection = $collection->filter(function ($umkm) use ($catNeedle) {
                $itemCat = mb_strtolower(trim((string) ($umkm->category ?? '')));

                return $itemCat === $catNeedle
                    || str_contains($itemCat, $catNeedle)
                    || str_contains($catNeedle, $itemCat);
            });
        }

        if ($search && trim($search) !== '') {
            $needle = mb_strtolower(trim($search));
            $collection = $collection->filter(function ($umkm) use ($needle) {
                return str_contains(mb_strtolower($umkm->name ?? ''), $needle)
                    || str_contains(mb_strtolower($umkm->description ?? ''), $needle)
                    || str_contains(mb_strtolower($umkm->dusun ?? ''), $needle)
                    || str_contains(mb_strtolower($umkm->category ?? ''), $needle);
            });
        }

        $collection = $collection->sortByDesc(fn ($umkm) => $umkm->created_at ? $umkm->created_at->timestamp : 0)->values();

        return $this->paginateCollection($collection, $perPage);
    }

    public function findUmkmBySlug(string $slug): Umkm
    {
        $docs = $this->firestoreOrFail()->collection('umkms')
            ->where('slug', '=', $slug)
            ->where('status', '=', 'approved')
            ->limit(1)
            ->documents();

        foreach ($docs as $doc) {
            if ($doc->exists()) {
                return $this->hydrateUmkm($doc->id(), $doc->data());
            }
        }

        throw (new ModelNotFoundException)->setModel(Umkm::class);
    }

    public function findUmkmById(string|int $id): Umkm
    {
        $doc = $this->firestoreOrFail()->collection('umkms')->document((string) $id)->snapshot();
        if ($doc->exists()) {
            return $this->hydrateUmkm($doc->id(), $doc->data());
        }

        throw (new ModelNotFoundException)->setModel(Umkm::class, [$id]);
    }

    public function getAdminUmkmsPaginated(int $perPage = 15, ?string $status = 'pending'): LengthAwarePaginator
    {
        $client = $this->firestoreOrFail();
        $cacheKey = 'admin_umkms_'.md5((string) $status);

        $rows = $this->rememberFirestore($cacheKey, function () use ($client, $status) {
            $collectionRef = $client->collection('umkms');

            if ($status && $status !== 'all') {
                $docs = $collectionRef->where('status', '=', $status)->documents();
            } else {
                $docs = $collectionRef->documents();
            }

            $list = [];
            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $list[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            return $list;
        });

        $collection = collect($rows)
            ->map(fn (array $row) => $this->hydrateUmkm($row['id'], $row['data']))
            ->sortByDesc(fn ($umkm) => $umkm->created_at ? $umkm->created_at->timestamp : 0)
            ->values();

        return $this->paginateCollection($collection, $perPage);
    }

    public function createUmkm(array $data): Umkm
    {
        $storeName = $data['store_name'] ?? $data['name'];
        $baseSlug = Str::slug($storeName);
        $slug = $baseSlug;
        $counter = 1;

        $client = $this->firestoreOrFail();

        while ($this->firestoreSlugExists('umkms', $slug)) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $products = [];
        if (isset($data['products'])) {
            if (is_array($data['products'])) {
                $products = array_values(array_filter(array_map('trim', $data['products'])));
            } elseif (is_string($data['products']) && trim($data['products']) !== '') {
                $lines = preg_split('/[\r\n]+/', $data['products']);
                $products = array_values(array_filter(array_map('trim', (array) $lines)));
            }
        }

        $payload = [
            'name' => $storeName,
            'slug' => $slug,
            'owner_name' => $data['owner_name'],
            'nik' => $data['nik'],
            'whatsapp' => $data['whatsapp'],
            'category' => $data['category'],
            'dusun' => $data['dusun'],
            'address' => $data['address'],
            'price' => isset($data['price']) ? (int) $data['price'] : null,
            'price_unit' => $data['price_unit'] ?? null,
            'description' => $data['description'],
            'products' => $products,
            'image_path' => $data['image_path'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ];

        $docRef = $client->collection('umkms')->add($payload);
        $this->flushCache();

        return $this->hydrateUmkm($docRef->id(), $payload);
    }

    public function updateUmkmStatus(string|int $id, string $status): bool
    {
        $docRef = $this->firestoreOrFail()->collection('umkms')->document((string) $id);
        $snapshot = $docRef->snapshot();
        if (! $snapshot->exists() || ($snapshot->data()['status'] ?? null) !== 'pending') {
            return false;
        }

        $docRef->set(['status' => $status, 'updated_at' => now()->toIso8601String()], ['merge' => true]);
        $this->flushCache();

        return true;
    }

    public function updateUmkm(string|int $id, array $data): bool
    {
        $docRef = $this->firestoreOrFail()->collection('umkms')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (isset($data['price'])) {
            $data['price'] = $data['price'] !== null && $data['price'] !== '' ? (int) $data['price'] : null;
        }
        if (isset($data['products'])) {
            if (is_array($data['products'])) {
                $data['products'] = array_values(array_filter(array_map('trim', $data['products'])));
            } elseif (is_string($data['products'])) {
                $lines = preg_split('/[\r\n]+/', $data['products']);
                $data['products'] = array_values(array_filter(array_map('trim', (array) $lines)));
            }
        }

        $data['updated_at'] = now()->toIso8601String();
        $docRef->set($data, ['merge' => true]);
        $this->flushCache();

        return true;
    }

    public function deleteUmkm(string|int $id): bool
    {
        $docRef = $this->firestoreOrFail()->collection('umkms')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        $docRef->delete();
        $this->flushCache();

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | ASPIRATION MODULE
    |--------------------------------------------------------------------------
    */

    public function getAspirationsPaginated(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $client = $this->firestoreOrFail();
        $cacheKey = 'aspirations_'.md5((string) $status);

        $rows = $this->rememberFirestore($cacheKey, function () use ($client, $status) {
            $query = $client->collection('aspirations');
            if ($status) {
                $query = $query->where('status', '=', $status);
            }

            $docs = $query->documents();
            $list = [];
            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $list[] = ['id' => $doc->id(), 'data' => $doc->data()];
                }
            }

            return $list;
        });

        $collection = collect($rows)->map(fn (array $row) => $this->hydrateAspiration($row['id'], $row['data']));
        if ($search) {
            $needle = mb_strtolower(trim($search));
            $collection = $collection->filter(function ($aspiration) use ($needle) {
                return str_contains(mb_strtolower($aspiration->name ?? ''), $needle)
                    || str_contains(mb_strtolower($aspiration->title ?? ''), $needle)
                    || str_contains(mb_strtolower($aspiration->message ?? ''), $needle)
                    || str_contains(mb_strtolower($aspiration->dusun ?? ''), $needle);
            });
        }

        $collection = $collection->sortByDesc(fn ($aspiration) => $aspiration->created_at ? $aspiration->created_at->timestamp : 0)->values();

        return $this->paginateCollection($collection, $perPage);
    }

    public function createAspiration(array $data): Aspiration
    {
        $payload = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'dusun' => $data['dusun'],
            'category' => $data['category'],
            'title' => $data['title'],
            'message' => $data['message'],
            'is_anonymous' => (bool) ($data['is_anonymous'] ?? false),
            'status' => 'pending',
            'admin_notes' => null,
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ];

        $docRef = $this->firestoreOrFail()->collection('aspirations')->add($payload);
        $this->flushCache();

        return $this->hydrateAspiration($docRef->id(), $payload);
    }

    public function updateAspirationStatus(string|int $id, string $status, ?string $notes = null): bool
    {
        $docRef = $this->firestoreOrFail()->collection('aspirations')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        $update = ['status' => $status, 'updated_at' => now()->toIso8601String()];
        if ($notes !== null) {
            $update['admin_notes'] = $notes;
        }
        $docRef->set($update, ['merge' => true]);
        $this->flushCache();

        return true;
    }

    public function findAspirationById(string|int $id): Aspiration
    {
        $doc = $this->firestoreOrFail()->collection('aspirations')->document((string) $id)->snapshot();
        if ($doc->exists()) {
            return $this->hydrateAspiration($doc->id(), $doc->data());
        }

        throw (new ModelNotFoundException)->setModel(Aspiration::class, [$id]);
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD METRICS
    |--------------------------------------------------------------------------
    */

    public function getDashboardMetrics(): array
    {
        $client = $this->firestoreOrFail();

        $raw = $this->rememberFirestore('dashboard_metrics', function () use ($client) {
            $approvedUmkmCount = 0;
            $pendingUmkmCount = 0;
            $umkmRows = [];

            foreach ($client->collection('umkms')->documents() as $doc) {
                if ($doc->exists()) {
                    $data = $doc->data();
                    $status = $data['status'] ?? 'pending';
                    if ($status === 'approved') {
                        $approvedUmkmCount++;
                    } elseif ($status === 'pending') {
                        $pendingUmkmCount++;
                    }
                    $umkmRows[] = ['id' => $doc->id(), 'data' => $data];
                }
            }

            $aspirationCount = 0;
            foreach ($client->collection('aspirations')->documents() as $doc) {
                if ($doc->exists()) {
                    $aspirationCount++;
                }
            }

            $newsCount = 0;
            foreach ($client->collection('news')->documents() as $doc) {
                if ($doc->exists()) {
                    $newsCount++;
                }
            }

            return [
                'approvedUmkmCount' => $approvedUmkmCount,
                'pendingUmkmCount' => $pendingUmkmCount,
                'aspirationCount' => $aspirationCount,
                'newsCount' => $newsCount,
                'umkmRows' => $umkmRows,
            ];
        });

        $recentUmkms = collect($raw['umkmRows'])
            ->map(fn (array $row) => $this->hydrateUmkm($row['id'], $row['data']))
            ->sortByDesc(fn ($umkm) => $umkm->created_at ? $umkm->created_at->timestamp : 0)
            ->take(5)
            ->values();

        return [
            'approvedUmkmCount' => $raw['approvedUmkmCount'],
            'pendingUmkmCount' => $raw['pendingUmkmCount'],
            'aspirationCount' => $raw['aspirationCount'],
            'newsCount' => $raw['newsCount'],
            'recentUmkms' => $recentUmkms,
            'source' => 'firebase',
        ];
    }

    /**
     * Compute real-time insights summary from Firestore aspirations & UMKM data.
     *
     * @return array{
     *     totalAspirations: int,
     *     pendingAspirations: int,
     *     processedAspirations: int,
     *     completedAspirations: int,
     *     handledAspirations: int,
     *     resolutionRate: float,
     *     approvedUmkmCount: int
     * }
     */
    public function getInsightsSummary(): array
    {
        $client = $this->firestoreOrFail();

        return $this->rememberFirestore('insights_summary', function () use ($client) {
            $totalAspirations = 0;
            $pendingAspirations = 0;
            $processedAspirations = 0;
            $completedAspirations = 0;

            foreach ($client->collection('aspirations')->documents() as $doc) {
                if (! $doc->exists()) {
                    continue;
                }

                $totalAspirations++;
                $status = $doc->data()['status'] ?? 'pending';

                if ($status === 'completed') {
                    $completedAspirations++;
                } elseif ($status === 'processed') {
                    $processedAspirations++;
                } else {
                    $pendingAspirations++;
                }
            }

            $handledAspirations = $processedAspirations + $completedAspirations;
            $resolutionRate = $totalAspirations > 0
                ? round(($handledAspirations / $totalAspirations) * 100, 1)
                : 0.0;

            $approvedUmkmCount = 0;
            foreach ($client->collection('umkms')->where('status', '=', 'approved')->documents() as $doc) {
                if ($doc->exists()) {
                    $approvedUmkmCount++;
                }
            }

            return [
                'totalAspirations' => $totalAspirations,
                'pendingAspirations' => $pendingAspirations,
                'processedAspirations' => $processedAspirations,
                'completedAspirations' => $completedAspirations,
                'handledAspirations' => $handledAspirations,
                'resolutionRate' => $resolutionRate,
                'approvedUmkmCount' => $approvedUmkmCount,
            ];
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN MANAGEMENT (Firestore "admins" collection)
    |--------------------------------------------------------------------------
    */

    /**
     * Get all registered administrators from Firestore (or fallback).
     */
    public function getAdmins(): Collection
    {
        $client = $this->firestore();

        if (! $client) {
            try {
                return User::all();
            } catch (Throwable) {
                return collect();
            }
        }

        try {
            $docs = $client->collection('admins')->documents();
            $admins = collect();

            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $admins->push($this->hydrateAdmin($doc->id(), $doc->data()));
                }
            }

            return $admins;
        } catch (Throwable $e) {
            Log::warning('Firebase getAdmins failed: '.$e->getMessage());

            try {
                return User::all();
            } catch (Throwable) {
                return collect();
            }
        }
    }

    /**
     * Find admin by email in Firestore (or fallback).
     */
    public function findAdminByEmail(string $email): User|FirebaseAdmin|null
    {
        $client = $this->firestore();

        if ($client) {
            try {
                // Check direct document ID (email as doc id)
                $docRef = $client->collection('admins')->document($email);
                $snapshot = $docRef->snapshot();

                if ($snapshot->exists()) {
                    return $this->hydrateAdmin($snapshot->id(), $snapshot->data());
                }

                // Query by email field
                $query = $client->collection('admins')
                    ->where('email', '=', $email)
                    ->limit(1)
                    ->documents();

                foreach ($query as $doc) {
                    if ($doc->exists()) {
                        return $this->hydrateAdmin($doc->id(), $doc->data());
                    }
                }
            } catch (Throwable $e) {
                Log::warning('Firebase findAdminByEmail failed: '.$e->getMessage());
            }
        }

        // Fallback to local User model if present
        try {
            return User::where('email', $email)->first();
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Find an administrator by their Firestore document ID (or local ID fallback).
     */
    public function findAdminById(string $id): User|FirebaseAdmin|null
    {
        $cached = $this->rememberFirestore('admin_by_id_'.md5($id), function () use ($id) {
            $client = $this->firestore();

            if ($client) {
                try {
                    $snapshot = $client->collection('admins')->document($id)->snapshot();

                    if ($snapshot->exists()) {
                        return ['type' => 'firebase', 'id' => $snapshot->id(), 'data' => $snapshot->data()];
                    }
                } catch (Throwable $e) {
                    Log::warning('Firebase findAdminById failed: '.$e->getMessage());
                }
            }

            return null;
        });

        if (is_array($cached) && ($cached['type'] ?? null) === 'firebase') {
            return $this->hydrateAdmin($cached['id'], $cached['data']);
        }

        try {
            return User::find($id);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Persist a remember token for a Firebase administrator.
     */
    public function updateAdminRememberToken(string $id, string $token): void
    {
        $client = $this->firestore();

        if ($client) {
            $client->collection('admins')->document($id)->set([
                'remember_token' => $token,
            ], ['merge' => true]);

            return;
        }

        $user = User::findOrFail($id);
        $user->setRememberToken($token);
        $user->save();
    }

    /**
     * Persist a rehashed password for a Firebase administrator.
     */
    public function updateAdminPassword(string $id, string $password, ?bool $mustChangePassword = null): void
    {
        $client = $this->firestore();

        if ($client) {
            $payload = [
                'password' => $password,
                'updated_at' => Carbon::now()->toIso8601String(),
            ];

            if ($mustChangePassword !== null) {
                $payload['must_change_password'] = $mustChangePassword;
            }

            $client->collection('admins')->document($id)->set($payload, ['merge' => true]);
            $this->flushCache();

            return;
        }

        $user = User::findOrFail($id);
        $user->password = $password;
        $user->save();
    }

    /**
     * Update an administrator's profile details in Firestore.
     */
    public function updateAdminProfile(string $id, array $data): bool
    {
        $payload = [
            'name' => trim((string) ($data['name'] ?? '')),
            'updated_at' => Carbon::now()->toIso8601String(),
        ];

        $client = $this->firestore();

        if ($client) {
            $docRef = $client->collection('admins')->document($id);
            if (! $docRef->snapshot()->exists()) {
                return false;
            }

            $docRef->set($payload, ['merge' => true]);
            $this->flushCache();

            return true;
        }

        $user = User::find($id);
        if (! $user) {
            return false;
        }

        $user->name = $payload['name'];
        $user->save();

        return true;
    }

    /**
     * Reset an administrator's password to a temporary password and require change on next login.
     */
    public function resetAdminPassword(string $email, string $plainPassword): User|FirebaseAdmin|null
    {
        $normalizedEmail = strtolower(trim($email));
        $hashedPassword = Hash::make($plainPassword);
        $client = $this->firestore();

        if ($client) {
            $docRef = $client->collection('admins')->document($normalizedEmail);
            $snapshot = $docRef->snapshot();

            if (! $snapshot->exists()) {
                $query = $client->collection('admins')
                    ->where('email', '=', $normalizedEmail)
                    ->limit(1)
                    ->documents();

                foreach ($query as $doc) {
                    if ($doc->exists()) {
                        $docRef = $doc->reference();
                        $snapshot = $doc;
                        break;
                    }
                }
            }

            if ($snapshot->exists()) {
                $payload = [
                    'password' => $hashedPassword,
                    'must_change_password' => true,
                    'updated_at' => Carbon::now()->toIso8601String(),
                ];

                $docRef->set($payload, ['merge' => true]);
                $this->flushCache();

                return $this->hydrateAdmin($snapshot->id(), array_merge($snapshot->data(), $payload));
            }

            return null;
        }

        $user = User::where('email', $normalizedEmail)->first();
        if (! $user) {
            return null;
        }

        $user->password = $hashedPassword;
        $user->save();

        return $user;
    }

    /**
     * Create or update an administrator in Firestore.
     */
    public function saveAdmin(array $data): User|FirebaseAdmin
    {
        $email = strtolower(trim($data['email']));
        $name = $data['name'] ?? 'Admin Desa Ngadiluwih';
        $password = $data['password'];

        if (! str_starts_with($password, '$2y$') && ! str_starts_with($password, '$2a$')) {
            $password = Hash::make($password);
        }

        $payload = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $data['role'] ?? 'admin',
            'is_active' => true,
            'must_change_password' => (bool) ($data['must_change_password'] ?? false),
            'updated_at' => Carbon::now()->toIso8601String(),
        ];

        $client = $this->firestore();

        if ($client) {
            try {
                $docRef = $client->collection('admins')->document($email);
                $snapshot = $docRef->snapshot();

                $payload['created_at'] = $snapshot->exists() && $snapshot->get('created_at')
                    ? $snapshot->get('created_at')
                    : Carbon::now()->toIso8601String();

                $docRef->set($payload, ['merge' => true]);

                return $this->hydrateAdmin($email, $payload);
            } catch (Throwable $e) {
                Log::warning('Firebase saveAdmin failed: '.$e->getMessage());
            }
        }

        try {
            return User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => $password,
                ]
            );
        } catch (Throwable) {
            return $this->hydrateAdmin($email, $payload);
        }
    }

    /**
     * Authenticate admin credentials against Firestore.
     */
    public function authenticateAdmin(string $email, string $password): User|FirebaseAdmin|null
    {
        $admin = $this->findAdminByEmail($email);

        if (! $admin) {
            return null;
        }

        if (! Hash::check($password, $admin->password)) {
            return null;
        }

        if ($admin instanceof FirebaseAdmin) {
            return $admin;
        }

        // Sync to local database so Laravel SessionGuard and Auth::user() work seamlessly
        try {
            $local = User::where('email', $admin->email)->first();

            if (! $local) {
                $local = User::create([
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'password' => $admin->password,
                ]);
            } elseif ($local->password !== $admin->password || $local->name !== $admin->name) {
                $local->update([
                    'name' => $admin->name,
                    'password' => $admin->password,
                ]);
            }

            return $local;
        } catch (Throwable) {
            return $admin;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | KNOWLEDGE BASE MODULE (AI Corpus)
    |--------------------------------------------------------------------------
    */

    /**
     * Get all AI knowledge base documents from Firestore.
     *
     * @return Collection<int, object>
     */
    public function getKnowledgeDocuments(): Collection
    {
        $client = $this->firestore();

        if (! $client) {
            return collect();
        }

        try {
            $docs = $client->collection('knowledge_base')->documents();
            $items = [];

            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    $items[] = $this->hydrateKnowledgeDocument($doc->id(), $doc->data());
                }
            }

            return collect($items)
                ->sortByDesc(fn ($item) => isset($item->created_at) && $item->created_at instanceof Carbon ? $item->created_at->timestamp : 0)
                ->values();
        } catch (Throwable $e) {
            Log::warning('Firebase getKnowledgeDocuments failed: '.$e->getMessage());

            return collect();
        }
    }

    /**
     * Create a new knowledge base document in Firestore.
     */
    public function createKnowledgeDocument(array $data): object
    {
        $client = $this->firestoreOrFail();

        $payload = [
            'topic' => trim((string) ($data['topic'] ?? '')),
            'category' => trim((string) ($data['category'] ?? 'Umum')),
            'content' => trim((string) ($data['content'] ?? '')),
            'created_at' => Carbon::now()->toIso8601String(),
            'updated_at' => Carbon::now()->toIso8601String(),
        ];

        $docRef = $client->collection('knowledge_base')->add($payload);
        $this->flushCache();

        return $this->hydrateKnowledgeDocument($docRef->id(), $payload);
    }

    /**
     * Delete a knowledge base document from Firestore by its ID.
     */
    public function deleteKnowledgeDocument(string $id): bool
    {
        $client = $this->firestoreOrFail();

        try {
            $client->collection('knowledge_base')->document($id)->delete();
            $this->flushCache();

            return true;
        } catch (Throwable $e) {
            Log::warning("Firebase deleteKnowledgeDocument ({$id}) failed: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Wrap raw knowledge document array into an object.
     */
    protected function hydrateKnowledgeDocument(string $id, array $data): object
    {
        return (object) [
            'id' => $id,
            'topic' => $data['topic'] ?? '',
            'category' => $data['category'] ?? 'Umum',
            'content' => $data['content'] ?? '',
            'created_at' => isset($data['created_at']) && is_string($data['created_at'])
                ? Carbon::parse($data['created_at'])
                : Carbon::now(),
            'updated_at' => isset($data['updated_at']) && is_string($data['updated_at'])
                ? Carbon::parse($data['updated_at'])
                : Carbon::now(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | HYDRATION HELPERS (Wrap Firestore documents into compatible model instances)
    |--------------------------------------------------------------------------
    */

    protected function hydrateNews(string $id, array $data): News
    {
        $news = new News;
        $news->exists = true;
        $news->setKeyType('string')->setIncrementing(false);
        $news->id = $id;

        foreach ($data as $key => $value) {
            $news->setAttribute($key, $value);
        }

        if (isset($data['published_at']) && is_string($data['published_at'])) {
            $news->setAttribute('published_at', Carbon::parse($data['published_at']));
        }
        if (isset($data['created_at']) && is_string($data['created_at'])) {
            $news->setAttribute('created_at', Carbon::parse($data['created_at']));
        }

        return $news;
    }

    protected function hydrateUmkm(string $id, array $data): Umkm
    {
        $umkm = new Umkm;
        $umkm->exists = true;
        $umkm->setKeyType('string')->setIncrementing(false);
        $umkm->id = $id;

        foreach ($data as $key => $value) {
            $umkm->setAttribute($key, $value);
        }

        if (isset($data['created_at']) && is_string($data['created_at'])) {
            $umkm->setAttribute('created_at', Carbon::parse($data['created_at']));
        }

        return $umkm;
    }

    protected function hydrateAspiration(string $id, array $data): Aspiration
    {
        $aspiration = new Aspiration;
        $aspiration->exists = true;
        $aspiration->setKeyType('string')->setIncrementing(false);
        $aspiration->id = $id;

        foreach ($data as $key => $value) {
            $aspiration->setAttribute($key, $value);
        }

        if (isset($data['created_at']) && is_string($data['created_at'])) {
            $aspiration->setAttribute('created_at', Carbon::parse($data['created_at']));
        }

        return $aspiration;
    }

    protected function hydrateAdmin(string $id, array $data): FirebaseAdmin
    {
        $admin = new FirebaseAdmin;
        $admin->exists = true;
        $admin->setKeyType('string')->setIncrementing(false);
        $admin->id = $id;

        foreach ($data as $key => $value) {
            $admin->setAttribute($key, $value);
        }

        if (isset($data['created_at']) && is_string($data['created_at'])) {
            $admin->setAttribute('created_at', Carbon::parse($data['created_at']));
        }
        if (isset($data['updated_at']) && is_string($data['updated_at'])) {
            $admin->setAttribute('updated_at', Carbon::parse($data['updated_at']));
        }

        return $admin;
    }

    protected function firestoreSlugExists(string $collection, string $slug): bool
    {
        $docs = $this->firestoreClient?->collection($collection)
            ->where('slug', '=', $slug)
            ->limit(1)
            ->documents();

        if ($docs) {
            foreach ($docs as $doc) {
                if ($doc->exists()) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function paginateCollection(Collection $items, int $perPage): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $sliced = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $sliced,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );
    }
}
