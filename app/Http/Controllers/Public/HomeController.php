<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Umkm;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 1. Ambil 3 berita terbaru yang statusnya 'published'
        $latestNews = News::where('status', 'published')
                          ->latest('published_at')
                          ->take(3)
                          ->get();

        // 2. Ambil 4 UMKM unggulan yang statusnya 'approved'
        $featuredUmkm = Umkm::approved()
                            ->latest()
                            ->take(4)
                            ->get();

        // 3. Kirim data ke view public/home.blade.php
        return view('public.home', compact('latestNews', 'featuredUmkm'));
    }
}