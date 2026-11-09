<?php

namespace App\Services;

use App\Models\Aspiration;
use App\Models\News;
use App\Models\Umkm;
use App\Models\User;
use Carbon\Carbon;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
    }

    /*
    |--------------------------------------------------------------------------
    | NEWS MODULE
    |--------------------------------------------------------------------------
    */

    public function getNewsPaginated(int $perPage = 9): LengthAwarePaginator
    {
        $docs = $this->firestoreOrFail()->collection('news')
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
        $docs = $this->firestoreOrFail()->collection('news')->documents();
        $items = [];
        foreach ($docs as $doc) {
            if ($doc->exists()) {
                $items[] = $this->hydrateNews($doc->id(), $doc->data());
            }
        }

        $collection = collect($items)->sortByDesc(fn ($n) => $n->created_at ? $n->created_at->timestamp : 0)->values();

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

        return true;
    }

    public function deleteNews(string|int $id): bool
    {
        $docRef = $this->firestoreOrFail()->collection('news')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        $docRef->delete();

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | UMKM MODULE
    |--------------------------------------------------------------------------
    */

    public function getApprovedUmkmsPaginated(?string $search = null, ?string $category = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->firestoreOrFail()->collection('umkms')->where('status', '=', 'approved');

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
            $collection = $collection->filter(function ($umkm) use ($needle) {
                return str_contains(mb_strtolower($umkm->name ?? ''), $needle)
                    || str_contains(mb_strtolower($umkm->description ?? ''), $needle)
                    || str_contains(mb_strtolower($umkm->dusun ?? ''), $needle);
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
        $collectionRef = $this->firestoreOrFail()->collection('umkms');

        if ($status && $status !== 'all') {
            $docs = $collectionRef->where('status', '=', $status)->documents();
        } else {
            $docs = $collectionRef->documents();
        }

        $items = [];
        foreach ($docs as $doc) {
            if ($doc->exists()) {
                $items[] = $this->hydrateUmkm($doc->id(), $doc->data());
            }
        }

        $collection = collect($items)
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

        $docRef = $client->collection('umkms')->add($payload);

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

        $data['updated_at'] = now()->toIso8601String();
        $docRef->set($data, ['merge' => true]);

        return true;
    }

    public function deleteUmkm(string|int $id): bool
    {
        $docRef = $this->firestoreOrFail()->collection('umkms')->document((string) $id);
        if (! $docRef->snapshot()->exists()) {
            return false;
        }

        $docRef->delete();

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | ASPIRATION MODULE
    |--------------------------------------------------------------------------
    */

    public function getAspirationsPaginated(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->firestoreOrFail()->collection('aspirations');
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
            ->sortByDesc(fn ($umkm) => $umkm->created_at ? $umkm->created_at->timestamp : 0)
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
    public function findAdminByEmail(string $email): ?User
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
     * Create or update administrator in Firestore (and sync locally if possible).
     */
    public function saveAdmin(array $data): User
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
    public function authenticateAdmin(string $email, string $password): ?User
    {
        $admin = $this->findAdminByEmail($email);

        if (! $admin) {
            return null;
        }

        if (! Hash::check($password, $admin->password)) {
            return null;
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

    protected function hydrateAdmin(string $id, array $data): User
    {
        $admin = new User;
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
