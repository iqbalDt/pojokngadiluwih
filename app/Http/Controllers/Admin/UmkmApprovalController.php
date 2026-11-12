<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class UmkmApprovalController extends Controller
{
    /**
     * Display UMKM list filtered by status (default: pending).
     */
    public function index(Request $request, FirebaseService $firebase): View
    {
        $status = $request->query('status', 'pending');
        $umkms = $firebase->getAdminUmkmsPaginated(15, $status);
        $metrics = $firebase->getDashboardMetrics();

        return view('admin.umkm.index', [
            'umkms' => $umkms,
            'currentStatus' => $status,
            'pendingCount' => $metrics['pendingUmkmCount'] ?? 0,
            'approvedCount' => $metrics['approvedUmkmCount'] ?? 0,
        ]);
    }

    /**
     * Show form for editing an UMKM.
     */
    public function edit(int|string $id, FirebaseService $firebase): View
    {
        $umkm = $firebase->findUmkmById($id);

        return view('admin.umkm.edit', [
            'umkm' => $umkm,
        ]);
    }

    /**
     * Update an UMKM data and optionally upload product image.
     */
    public function update(Request $request, int|string $id, FirebaseService $firebase, CloudinaryService $cloudinary): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:25'],
            'category' => ['required', 'string'],
            'dusun' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_unit' => ['nullable', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'products' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            try {
                $existing = $firebase->findUmkmById($id);
                if ($existing->image_path) {
                    $cloudinary->delete($existing->image_path);
                }
            } catch (Throwable) {
                // Ignore if cannot be deleted
            }

            $validated['image_path'] = $cloudinary->upload($request->file('image'), 'umkms');
        }
        unset($validated['image']);

        abort_unless($firebase->updateUmkm($id, $validated), 404);

        return redirect()->route('admin.umkm.index', ['status' => $validated['status']])
            ->with('success', "Data toko \"{$validated['name']}\" berhasil diperbarui.");
    }

    /**
     * Delete an UMKM from Firestore.
     */
    public function destroy(int|string $id, FirebaseService $firebase, CloudinaryService $cloudinary): RedirectResponse
    {
        try {
            $existing = $firebase->findUmkmById($id);
            if ($existing->image_path) {
                $cloudinary->delete($existing->image_path);
            }
        } catch (Throwable) {
            // Ignore if cannot be deleted
        }

        abort_unless($firebase->deleteUmkm($id), 404);

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    /**
     * Approve an UMKM application to be published in the public catalog.
     */
    public function approve(int|string $id, FirebaseService $firebase): RedirectResponse
    {
        abort_unless($firebase->updateUmkmStatus($id, 'approved'), 404);

        return redirect()->route('admin.umkm.index')->with('success', 'Pengajuan usaha berhasil disetujui dan kini tayang di katalog publik.');
    }

    /**
     * Reject an UMKM application.
     */
    public function reject(int|string $id, FirebaseService $firebase): RedirectResponse
    {
        abort_unless($firebase->updateUmkmStatus($id, 'rejected'), 404);

        return redirect()->route('admin.umkm.index')->with('success', 'Pengajuan usaha telah ditolak.');
    }
}
