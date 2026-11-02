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
        $newStatus = (string) $request->input('status');

        if (! in_array($newStatus, ['pending', 'processed', 'completed'], true)) {
            $current = $firebase->findAspirationById($id);
            $newStatus = match ($current->status) {
                'pending' => 'processed',
                'processed' => 'completed',
                default => 'completed',
            };
        }

        $adminNotes = $request->input('admin_notes');
        $firebase->updateAspirationStatus($id, $newStatus, $adminNotes ? (string) $adminNotes : null);

        return redirect()->route('admin.services.index')->with('success', 'Status pengajuan / aspirasi warga berhasil diperbarui.');
    }
}
