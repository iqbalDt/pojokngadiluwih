<?php

namespace App\Services;

use App\Models\Aspiration;
use App\Models\News;
use App\Models\Umkm;
use Carbon\Carbon;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Storage;
use Throwable;

class FirebaseService
{
    protected ?FirestoreClient $firestoreClient = null;

    protected bool $testedConnection = false;

    protected bool $isConnected = false;

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

        return $path !== null && file_exists($path) && is_readable($path);
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
        $client = $this->firestore();

        if ($client) {
            try {
                // Latest 3 published news
                $newsDocs = $client->collection('news')
                    ->where('status', '=', 'published')
                    ->documents();

                $newsList = [];
                foreach ($newsDocs as $doc) {
                    if ($doc->exists()) {
                        $newsList[] = $this->hydrateNews($doc->id(), $doc->data());
                    }
                }

                $latestNews = collect($newsList)
                    ->sortByDesc(fn ($item) => $item->published_at ? $item->published_at->timestamp : 0)
                    ->take(3)
                    ->values();

                // 4 approved featured UMKM
                $umkmDocs = $client->collection('umkms')
                    ->where('status', '=', 'approved')
                    ->documents();

                $umkmList = [];
                foreach ($umkmDocs as $doc) {
                    if ($doc->exists()) {
                        $umkmList[] = $this->hydrateUmkm($doc->id(), $doc->data());
                    }
                }

                $featuredUmkm = collect($umkmList)
                    ->sortByDesc(fn ($item) => $item->created_at ? $item->created_at->timestamp : 0)
                    ->take(4)
                    ->values();

                return [
                    'latestNews' => $latestNews,
                    'featuredUmkm' => $featuredUmkm,
                    'source' => 'firebase',
                ];
            } catch (Throwable $e) {
                Log::warning('Firebase getHomeData failed, falling back to local database: '.$e->getMessage());
            }
        }

        // Fallback to local Eloquent database
        return [
            'latestNews' => News::where('status', 'published')->latest('published_at')->take(3)->get(),
            'featuredUmkm' => Umkm::approved()->latest()->take(4)->get(),
            'source' => 'local_database',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | NEWS MODULE
    |--------------------------------------------------------------------------
    */

    public function getNewsPaginated(int $perPage = 9): LengthAwarePaginator
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docs = $client->collection('news')
                    ->where('status', '=', 'published')
                    ->documents();

                $items = [];
                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        $items[] = $this->hydrateNews($doc->id(), $doc->data());
                    }
                }

                $collection = collect($items)->sortByDesc(fn ($n) => $n->published_at ? $n->published_at->timestamp : 0)->values();

                return $this->paginateCollection($collection, $perPage);
            } catch (Throwable $e) {
                Log::warning('Firebase getNewsPaginated failed: '.$e->getMessage());
            }
        }

        return News::where('status', 'published')->latest('published_at')->paginate($perPage);
    }

    public function findNewsBySlug(string $slug): News
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docs = $client->collection('news')
                    ->where('slug', '=', $slug)
                    ->limit(1)
                    ->documents();

                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        return $this->hydrateNews($doc->id(), $doc->data());
                    }
                }
            } catch (Throwable $e) {
                Log::warning('Firebase findNewsBySlug failed: '.$e->getMessage());
            }
        }

        return News::where('slug', $slug)->firstOrFail();
    }

    public function getAdminNewsPaginated(int $perPage = 15): LengthAwarePaginator
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docs = $client->collection('news')->documents();
                $items = [];
                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        $items[] = $this->hydrateNews($doc->id(), $doc->data());
                    }
                }

                $collection = collect($items)->sortByDesc(fn ($n) => $n->created_at ? $n->created_at->timestamp : 0)->values();

                return $this->paginateCollection($collection, $perPage);
            } catch (Throwable $e) {
                Log::warning('Firebase getAdminNewsPaginated failed: '.$e->getMessage());
            }
        }

        return News::latest()->paginate($perPage);
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

        $client = $this->firestore();
        $docId = null;

        if ($client) {
            try {
                $docRef = $client->collection('news')->add($payload);
                $docId = $docRef->id();
            } catch (Throwable $e) {
                Log::warning('Firebase createNews error: '.$e->getMessage());
            }
        }

        // Local mirror / fallback
        try {
            $model = News::create($payload);
            if ($docId) {
                $model->setAttribute('firebase_id', $docId);
            }

            return $model;
        } catch (Throwable) {
            return $this->hydrateNews($docId ?? (string) time(), $payload);
        }
    }

    public function updateNews(string|int $id, array $data): bool
    {
        $client = $this->firestore();
        if ($client) {
            try {
                $docRef = $client->collection('news')->document((string) $id);
                $snapshot = $docRef->snapshot();
                if ($snapshot->exists()) {
                    $data['updated_at'] = now()->toIso8601String();
                    $docRef->set($data, ['merge' => true]);

                    return true;
                }
            } catch (Throwable $e) {
                Log::warning('Firebase updateNews error: '.$e->getMessage());
            }
        }

        $news = News::find($id);
        if ($news) {
            return $news->update($data);
        }

        return false;
    }

    public function deleteNews(string|int $id): bool
    {
        $client = $this->firestore();
        if ($client) {
            try {
                $client->collection('news')->document((string) $id)->delete();
            } catch (Throwable $e) {
                Log::warning('Firebase deleteNews error: '.$e->getMessage());
            }
        }

        $news = News::find($id);
        if ($news) {
            return (bool) $news->delete();
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | UMKM MODULE
    |--------------------------------------------------------------------------
    */

    public function getApprovedUmkmsPaginated(?string $search = null, ?string $category = null, int $perPage = 12): LengthAwarePaginator
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $query = $client->collection('umkms')->where('status', '=', 'approved');

                if ($category) {
                    $query = $query->where('category', '=', $category);
                }

                $docs = $query->documents();
                $items = [];

                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        $items[] = $this->hydrateUmkm($doc->id(), $doc->data());
                    }
                }

                $collection = collect($items);

                if ($search) {
                    $needle = mb_strtolower(trim($search));
                    $collection = $collection->filter(function ($u) use ($needle) {
                        return str_contains(mb_strtolower($u->name ?? ''), $needle)
                            || str_contains(mb_strtolower($u->description ?? ''), $needle)
                            || str_contains(mb_strtolower($u->dusun ?? ''), $needle);
                    });
                }

                $collection = $collection->sortByDesc(fn ($u) => $u->created_at ? $u->created_at->timestamp : 0)->values();

                return $this->paginateCollection($collection, $perPage);
            } catch (Throwable $e) {
                Log::warning('Firebase getApprovedUmkmsPaginated failed: '.$e->getMessage());
            }
        }

        // Local DB Fallback
        $dbQuery = Umkm::approved()->latest();
        if ($search) {
            $dbQuery->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('dusun', 'like', "%{$search}%");
            });
        }
        if ($category) {
            $dbQuery->where('category', $category);
        }

        return $dbQuery->paginate($perPage)->withQueryString();
    }

    public function findUmkmBySlug(string $slug): Umkm
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docs = $client->collection('umkms')
                    ->where('slug', '=', $slug)
                    ->where('status', '=', 'approved')
                    ->limit(1)
                    ->documents();

                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        return $this->hydrateUmkm($doc->id(), $doc->data());
                    }
                }
            } catch (Throwable $e) {
                Log::warning('Firebase findUmkmBySlug failed: '.$e->getMessage());
            }
        }

        return Umkm::where('slug', $slug)->approved()->firstOrFail();
    }

    public function findUmkmById(string|int $id): Umkm
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $doc = $client->collection('umkms')->document((string) $id)->snapshot();
                if ($doc->exists()) {
                    return $this->hydrateUmkm($doc->id(), $doc->data());
                }
            } catch (Throwable $e) {
                Log::warning('Firebase findUmkmById failed: '.$e->getMessage());
            }
        }

        return Umkm::findOrFail($id);
    }

    public function getAdminUmkmsPaginated(int $perPage = 15): LengthAwarePaginator
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docs = $client->collection('umkms')->documents();
                $items = [];
                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        $items[] = $this->hydrateUmkm($doc->id(), $doc->data());
                    }
                }

                // Sort: pending first, then newest
                $collection = collect($items)->sortBy(function ($u) {
                    $priority = ($u->status === 'pending') ? 1 : 2;
                    $time = $u->created_at ? $u->created_at->timestamp : 0;

                    return sprintf('%d_%012d', $priority, 999999999999 - $time);
                })->values();

                return $this->paginateCollection($collection, $perPage);
            } catch (Throwable $e) {
                Log::warning('Firebase getAdminUmkmsPaginated failed: '.$e->getMessage());
            }
        }

        return Umkm::orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate($perPage);
    }

    public function createUmkm(array $data): Umkm
    {
        $storeName = $data['store_name'] ?? $data['name'];
        $baseSlug = Str::slug($storeName);
        $slug = $baseSlug;
        $counter = 1;

        $client = $this->firestore();

        if ($client) {
            try {
                while ($this->firestoreSlugExists('umkms', $slug)) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
            } catch (Throwable) {
                $slug = "{$baseSlug}-".time();
            }
        } else {
            while (Umkm::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
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
            'image_path' => $data['image_path'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ];

        $docId = null;
        if ($client) {
            try {
                $docRef = $client->collection('umkms')->add($payload);
                $docId = $docRef->id();
            } catch (Throwable $e) {
                Log::warning('Firebase createUmkm error: '.$e->getMessage());
            }
        }

        // Local mirror / fallback
        try {
            $model = Umkm::create($payload);
            if ($docId) {
                $model->setAttribute('firebase_id', $docId);
            }

            return $model;
        } catch (Throwable) {
            return $this->hydrateUmkm($docId ?? (string) time(), $payload);
        }
    }

    public function updateUmkmStatus(string|int $id, string $status): bool
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docRef = $client->collection('umkms')->document((string) $id);
                $snapshot = $docRef->snapshot();
                if ($snapshot->exists()) {
                    $docRef->set(['status' => $status, 'updated_at' => now()->toIso8601String()], ['merge' => true]);
                }
            } catch (Throwable $e) {
                Log::warning('Firebase updateUmkmStatus error: '.$e->getMessage());
            }
        }

        $umkm = Umkm::find($id);
        if ($umkm) {
            return $umkm->update(['status' => $status]);
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | ASPIRATION MODULE
    |--------------------------------------------------------------------------
    */

    public function getAspirationsPaginated(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $query = $client->collection('aspirations');
                if ($status) {
                    $query = $query->where('status', '=', $status);
                }

                $docs = $query->documents();
                $items = [];
                foreach ($docs as $doc) {
                    if ($doc->exists()) {
                        $items[] = $this->hydrateAspiration($doc->id(), $doc->data());
                    }
                }

                $collection = collect($items);

                if ($search) {
                    $needle = mb_strtolower(trim($search));
                    $collection = $collection->filter(function ($a) use ($needle) {
                        return str_contains(mb_strtolower($a->name ?? ''), $needle)
                            || str_contains(mb_strtolower($a->title ?? ''), $needle)
                            || str_contains(mb_strtolower($a->message ?? ''), $needle)
                            || str_contains(mb_strtolower($a->dusun ?? ''), $needle);
                    });
                }

                $collection = $collection->sortByDesc(fn ($a) => $a->created_at ? $a->created_at->timestamp : 0)->values();

                return $this->paginateCollection($collection, $perPage);
            } catch (Throwable $e) {
                Log::warning('Firebase getAspirationsPaginated failed: '.$e->getMessage());
            }
        }

        $dbQuery = Aspiration::latest();
        if ($search) {
            $dbQuery->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('dusun', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $dbQuery->where('status', $status);
        }

        return $dbQuery->paginate($perPage)->withQueryString();
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

        $client = $this->firestore();
        $docId = null;

        if ($client) {
            try {
                $docRef = $client->collection('aspirations')->add($payload);
                $docId = $docRef->id();
            } catch (Throwable $e) {
                Log::warning('Firebase createAspiration error: '.$e->getMessage());
            }
        }

        // Local mirror / fallback
        try {
            $model = Aspiration::create($payload);
            if ($docId) {
                $model->setAttribute('firebase_id', $docId);
            }

            return $model;
        } catch (Throwable) {
            return $this->hydrateAspiration($docId ?? (string) time(), $payload);
        }
    }

    public function updateAspirationStatus(string|int $id, string $status, ?string $notes = null): bool
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $docRef = $client->collection('aspirations')->document((string) $id);
                $snapshot = $docRef->snapshot();
                if ($snapshot->exists()) {
                    $update = ['status' => $status, 'updated_at' => now()->toIso8601String()];
                    if ($notes !== null) {
                        $update['admin_notes'] = $notes;
                    }
                    $docRef->set($update, ['merge' => true]);
                }
            } catch (Throwable $e) {
                Log::warning('Firebase updateAspirationStatus error: '.$e->getMessage());
            }
        }

        $item = Aspiration::find($id);
        if ($item) {
            $item->status = $status;
            if ($notes !== null) {
                $item->admin_notes = $notes;
            }

            return $item->save();
        }

        return true;
    }

    public function findAspirationById(string|int $id): Aspiration
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $doc = $client->collection('aspirations')->document((string) $id)->snapshot();
                if ($doc->exists()) {
                    return $this->hydrateAspiration($doc->id(), $doc->data());
                }
            } catch (Throwable $e) {
                Log::warning('Firebase findAspirationById failed: '.$e->getMessage());
            }
        }

        return Aspiration::findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD METRICS
    |--------------------------------------------------------------------------
    */

    public function getDashboardMetrics(): array
    {
        $client = $this->firestore();

        if ($client) {
            try {
                $approvedUmkmCount = 0;
                $pendingUmkmCount = 0;
                $umkms = [];

                foreach ($client->collection('umkms')->documents() as $doc) {
                    if ($doc->exists()) {
                        $data = $doc->data();
                        $status = $data['status'] ?? 'pending';
                        if ($status === 'approved') {
                            $approvedUmkmCount++;
                        } elseif ($status === 'pending') {
                            $pendingUmkmCount++;
                        }
                        $umkms[] = $this->hydrateUmkm($doc->id(), $data);
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

                $recentUmkms = collect($umkms)
                    ->sortByDesc(fn ($u) => $u->created_at ? $u->created_at->timestamp : 0)
                    ->take(5)
                    ->values();

                return [
                    'approvedUmkmCount' => $approvedUmkmCount,
                    'pendingUmkmCount' => $pendingUmkmCount,
                    'aspirationCount' => $aspirationCount,
                    'newsCount' => $newsCount,
                    'recentUmkms' => $recentUmkms,
                    'source' => 'firebase',
                ];
            } catch (Throwable $e) {
                Log::warning('Firebase getDashboardMetrics failed: '.$e->getMessage());
            }
        }

        return [
            'approvedUmkmCount' => Umkm::approved()->count(),
            'pendingUmkmCount' => Umkm::pending()->count(),
            'aspirationCount' => Aspiration::count(),
            'newsCount' => News::count(),
            'recentUmkms' => Umkm::latest()->take(5)->get(),
            'source' => 'local_database',
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
        $aspiration->id = $id;

        foreach ($data as $key => $value) {
            $aspiration->setAttribute($key, $value);
        }

        if (isset($data['created_at']) && is_string($data['created_at'])) {
            $aspiration->setAttribute('created_at', Carbon::parse($data['created_at']));
        }

        return $aspiration;
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
