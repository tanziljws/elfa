<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('is_active', true)
            ->withCount(['likes as likes_count' => function($query) {
                $query->where('type', 'like');
            }])
            ->withCount(['likes as dislikes_count' => function($query) {
                $query->where('type', 'dislike');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        $categoryNames = [
            'academic' => 'Akademik',
            'extracurricular' => 'Ekstrakurikuler',
            'event' => 'Acara & Event',
            'common' => 'Umum'
        ];

        return view('user.galleries.index', compact('galleries', 'categoryNames'));
    }

    public function myPhotos()
    {
        // For now, show all photos since we don't have user authentication
        // In a real app, this would filter by user_id
        $galleries = Gallery::where('is_active', true)
            ->withCount(['likes as likes_count' => function($query) {
                $query->where('type', 'like');
            }])
            ->withCount(['likes as dislikes_count' => function($query) {
                $query->where('type', 'dislike');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        $categoryNames = [
            'academic' => 'Akademik',
            'extracurricular' => 'Ekstrakurikuler',
            'event' => 'Acara & Event',
            'common' => 'Umum'
        ];

        return view('user.galleries.my', compact('galleries', 'categoryNames'));
    }

    public function create()
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('galleries.index')
                ->with('error', 'Upload foto hanya bisa dilakukan oleh admin');
        }
        
        // Cek apakah fitur upload user diaktifkan
        $enableUserUpload = Setting::get('enable_user_upload', true);
        
        if (!$enableUserUpload) {
            return redirect()->route('galleries.index')
                ->with('error', 'Hanya admin yang bisa mengupload foto');
        }
        
        $categories = [
            'academic' => 'Akademik',
            'extracurricular' => 'Ekstrakurikuler',
            'event' => 'Acara & Event',
            'common' => 'Umum'
        ];

        return view('user.galleries.upload', compact('categories'));
    }

    public function store(Request $request)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('galleries.index')
                ->with('error', 'Upload foto hanya bisa dilakukan oleh admin');
        }
        
        // Cek apakah fitur upload user diaktifkan
        $enableUserUpload = Setting::get('enable_user_upload', true);
        
        if (!$enableUserUpload) {
            return redirect()->route('galleries.index')
                ->with('error', 'Hanya admin yang bisa mengupload foto');
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'category' => 'required|string|in:academic,extracurricular,event,common',
        ], [
            'image.max' => 'Ukuran file gambar tidak boleh lebih dari 5MB.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF.',
            'title.required' => 'Judul foto harus diisi.',
            'title.max' => 'Judul foto tidak boleh lebih dari 255 karakter.',
            'category.required' => 'Kategori harus dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'category' => $request->category,
            'is_active' => true, // Auto-approve for users
        ]);

        return redirect()->route('user.galleries.my')
            ->with('success', 'Foto berhasil diupload!');
    }

    public function category($category)
    {
        Log::info('Category method called with parameter: ' . $category);
        
        // Validasi kategori
        $validCategories = ['academic', 'extracurricular', 'event', 'common'];
        if (!in_array($category, $validCategories)) {
            Log::error('Invalid category parameter: ' . $category);
            return redirect()->route('user.dashboard')
                ->with('error', 'Kategori tidak valid.');
        }
        
        $galleries = Gallery::where('category', $category)
            ->where('is_active', true)
            ->withCount(['likes as likes_count' => function($query) {
                $query->where('type', 'like');
            }])
            ->withCount(['likes as dislikes_count' => function($query) {
                $query->where('type', 'dislike');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        Log::info('Found ' . $galleries->count() . ' galleries for category: ' . $category);
        
        $categoryNames = [
            'academic' => 'Akademik',
            'extracurricular' => 'Ekstrakurikuler',
            'event' => 'Acara & Event',
            'common' => 'Umum'
        ];

        $currentCategory = $categoryNames[$category] ?? $category;
        
        Log::info('Rendering category view for: ' . $currentCategory);
        
        // Tambahkan error handling untuk view
        try {
            return view('user.galleries.category', compact('galleries', 'categoryNames', 'currentCategory', 'category'));
        } catch (\Exception $e) {
            Log::error('Error rendering category view: ' . $e->getMessage());
            return redirect()->route('user.dashboard')
                ->with('error', 'Terjadi kesalahan saat menampilkan kategori.');
        }
    }
}