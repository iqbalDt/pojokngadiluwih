<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    /**
     * Display public news & announcements catalog.
     */
    public function index(FirebaseService $firebase): View
    {
        $news = $firebase->getNewsPaginated(9);

        return view('public.news.index', compact('news'));
    }

    /**
     * Display single news article details by slug.
     */
    public function show(string $slug, FirebaseService $firebase): View
    {
        $news = $firebase->findNewsBySlug($slug);

        return view('public.news.show', compact('news'));
    }
}
