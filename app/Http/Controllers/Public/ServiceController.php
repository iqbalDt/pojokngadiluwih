<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display guides for public document requests / administrative letters.
     */
    public function guides(): View
    {
        return view('public.services.guides');
    }

    /**
     * Display registration form for new UMKM store.
     */
    public function storeRegister(): View
    {
        return view('public.services.store-register');
    }

    /**
     * Handle submission of UMKM store registration.
     */
    public function submitStoreRegister(Request $request): RedirectResponse
    {
        return redirect()->route('services.store-register')->with('success', 'Pengajuan pendaftaran toko UMKM Anda berhasil dikirim dan sedang menunggu verifikasi.');
    }

    /**
     * Display public feedback and aspiration form.
     */
    public function feedback(): View
    {
        return view('public.services.feedback');
    }

    /**
     * Handle submission of public feedback or aspiration.
     */
    public function submitFeedback(Request $request): RedirectResponse
    {
        return redirect()->route('services.feedback')->with('success', 'Aspirasi / pengaduan Anda berhasil dikirim ke perangkat desa.');
    }
}
