<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class InsightsController extends Controller
{
    /**
     * Display data science insights, reports, and policy recommendations.
     */
    public function index(): View
    {
        return view('admin.insights');
    }
}
