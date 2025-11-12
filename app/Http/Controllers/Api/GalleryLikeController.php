<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryLike;
use Illuminate\Http\Request;

class GalleryLikeController extends Controller
{
    public function toggle(Request $request, Gallery $gallery)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu untuk memberikan like/dislike'
            ], 401);
        }

        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        $userId = auth()->id();
        $ipAddress = $request->ip();
        
        // Cek apakah user sudah like/dislike
        $existingLike = GalleryLike::where('gallery_id', $gallery->id)
                                   ->where('user_id', $userId)
                                   ->first();

        if ($existingLike) {
            // Jika type sama, hapus (toggle off)
            if ($existingLike->type === $request->type) {
                $existingLike->delete();
                $action = 'removed';
            } else {
                // Jika type beda, update
                $existingLike->update(['type' => $request->type]);
                $action = 'updated';
            }
        } else {
            // Buat baru
            GalleryLike::create([
                'gallery_id' => $gallery->id,
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'type' => $request->type
            ]);
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'likes_count' => $gallery->likes()->where('type', 'like')->count(),
            'dislikes_count' => $gallery->likes()->where('type', 'dislike')->count()
        ]);
    }

    public function getStatus(Request $request, Gallery $gallery)
    {
        $userLike = null;
        
        // Cek status like hanya jika user sudah login
        if (auth()->check()) {
            $userLike = GalleryLike::where('gallery_id', $gallery->id)
                                   ->where('user_id', auth()->id())
                                   ->first();
        }

        return response()->json([
            'success' => true,
            'user_type' => $userLike ? $userLike->type : null,
            'likes_count' => $gallery->likes()->where('type', 'like')->count(),
            'dislikes_count' => $gallery->likes()->where('type', 'dislike')->count(),
            'is_authenticated' => auth()->check()
        ]);
    }
}
