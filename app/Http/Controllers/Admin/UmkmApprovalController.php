<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UmkmApprovalController extends Controller
{
    /**
     * Display pending and verified UMKM applications.
     */
    public function index(FirebaseService $firebase): View
    {
        $umkms = $firebase->getAdminUmkmsPaginated(15);
        $metrics = $firebase->getDashboardMetrics();

        return view('admin.umkm.index', [
            'umkms' => $umkms,
            'pendingCount' => $metrics['pendingUmkmCount'],
        ]);
    }

    /**
     * Approve an UMKM application to be published in the public catalog.
     */
    public function approve(int|string $id, FirebaseService $firebase): RedirectResponse
    {
        $firebase->updateUmkmStatus($id, 'approved');

        return redirect()->route('admin.umkm.index')->with('success', 'Pengajuan usaha berhasil disetujui dan kini tayang di katalog publik.');
    }

    /**
     * Reject an UMKM application.
     */
    public function reject(int|string $id, FirebaseService $firebase): RedirectResponse
    {
        $firebase->updateUmkmStatus($id, 'rejected');

        return redirect()->route('admin.umkm.index')->with('success', 'Pengajuan usaha telah ditolak.');
    }
}
