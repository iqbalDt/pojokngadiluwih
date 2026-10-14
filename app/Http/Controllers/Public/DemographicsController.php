<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DemographicsController extends Controller
{
    /**
     * Display public demographic and social data visualization.
     */
    public function index(): View
    {
        return view('public.demographics');
    }
}
