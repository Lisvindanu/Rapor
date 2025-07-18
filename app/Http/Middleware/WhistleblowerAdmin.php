<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhistleblowerAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil role yang dipilih dari session
        $selectedRole = session('selected_role');
        
        // Jika user belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Jika belum ada role yang dipilih
        if (!$selectedRole) {
            return redirect()->route('gate')->with('error', 'Silakan pilih role terlebih dahulu');
        }
        
        // Cek apakah role yang dipilih adalah admin PPKPT
        $allowedRoles = ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'];
        
        if (!in_array($selectedRole, $allowedRoles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman admin PPKPT.');
        }
        
        return $next($request);
    }
}