<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentServiceController extends Controller
{
    /**
     * Display service requests archive and citizen feedback/aspirations.
     */
    public function index(Request $request, FirebaseService $firebase): View
    {
        $search = trim((string) $request->input('q', ''));
        $status = trim((string) $request->input('status', ''));

        $aspirations = $firebase->getAspirationsPaginated(
            $search !== '' ? $search : null,
            $status !== '' ? $status : null,
            15
        );

        $metrics = $firebase->getDashboardMetrics();

        return view('admin.services.index', [
            'aspirations' => $aspirations,
            'totalCount' => $metrics['aspirationCount'],
            'currentSearch' => $search,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Update the processing status of an aspiration / public request.
     */
    public function updateStatus(Request $request, int|string $id, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,processed,completed'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        abort_unless($firebase->updateAspirationStatus($id, $validated['status'], $validated['admin_notes'] ?? null), 404);

        return redirect()->route('admin.services.index')->with('success', 'Status pengajuan / aspirasi warga berhasil diperbarui.');
    }
}
