<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        // Ambil berita yang statusnya 'published', diurutkan dari yang terbaru, 9 per halaman
        $news = News::where('status', 'published')->latest('published_at')->paginate(9);
        
        return view('public.news.index', compact('news'));
    }

    public function show($slug)
    {
        // Cari berita berdasarkan slug, kalau tidak ketemu akan metampilkan error 404
        $news = News::where('slug', $slug)->firstOrFail();
        
        return view('public.news.show', compact('news'));
    }
}