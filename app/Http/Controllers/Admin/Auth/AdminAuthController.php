<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle admin login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Login sederhana (sementara)
        if ($username === 'admin' && $password === 'admin123') {
            // Simpan session login admin
            session(['admin_logged_in' => true]);
            
            // Tidak perlu regenerate session untuk mencegah page expired
            // Langsung redirect ke dashboard
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang di dashboard admin!');
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])
            ->withInput($request->only('username'));
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        // Hapus session admin login
        session()->forget('admin_logged_in');
        
        // Tidak perlu invalidate session untuk mencegah page expired
        // Langsung redirect ke login
        
        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}