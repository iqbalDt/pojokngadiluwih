<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\News;
use App\Models\Umkm;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin overview dashboard with live database metrics.
     */
    public function index(): View
    {
        $approvedUmkmCount = Umkm::approved()->count();
        $pendingUmkmCount = Umkm::pending()->count();
        $aspirationCount = Aspiration::count();
        $newsCount = News::count();

        // Ambil 5 pengajuan UMKM terbaru untuk ditinjau admin
        $recentUmkms = Umkm::latest()->take(5)->get();

        return view('admin.dashboard', [
            'approvedUmkmCount' => $approvedUmkmCount,
            'pendingUmkmCount' => $pendingUmkmCount,
            'aspirationCount' => $aspirationCount,
            'newsCount' => $newsCount,
            'recentUmkms' => $recentUmkms,
        ]);
    }
}
