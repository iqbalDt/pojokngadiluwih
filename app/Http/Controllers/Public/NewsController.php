<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    /**
     * Display a listing of news and announcements.
     */
    public function index(): View
    {
        return view('public.news.index');
    }

    /**
     * Display the specified news article.
     */
    public function show(string $slug): View
    {
        return view('public.news.show', [
            'slug' => $slug,
        ]);
    }
}
