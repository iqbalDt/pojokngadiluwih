<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    /**
     * Display village profile and organizational structure.
     */
    public function index(): View
    {
        return view('public.profile');
    }
}
