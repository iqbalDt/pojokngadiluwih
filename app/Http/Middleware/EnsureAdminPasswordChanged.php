<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPasswordChanged
{
    /**
     * Redirect administrators using a temporary password to the account security page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && (bool) ($user->must_change_password ?? false)) {
            if (! $request->routeIs('admin.account.*', 'logout')) {
                return redirect()
                    ->route('admin.account.index')
                    ->with('warning', 'Demi keamanan, silakan ganti kata sandi sementara Anda terlebih dahulu sebelum mengakses menu lain.');
            }
        }

        return $next($request);
    }
}
