<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Kontroller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\ContactPageController;

// Kontroller User
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\GalleryController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Auth\RegisterController;

// =========================
// Rute Halaman Depan (Publik)
// =========================

// Halaman Utama
Route::get('/', function () {
    return view('gallery.index');
})->name('home');

// Rute Publik (Tidak Perlu Login)
Route::get('/tentang', [AboutController::class, 'index'])->name('tentang');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
// Berita Publik
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news', [NewsController::class, 'index'])->name('berita');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('berita.show');

// Rute User (Perlu Login)
Route::prefix('user')->name('user.')->group(function() {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Berita
    Route::get('/berita', [NewsController::class, 'index'])->name('news');
    Route::get('/berita/{id}', [NewsController::class, 'show'])->name('news.show');
    
    // Galeri
    Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
    Route::get('/galeri/kategori/{category}', [GalleryController::class, 'category'])->name('galeri.kategori');
});

// Alias untuk kompatibilitas
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/category/{category}', [GalleryController::class, 'category'])->name('galleries.category');

// =========================
// Admin Authentication
// =========================
// Alias login umum -> halaman login admin
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// =========================
// User Authentication (Sederhana)
// =========================
Route::get('/user/login', function () {
    return view('auth.user-login');
})->name('user.login');

Route::post('/user/login', function (Request $request) {
    // Simulasi login user sederhana
    $name = $request->input('username', 'Pengguna');
    session(['user_name' => $name]);
    return redirect()->route('user.dashboard');
})->name('user.login.submit');

Route::get('/user/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register.submit');

Route::post('/user/logout', function () {
    session()->forget('user_name');
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('home');
})->name('user.logout');

Route::get('/admin/login', function () {
    return view('auth.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // Login sederhana (sementara)
    if ($username === 'admin' && $password === 'admin123') {
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['username' => 'Username atau password salah.']);
})->name('admin.login.submit');

// =========================
// Admin Routes (Lindungi dengan middleware auth nanti)
// =========================
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alt');
    
    // Gallery Management
    Route::resource('galleries', AdminGalleryController::class);
    Route::patch('/galleries/{gallery}/toggle-status', [AdminGalleryController::class, 'toggleStatus'])->name('galleries.toggle-status');
    Route::get('/galleries/category/{category}', [AdminGalleryController::class, 'category'])->name('galleries.category');
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    Route::patch('/news/{news}/toggle-status', [AdminNewsController::class, 'toggleStatus'])->name('news.toggle-status');
    
    // Reports
    Route::get('/reports/gallery', [ReportController::class, 'gallery'])->name('reports.gallery');
    Route::get('/reports/gallery/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.gallery.export-pdf');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    
    // About Page Management
    Route::get('/about/edit', [AboutPageController::class, 'edit'])->name('about.edit');
    Route::put('/about/update', [AboutPageController::class, 'update'])->name('about.update');
    
    // Contact Page Management
    Route::get('/contact/edit', [ContactPageController::class, 'edit'])->name('contact.edit');
    Route::put('/contact/update', [ContactPageController::class, 'update'])->name('contact.update');

    // Logout
    Route::post('/logout', function () {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');
});
