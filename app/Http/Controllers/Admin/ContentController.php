<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
            'published_at' => ['required', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $payload = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'],
            'author_id' => $request->user()?->getAuthIdentifier() ?? 1,
        ];

        if ($request->hasFile('image')) {
            $payload['image_path'] = $request->file('image')->store('news', 'public');
        }

        $firebase->createNews($payload);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan ke database Firebase.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(int|string $id, FirebaseService $firebase): View
    {
        $news = $firebase->findNewsById($id);

        return view('admin.news.edit', [
            'news' => $news,
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
            'published_at' => ['required', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            try {
                $existingNews = $firebase->findNewsById($id);
                if ($existingNews->image_path && Storage::disk('public')->exists($existingNews->image_path)) {
                    Storage::disk('public')->delete($existingNews->image_path);
                }
            } catch (Throwable) {
                // Ignore if existing file cannot be deleted
            }

            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }
        unset($validated['image']);

        abort_unless($firebase->updateNews($id, $validated), 404);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified article from Firebase.
     */
    public function destroy(int|string $id, FirebaseService $firebase): RedirectResponse
    {
        try {
            $existingNews = $firebase->findNewsById($id);
            if ($existingNews->image_path && Storage::disk('public')->exists($existingNews->image_path)) {
                Storage::disk('public')->delete($existingNews->image_path);
            }
        } catch (Throwable) {
            // Ignore if existing file cannot be found/deleted
        }

        abort_unless($firebase->deleteNews($id), 404);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
