<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of news
     */
    public function index(Request $request)
    {
        // Mengganti scope published() dengan filter hanya berdasarkan is_active
        $query = News::where('is_active', true);
        
        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        $news = $query->paginate(9);
        
        $categories = [
            'umum' => 'Umum',
            'prestasi' => 'Prestasi',
            'kegiatan' => 'Kegiatan Sekolah',
            'pengumuman' => 'Pengumuman'
        ];
        
        return view('user.news.index', compact('news', 'categories'));
    }

    /**
     * Display the specified news
     */
    public function show($id)
    {
        $news = News::where('is_active', true)->findOrFail($id);
        
        // Get related news (same category, exclude current)
        $relatedNews = News::where('is_active', true)
            ->where('category', $news->category)
            ->where('id', '!=', $news->id)
            ->limit(3)
            ->get();
        
        // Get latest news
        $latestNews = News::where('is_active', true)
            ->where('id', '!=', $news->id)
            ->limit(5)
            ->get();
        
        return view('user.news.show', compact('news', 'relatedNews', 'latestNews'));
    }
    
    /**
     * Display news by category
     */
    public function category($category)
    {
        $news = News::where('is_active', true)
            ->where('category', $category)
            ->paginate(9);
        
        $categories = [
            'umum' => 'Umum',
            'prestasi' => 'Prestasi',
            'kegiatan' => 'Kegiatan Sekolah',
            'pengumuman' => 'Pengumuman'
        ];
        
        $categoryName = $categories[$category] ?? ucfirst($category);
        
        return view('user.news.category', compact('news', 'categories', 'category', 'categoryName'));
    }
}