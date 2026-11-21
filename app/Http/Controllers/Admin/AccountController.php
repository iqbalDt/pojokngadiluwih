<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display the authenticated administrator's profile & password settings page.
     */
    public function index(): View
    {
        return view('admin.account', [
            'admin' => Auth::user(),
        ]);
    }

    /**
     * Update the administrator's display name.
     */
    public function updateProfile(Request $request, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
        ]);

        $user = Auth::user();
        $updated = $firebase->updateAdminProfile((string) $user->getAuthIdentifier(), [
            'name' => $validated['name'],
        ]);

        if (! $updated) {
            return back()->with('error', 'Gagal memperbarui profil akun.');
        }

        return redirect()
            ->route('admin.account.index')
            ->with('success', 'Profil akun berhasil diperbarui.');
    }

    /**
     * Update the administrator's password and clear the temporary-password flag.
     */
    public function updatePassword(Request $request, FirebaseService $firebase): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (! Hash::check($validated['current_password'], (string) $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini tidak sesuai.',
            ]);
        }

        if (Hash::check($validated['password'], (string) $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama.',
            ]);
        }

        $firebase->updateAdminPassword(
            (string) $user->getAuthIdentifier(),
            Hash::make($validated['password']),
            false
        );

        return redirect()
            ->route('admin.account.index')
            ->with('success', 'Kata sandi berhasil diperbarui. Akun Anda sekarang sudah aman digunakan.');
    }
}
