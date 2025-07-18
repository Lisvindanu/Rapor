<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminCreatePengaduan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $selectedRole = session('selected_role');
        
        // Cek jika user adalah admin PPKPT
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            // Redirect ke admin dashboard instead of showing 403
            return redirect()->route('whistleblower.admin.dashboard')
                ->with('info', 'Admin PPKPT tidak dapat membuat pengaduan. Silakan gunakan dashboard admin untuk mengelola pengaduan.');
        }
        
        return $next($request);
    }
}