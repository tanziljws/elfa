<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Cek apakah user sudah melengkapi profil (NISN, nama, dan kelas)
        if (!$user || !$user->student_id || !$user->name || !$user->class) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus melengkapi profil terlebih dahulu (NISN, Nama Lengkap, dan Kelas) untuk menggunakan fitur ini.',
                    'redirect' => route('user.profile')
                ], 403);
            }
            
            return redirect()->route('user.profile')
                ->with('error', 'Anda harus melengkapi profil terlebih dahulu (NISN, Nama Lengkap, dan Kelas) untuk menggunakan fitur ini.');
        }
        
        return $next($request);
    }
}
