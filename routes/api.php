<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\GalleryLikeController;
use App\Http\Controllers\Api\GalleryCommentController;
use App\Http\Controllers\Api\GalleryDownloadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Gallery API Routes - menggunakan web middleware untuk session auth
Route::middleware('web')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index']);
    Route::get('/galleries/categories', [GalleryController::class, 'categories']);
    Route::get('/galleries/{id}', [GalleryController::class, 'show']);
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::put('/galleries/{id}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);

    // Like/Dislike Routes (Require Authentication & Complete Profile)
    Route::middleware(['auth', 'profile.complete'])->group(function () {
        Route::post('/galleries/{gallery}/like', [GalleryLikeController::class, 'toggle']);
    });
    Route::get('/galleries/{gallery}/like-status', [GalleryLikeController::class, 'getStatus']);

    // Comment Routes (Require Complete Profile for posting)
    Route::get('/galleries/{gallery}/comments', [GalleryCommentController::class, 'index']);
    Route::middleware(['auth', 'profile.complete'])->group(function () {
        Route::post('/galleries/{gallery}/comments', [GalleryCommentController::class, 'store']);
    });

    // Download Routes (Require Complete Profile)
    Route::middleware(['auth', 'profile.complete'])->group(function () {
        Route::post('/galleries/{gallery}/download', [GalleryDownloadController::class, 'download']);
    });
});
