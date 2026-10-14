<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UmkmApprovalController extends Controller
{
    /**
     * Display pending and verified UMKM applications.
     */
    public function index(): View
    {
        return view('admin.umkm.index');
    }

    /**
     * Approve an UMKM application.
     */
    public function approve(int|string $id): RedirectResponse
    {
        return redirect()->route('admin.umkm.index')->with('success', 'Pengajuan UMKM berhasil diverifikasi dan disetujui.');
    }

    /**
     * Reject an UMKM application.
     */
    public function reject(int|string $id): RedirectResponse
    {
        return redirect()->route('admin.umkm.index')->with('success', 'Pengajuan UMKM telah ditolak.');
    }
}
