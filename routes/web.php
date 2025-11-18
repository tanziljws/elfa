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
use App\Http\Controllers\Admin\Auth\AdminAuthController;

// Kontroller User
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\GalleryController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\RegisterController;

// =========================
// Rute Halaman Depan (Publik)
// =========================

// Serve storage files (for Railway PHP built-in server)
// This route must be before any middleware that might block it
Route::get('/storage/{path}', function ($path) {
    // Sanitize path to prevent directory traversal
    $path = str_replace('..', '', $path);
    $path = ltrim($path, '/');
    
    $filePath = storage_path('app/public/' . $path);
    
    // Check if file exists and is readable
    if (!file_exists($filePath) || !is_file($filePath) || !is_readable($filePath)) {
        abort(404, 'File not found');
    }
    
    // Get MIME type
    $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
    
    // Return file with proper headers
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.serve')->middleware('web');

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

// Rute User (Dashboard publik, yang lain perlu login)
Route::prefix('user')->name('user.')->group(function() {
    // Dashboard - Bisa diakses tanpa login
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Berita - Publik
    Route::get('/berita', [NewsController::class, 'index'])->name('news');
    Route::get('/berita/{id}', [NewsController::class, 'show'])->name('news.show');
    
    // Galeri - Publik
    Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
    Route::get('/galeri/kategori/{category}', [GalleryController::class, 'category'])->name('galeri.kategori');
});

// Alias untuk kompatibilitas
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/category/{category}', [GalleryController::class, 'category'])->name('galleries.category');

// Route debugging untuk kategori galeri
Route::get('/debug/category/{category}', function($category) {
    try {
        $controller = new \App\Http\Controllers\User\GalleryController();
        return $controller->category($category);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Route debugging untuk melihat data kategori
Route::get('/debug/categories', function() {
    $categories = [
        'academic' => 'Akademik',
        'extracurricular' => 'Ekstrakurikuler',
        'event' => 'Acara & Event',
        'common' => 'Umum'
    ];
    
    return response()->json($categories);
});

// =========================
// Admin Authentication
// =========================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// =========================
// User Authentication
// =========================

// Guest routes (belum login)
Route::middleware('guest')->group(function() {
    // Default /login route untuk user
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    
    Route::get('/user/login', [AuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/user/login', [AuthController::class, 'login'])->name('user.login.submit');
    Route::get('/user/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register.submit');
});

// Authenticated user routes - menggunakan GET untuk logout agar tidak ada masalah CSRF
Route::middleware(['auth', 'web'])->group(function() {
    // Ganti POST menjadi GET untuk logout
    Route::get('/user/logout', [AuthController::class, 'logout'])->name('user.logout');
    
    // Profile routes
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    
    // Gallery upload routes (POST route still requires auth)
    Route::post('/user/galleries', [GalleryController::class, 'store'])->name('user.galleries.store');
    Route::get('/user/galleries/my', [GalleryController::class, 'myPhotos'])->name('user.galleries.my');
});

// Gallery upload route without auth middleware to show proper warning
Route::get('/user/galleries/upload', [GalleryController::class, 'create'])->name('user.galleries.upload');


// =========================
// Admin Routes (Lindungi dengan middleware auth nanti)
// =========================
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect root admin ke login jika belum login, atau ke dashboard jika sudah login
    Route::get('/', function () {
        // Cek apakah sudah login (ini adalah pengecekan sederhana untuk contoh)
        // Dalam implementasi sebenarnya, Anda akan menggunakan middleware auth
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    })->name('index');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gallery Management
    Route::resource('galleries', AdminGalleryController::class);
    Route::patch('/galleries/{gallery}/toggle-status', [AdminGalleryController::class, 'toggleStatus'])->name('galleries.toggle-status');
    Route::get('/galleries/category/{category}', [AdminGalleryController::class, 'category'])->name('galleries.category');
    Route::delete('/galleries/comments/{comment}', [AdminGalleryController::class, 'deleteComment'])->name('galleries.comments.delete');
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    Route::patch('/news/{news}/toggle-status', [AdminNewsController::class, 'toggleStatus'])->name('news.toggle-status');
    
    // Reports
    Route::get('/reports/gallery', [ReportController::class, 'gallery'])->name('reports.gallery');
    Route::get('/reports/gallery/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.gallery.export-pdf');
    
    // Notifications
    Route::get('/notifications', [AdminGalleryController::class, 'notifications'])->name('notifications.index');
    
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
});

// Admin Logout Route - menggunakan GET
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');