<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Inisialisasi data default
            $data = [
                'totalGalleries' => 0,
                'totalNews' => 0,
                'unreadMessages' => 0,
                'recentActivity' => 0,
                'recentGalleries' => collect(),
                'galleryCategories' => [
                    ['name' => 'Akademik', 'count' => 0, 'color' => '#4e73df', 'key' => 'academic'],
                    ['name' => 'Ekstrakurikuler', 'count' => 0, 'color' => '#1cc88a', 'key' => 'extracurricular'],
                    ['name' => 'Acara & Event', 'count' => 0, 'color' => '#36b9cc', 'key' => 'event'],
                    ['name' => 'Umum', 'count' => 0, 'color' => '#f6c23e', 'key' => 'common']
                ],
                'latestNews' => collect()
            ];

            // Ambil data dari database
            try {
                // Total Galeri
                $data['totalGalleries'] = Gallery::where('is_active', true)->count();
                
                // Total Berita
                $data['totalNews'] = News::where('is_active', true)->count();
                
                // Pesan Belum Dibaca (belum ada model Message, set 0)
                $data['unreadMessages'] = 0;
                
                // Aktivitas Terbaru (dalam 7 hari terakhir)
                $data['recentActivity'] = Gallery::where('created_at', '>=', now()->subDays(7))->count();
                
                // Galeri Terbaru
                $data['recentGalleries'] = Gallery::where('is_active', true)
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
                
                // Hitung jumlah galeri per kategori
                $categories = ['academic', 'extracurricular', 'event', 'common'];
                foreach ($categories as $index => $category) {
                    $data['galleryCategories'][$index]['count'] = Gallery::where('category', $category)
                        ->where('is_active', true)
                        ->count();
                }
                
                // Berita Terbaru
                $data['latestNews'] = News::where('is_active', true)
                    ->orderBy('published_at', 'desc')
                    ->take(5)
                    ->get();
                
                Log::info('Data dashboard berhasil diambil');
                    
            } catch (\Exception $e) {
                Log::error('Gagal mengambil data dashboard: ' . $e->getMessage());
                // Tetap lanjut dengan data default jika terjadi error
            }
            
            return view('user.dashboard', $data);
            
        } catch (\Exception $e) {
            Log::error('Error pada DashboardController@index: ' . $e->getMessage());
            // Redirect ke halaman error atau tampilkan pesan error yang ramah
            return back()->with('error', 'Terjadi kesalahan saat memuat dashboard. Silakan coba lagi nanti.');
        }
    }
}
