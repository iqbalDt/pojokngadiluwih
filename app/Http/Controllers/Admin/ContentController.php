<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of news and announcements for CMS.
     */
    public function index(): View
    {
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(): View
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(int|string $id): View
    {
        return view('admin.news.edit', [
            'id' => $id,
        ]);
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
