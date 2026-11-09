<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
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
     * Handle submission of UMKM store registration to Firebase.
     */
    public function submitStoreRegister(Request $request, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'regex:/\A[0-9]{16}\z/'],
            'whatsapp' => ['required', 'string', 'max:25', 'regex:/\A\+?(?=(?:[0-9][\s-]*){8,25}\z)[0-9][0-9\s-]*\z/'],
            'category' => ['required', 'string', 'in:Kuliner & Camilan,Pertanian & Hasil Alam,Kerajinan Tangan,Jasa & Servis Lokal'],
            'dusun' => ['required', 'string', 'in:Krajan,Wonorejo,Sukorejo,Karangrejo'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'store_name.required' => 'Nama toko atau usaha wajib diisi.',
            'owner_name.required' => 'Nama pemilik sesuai KTP wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.regex' => 'NIK harus terdiri dari tepat 16 angka.',
            'whatsapp.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'whatsapp.regex' => 'Nomor WhatsApp harus berisi 8 sampai 25 angka; tanda +, spasi, dan tanda hubung diperbolehkan.',
            'category.required' => 'Silakan pilih kategori produk usaha Anda.',
            'category.in' => 'Kategori produk yang dipilih tidak valid.',
            'dusun.required' => 'Silakan pilih dusun domisili usaha Anda.',
            'dusun.in' => 'Dusun yang dipilih tidak valid.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'description.required' => 'Deskripsi usaha dan produk utama wajib diisi.',
            'description.max' => 'Deskripsi usaha maksimal 10.000 karakter.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $payload = [
            'store_name' => $validated['store_name'],
            'owner_name' => $validated['owner_name'],
            'nik' => $validated['nik'],
            'whatsapp' => $validated['whatsapp'],
            'category' => $validated['category'],
            'dusun' => $validated['dusun'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'status' => 'pending',
        ];

        if ($request->hasFile('image')) {
            $payload['image_path'] = $request->file('image')->store('news', 'public');
        }

        $firebase->createUmkm($payload);

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
     * Handle submission of public feedback or aspiration to Firebase.
     */
    public function submitFeedback(Request $request, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25', 'regex:/\A\+?(?=(?:[0-9][\s-]*){8,25}\z)[0-9][0-9\s-]*\z/'],
            'dusun' => ['required', 'string', 'in:Krajan,Wonorejo,Sukorejo,Karangrejo'],
            'category' => ['required', 'string', 'in:Infrastruktur & Jalan,Irigasi & Pertanian,Kebersihan & Lingkungan,Pelayanan Administrasi,Keamanan & Ketertiban,Lainnya'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
            'is_anonymous' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon/WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor telepon/WhatsApp harus berisi 8 sampai 25 angka; tanda +, spasi, dan tanda hubung diperbolehkan.',
            'dusun.required' => 'Silakan pilih dusun domisili Anda.',
            'dusun.in' => 'Dusun yang dipilih tidak valid.',
            'category.required' => 'Silakan pilih kategori aspirasi.',
            'category.in' => 'Kategori aspirasi yang dipilih tidak valid.',
            'title.required' => 'Judul aspirasi atau laporan wajib diisi.',
            'message.required' => 'Rincian aspirasi atau saran wajib diisi.',
            'message.max' => 'Rincian aspirasi maksimal 10.000 karakter.',
            'is_anonymous.boolean' => 'Pilihan kerahasiaan identitas tidak valid.',
        ]);

        $firebase->createAspiration([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'dusun' => $validated['dusun'],
            'category' => $validated['category'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
        ]);

        return redirect()->route('services.feedback')->with('success', 'Aspirasi / pengaduan Anda berhasil dikirim ke perangkat desa.');
    }
}
