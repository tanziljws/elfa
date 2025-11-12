<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryComment;
use Illuminate\Http\Request;

class GalleryCommentController extends Controller
{
    public function index(Gallery $gallery)
    {
        $comments = $gallery->comments()
                           ->with('user:id,name,profile_photo')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    public function store(Request $request, Gallery $gallery)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu untuk menambahkan komentar'
            ], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = GalleryComment::create([
            'gallery_id' => $gallery->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'ip_address' => $request->ip()
        ]);

        $comment->load('user:id,name,profile_photo');

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'data' => $comment
        ]);
    }
}
