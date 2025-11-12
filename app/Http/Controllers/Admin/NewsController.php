<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'umum' => 'Umum',
            'prestasi' => 'Prestasi',
            'kegiatan' => 'Kegiatan Sekolah',
            'pengumuman' => 'Pengumuman'
        ];
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Global upload settings
        $maxKb = (int) (Setting::get('upload_max_file_size', 10240) ?? 10240); // Default 10MB
        $allowed = (string) (Setting::get('upload_allowed_extensions', 'jpg,jpeg,png,gif') ?? 'jpg,jpeg,png,gif');
        $allowedMimes = implode(',', array_map('trim', explode(',', $allowed)));

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|in:umum,prestasi,kegiatan,pengumuman',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:' . $allowedMimes . '|max:' . $maxKb,
        ]);

        // Set is_active: true if checkbox is checked, false otherwise
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/news'), $imageName);
            $validated['image'] = 'images/news/' . $imageName;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = [
            'umum' => 'Umum',
            'prestasi' => 'Prestasi',
            'kegiatan' => 'Kegiatan Sekolah',
            'pengumuman' => 'Pengumuman'
        ];
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        // Global upload settings
        $maxKb = (int) (Setting::get('upload_max_file_size', 10240) ?? 10240); // Default 10MB
        $allowed = (string) (Setting::get('upload_allowed_extensions', 'jpg,jpeg,png,gif') ?? 'jpg,jpeg,png,gif');
        $allowedMimes = implode(',', array_map('trim', explode(',', $allowed)));

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|in:umum,prestasi,kegiatan,pengumuman',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:' . $allowedMimes . '|max:' . $maxKb,
        ]);

        // Set is_active: true if checkbox is checked, false otherwise
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/news'), $imageName);
            $validated['image'] = 'images/news/' . $imageName;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Toggle status berita
     */
    public function toggleStatus(News $news)
    {
        $news->update(['is_active' => !$news->is_active]);

        return redirect()->route('admin.news.index')
                        ->with('success', 'Status berita berhasil diubah!');
    }
}
