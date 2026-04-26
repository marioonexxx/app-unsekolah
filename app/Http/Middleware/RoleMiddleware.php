<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Kadang Laravel mengirim ['1,2'] bukannya ['1', '2']
        // Kita pecah string berdasarkan koma jika perlu
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }

        // Bersihkan spasi dan pastikan perbandingan tipe data aman (string ke string)
        $allowedRoles = array_map('trim', $allowedRoles);

        if (in_array((string)$userRole, $allowedRoles)) {
            return $next($request);
        }

        // Jika gagal, arahkan sesuai dashboard masing-masing
        return match ((string)$userRole) {
            '1' => redirect()->route('admin.dashboard'),
            '2' => redirect()->route('wali.dashboard'),
            '3' => redirect()->route('siswa.dashboard'),
            default => redirect('/'),
        };
    }
}
