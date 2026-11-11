<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiKnowledgeController extends Controller
{
    /**
     * Display AI knowledge base document management.
     */
    public function index(FirebaseService $firebase): View
    {
        $documents = $firebase->getKnowledgeDocuments();

        return view('admin.ai-knowledge', [
            'documents' => $documents,
        ]);
    }

    /**
     * Store new knowledge item or document.
     */
    public function store(Request $request, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'min:5'],
        ]);

        $firebase->createKnowledgeDocument($validated);

        $this->triggerAiReindex($firebase);

        return redirect()->route('admin.ai-knowledge.index')
            ->with('success', 'Dokumen pengetahuan baru berhasil disimpan ke Firestore dan disinkronkan ke AI.');
    }

    /**
     * Delete a knowledge item.
     */
    public function destroy(string $id, FirebaseService $firebase): RedirectResponse
    {
        $firebase->deleteKnowledgeDocument($id);

        $this->triggerAiReindex($firebase);

        return redirect()->route('admin.ai-knowledge.index')
            ->with('success', 'Dokumen pengetahuan berhasil dihapus dari Firestore.');
    }

    /**
     * Trigger background re-indexing of Python ChromaDB vector store.
     */
    protected function triggerAiReindex(FirebaseService $firebase): void
    {
        $pythonServiceUrl = (string) config('services.ai_service.url', 'http://127.0.0.1:8001/api/chat');
        $reindexUrl = str_replace('/api/chat', '/api/reindex', $pythonServiceUrl);

        try {
            $docs = $firebase->getKnowledgeDocuments()->map(fn ($doc) => [
                'id' => $doc->id,
                'topic' => $doc->topic,
                'category' => $doc->category,
                'content' => $doc->content,
            ])->values()->all();

            Http::timeout(5)->post($reindexUrl, [
                'documents' => $docs,
            ]);
        } catch (Throwable $e) {
            Log::info('Trigger AI reindex postponed: '.$e->getMessage());
        }
    }
}
