<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;

class InsightsController extends Controller
{
    /**
     * Display data insights, real-time aspiration metrics, and policy recommendations.
     */
    public function index(FirebaseService $firebase): View
    {
        return view('admin.insights', [
            'insights' => $firebase->getInsightsSummary(),
        ]);
    }
}
