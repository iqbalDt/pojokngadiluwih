<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class UmkmController extends Controller
{
    /**
     * Display the UMKM business catalog.
     */
    public function index(): View
    {
        return view('public.umkm.index');
    }

    /**
     * Display specific UMKM details with Direct-to-WA order option.
     */
    public function show(string $slug): View
    {
        return view('public.umkm.show', [
            'slug' => $slug,
        ]);
    }
}
