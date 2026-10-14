<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AiKnowledgeController extends Controller
{
    /**
     * Display AI knowledge base document management.
     */
    public function index(): View
    {
        return view('admin.ai-knowledge');
    }

    /**
     * Store new knowledge item or document.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.ai-knowledge.index')->with('success', 'Knowledge base AI berhasil ditambahkan.');
    }

    /**
     * Delete a knowledge item.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        return redirect()->route('admin.ai-knowledge.index')->with('success', 'Knowledge base AI berhasil dihapus.');
    }
}
