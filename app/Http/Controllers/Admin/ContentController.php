<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of news and announcements for CMS.
     */
    public function index(FirebaseService $firebase): View
    {
        $news = $firebase->getAdminNewsPaginated(15);

        return view('admin.news.index', [
            'news' => $news,
        ]);
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(): View
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created article in Firebase.
     */
    public function store(Request $request, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft,archived'],
        ]);

        $firebase->createNews([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan ke database Firebase.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(int|string $id, FirebaseService $firebase): View
    {
        return view('admin.news.edit', [
            'id' => $id,
        ]);
    }

    /**
     * Update the specified article in Firebase.
     */
    public function update(Request $request, int|string $id, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft,archived'],
        ]);

        $firebase->updateNews($id, $validated);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified article from Firebase.
     */
    public function destroy(int|string $id, FirebaseService $firebase): RedirectResponse
    {
        $firebase->deleteNews($id);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
