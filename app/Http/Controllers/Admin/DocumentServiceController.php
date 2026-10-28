<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentServiceController extends Controller
{
    /**
     * Display service requests archive and citizen feedback/aspirations.
     */
    public function index(Request $request): View
    {
        $query = Aspiration::latest();

        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('dusun', 'like', "%{$search}%");
            });
        }

        if ($status = trim((string) $request->input('status', ''))) {
            $query->where('status', $status);
        }

        $aspirations = $query->paginate(15)->withQueryString();
        $totalCount = Aspiration::count();

        return view('admin.services.index', [
            'aspirations' => $aspirations,
            'totalCount' => $totalCount,
            'currentSearch' => $search,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Update the processing status of an aspiration / public request.
     */
    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        $aspiration = Aspiration::findOrFail($id);

        $newStatus = (string) $request->input('status');

        if (! in_array($newStatus, ['pending', 'processed', 'completed'], true)) {
            // Jika status tidak dikirim eksplisit, naikkan status secara berurutan
            $newStatus = match ($aspiration->status) {
                'pending' => 'processed',
                'processed' => 'completed',
                default => 'completed',
            };
        }

        $aspiration->update([
            'status' => $newStatus,
        ]);

        $statusLabel = match ($newStatus) {
            'processed' => 'Sedang Diproses',
            'completed' => 'Selesai Ditindaklanjuti',
            default => 'Menunggu',
        };

        return redirect()->route('admin.services.index')->with('success', "Status aspirasi \"{$aspiration->title}\" berhasil diubah menjadi: {$statusLabel}.");
    }
}
