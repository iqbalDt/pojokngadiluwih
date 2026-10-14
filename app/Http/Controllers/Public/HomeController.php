<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function index(): View
    {
        return view('public.home');
    }
}
