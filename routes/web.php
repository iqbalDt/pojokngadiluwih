<?php

use App\Http\Controllers\Admin\AiKnowledgeController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentServiceController;
use App\Http\Controllers\Admin\InsightsController;
use App\Http\Controllers\Admin\UmkmApprovalController;
use App\Http\Controllers\Public\ChatbotController;
use App\Http\Controllers\Public\DemographicsController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\UmkmController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Beranda / Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil & Struktur Pemerintahan Desa
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

// Berita & Pengumuman Desa
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

// Sentra & Katalog UMKM (Direct-to-WhatsApp)
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');

// Layanan Warga
Route::prefix('layanan')->name('services.')->group(function (): void {
    // Panduan Permohonan Surat
    Route::get('/panduan', [ServiceController::class, 'guides'])->name('guides');

    // Formulir Pendaftaran Toko UMKM Baru
    Route::get('/daftar-toko', [ServiceController::class, 'storeRegister'])->name('store-register');
    Route::post('/daftar-toko', [ServiceController::class, 'submitStoreRegister'])->name('store-register.submit');

    // Kanal Aspirasi & Pengaduan Warga
    Route::get('/aspirasi', [ServiceController::class, 'feedback'])->name('feedback');
    Route::post('/aspirasi', [ServiceController::class, 'submitFeedback'])->name('feedback.submit');
});

// Visualisasi Demografi & Data Sosial Publik
Route::get('/demografi', [DemographicsController::class, 'index'])->name('demographics');

// API Bridge ke Python AI Service
Route::post('/api/chatbot/message', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Helper untuk Akses Admin)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    // Cari atau buat demo admin jika belum ada untuk kemudahan pengujian
    $user = User::firstOrCreate(
        ['email' => 'admin@ngadiluwih.desa.id'],
        [
            'name' => 'Admin Desa Ngadiluwih',
            'password' => bcrypt('password'),
        ]
    );

    Auth::login($user, (bool) $request->boolean('remember'));

    return redirect()->intended(route('admin.dashboard'));
})->name('login.perform');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (Dilindungi Middleware Auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function (): void {
    // Overview Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CMS Berita & Pengumuman
    Route::prefix('berita')->name('news.')->group(function (): void {
        Route::get('/', [ContentController::class, 'index'])->name('index');
        Route::get('/buat', [ContentController::class, 'create'])->name('create');
        Route::post('/', [ContentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ContentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ContentController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContentController::class, 'destroy'])->name('destroy');
    });

    // Verifikasi Pengajuan Toko UMKM
    Route::prefix('umkm')->name('umkm.')->group(function (): void {
        Route::get('/', [UmkmApprovalController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [UmkmApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [UmkmApprovalController::class, 'reject'])->name('reject');
    });

    // Arsip & Pengelolaan Pengajuan Layanan
    Route::prefix('layanan')->name('services.')->group(function (): void {
        Route::get('/', [DocumentServiceController::class, 'index'])->name('index');
        Route::post('/{id}/status', [DocumentServiceController::class, 'updateStatus'])->name('status');
    });

    // Data Science Insights & Rekomendasi Kebijakan
    Route::get('/insights', [InsightsController::class, 'index'])->name('insights');

    // Manajemen Knowledge Base AI
    Route::prefix('ai-knowledge')->name('ai-knowledge.')->group(function (): void {
        Route::get('/', [AiKnowledgeController::class, 'index'])->name('index');
        Route::post('/', [AiKnowledgeController::class, 'store'])->name('store');
        Route::delete('/{id}', [AiKnowledgeController::class, 'destroy'])->name('destroy');
    });
});
