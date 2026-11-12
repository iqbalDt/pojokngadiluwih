<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display public news & announcements catalog.
     */
    public function index(Request $request, FirebaseService $firebase): View
    {
        $search = trim((string) $request->input('q', ''));
        $category = trim((string) $request->input('category', ''));

        $news = $firebase->getNewsPaginated(
            $search !== '' ? $search : null,
            $category !== '' ? $category : null,
            9
        );

        return view('public.news.index', [
            'news' => $news,
            'currentSearch' => $search,
            'currentCategory' => $category,
        ]);
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
