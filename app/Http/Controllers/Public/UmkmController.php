<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    /**
     * Display the UMKM business catalog with optional category and search filters.
     */
    public function index(Request $request, FirebaseService $firebase): View
    {
        $search = trim((string) $request->input('q', ''));
        $category = trim((string) $request->input('category', ''));

        $umkms = $firebase->getApprovedUmkmsPaginated(
            $search !== '' ? $search : null,
            $category !== '' ? $category : null,
            12
        );

        return view('public.umkm.index', [
            'umkms' => $umkms,
            'currentSearch' => $search,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Display specific UMKM details with Direct-to-WA order option.
     */
    public function show(string $slug, FirebaseService $firebase): View
    {
        $umkm = $firebase->findUmkmBySlug($slug);

        return view('public.umkm.show', [
            'umkm' => $umkm,
        ]);
    }
}
