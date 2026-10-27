<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Umkm;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16'],
            'whatsapp' => ['required', 'string', 'max:25'],
            'category' => ['required', 'string', 'max:100'],
            'dusun' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            'store_name.required' => 'Nama toko atau usaha wajib diisi.',
            'owner_name.required' => 'Nama pemilik sesuai KTP wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus berjumlah tepat 16 digit.',
            'whatsapp.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'category.required' => 'Silakan pilih kategori produk usaha Anda.',
            'dusun.required' => 'Silakan pilih dusun domisili usaha Anda.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'description.required' => 'Deskripsi usaha dan produk utama wajib diisi.',
        ]);

        // Auto-generate unique slug dari nama toko
        $baseSlug = Str::slug($validated['store_name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Umkm::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        Umkm::create([
            'name' => $validated['store_name'],
            'slug' => $slug,
            'owner_name' => $validated['owner_name'],
            'nik' => $validated['nik'],
            'whatsapp' => $validated['whatsapp'],
            'category' => $validated['category'],
            'dusun' => $validated['dusun'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        return redirect()->route('services.store-register')->with('success', 'Pengajuan pendaftaran toko UMKM Anda berhasil dikirim dan sedang menunggu verifikasi admin desa.');
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'dusun' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'is_anonymous' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon/WhatsApp wajib diisi.',
            'dusun.required' => 'Silakan pilih dusun domisili Anda.',
            'category.required' => 'Silakan pilih kategori aspirasi.',
            'title.required' => 'Judul aspirasi atau laporan wajib diisi.',
            'message.required' => 'Rincian aspirasi atau saran wajib diisi.',
        ]);

        Aspiration::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'dusun' => $validated['dusun'],
            'category' => $validated['category'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'is_anonymous' => (bool) $request->boolean('is_anonymous'),
            'status' => 'pending',
        ]);

        return redirect()->route('services.feedback')->with('success', 'Aspirasi / pengaduan Anda berhasil dikirim ke perangkat desa.');
    }
}
