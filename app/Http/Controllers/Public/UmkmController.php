<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    /**
     * Display the UMKM business catalog with optional category and search filters.
     */
    public function index(Request $request): View
    {
        $query = Umkm::approved()->latest();

        // Filter pencarian berdasarkan nama produk/usaha, deskripsi, atau dusun
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('dusun', 'like', "%{$search}%");
            });
        }

        // Filter kategori jika dipilih
        if ($category = trim((string) $request->input('category', ''))) {
            $query->where('category', $category);
        }

        $umkms = $query->paginate(12)->withQueryString();

        return view('public.umkm.index', [
            'umkms' => $umkms,
            'currentSearch' => $search,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Display specific UMKM details with Direct-to-WA order option.
     */
    public function show(string $slug): View
    {
        $umkm = Umkm::where('slug', $slug)
            ->approved()
            ->firstOrFail();

        return view('public.umkm.show', [
            'umkm' => $umkm,
        ]);
    }
}
