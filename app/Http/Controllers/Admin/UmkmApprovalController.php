<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UmkmApprovalController extends Controller
{
    /**
     * Display pending and verified UMKM applications.
     */
    public function index(): View
    {
        $umkms = Umkm::orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(15);

        $pendingCount = Umkm::pending()->count();

        return view('admin.umkm.index', [
            'umkms' => $umkms,
            'pendingCount' => $pendingCount,
        ]);
    }

    /**
     * Approve an UMKM application to be published in the public catalog.
     */
    public function approve(int|string $id): RedirectResponse
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => 'approved']);

        return redirect()->route('admin.umkm.index')->with('success', "Pengajuan usaha \"{$umkm->name}\" berhasil disetujui dan kini tayang di katalog publik.");
    }

    /**
     * Reject an UMKM application.
     */
    public function reject(int|string $id): RedirectResponse
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => 'rejected']);

        return redirect()->route('admin.umkm.index')->with('success', "Pengajuan usaha \"{$umkm->name}\" telah ditolak.");
    }
}
