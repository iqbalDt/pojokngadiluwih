<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin overview dashboard with live database metrics from Firebase.
     */
    public function index(FirebaseService $firebase): View
    {
        $metrics = $firebase->getDashboardMetrics();

        return view('admin.dashboard', [
            'approvedUmkmCount' => $metrics['approvedUmkmCount'],
            'pendingUmkmCount' => $metrics['pendingUmkmCount'],
            'aspirationCount' => $metrics['aspirationCount'],
            'newsCount' => $metrics['newsCount'],
            'recentUmkms' => $metrics['recentUmkms'],
        ]);
    }
}
