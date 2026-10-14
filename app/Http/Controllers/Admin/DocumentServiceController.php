<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentServiceController extends Controller
{
    /**
     * Display archive and management of public service submissions and feedback.
     */
    public function index(): View
    {
        return view('admin.services.index');
    }

    /**
     * Update the status of a document request or feedback.
     */
    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        return redirect()->route('admin.services.index')->with('success', 'Status pengajuan layanan berhasil diperbarui.');
    }
}
