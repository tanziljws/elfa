<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Backup data yang ada (jika ada)
        $existingLikes = \DB::table('gallery_likes')->get();
        
        // Drop dan recreate tabel dengan struktur baru
        Schema::dropIfExists('gallery_likes');
        
        Schema::create('gallery_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address');
            $table->enum('type', ['like', 'dislike']);
            $table->timestamps();
            
            // Satu user hanya bisa like/dislike sekali per foto
            $table->unique(['gallery_id', 'user_id']);
        });
        
        // Note: Data lama tidak di-restore karena tidak ada user_id
        // User perlu like/dislike ulang setelah login
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop dan recreate dengan struktur lama
        Schema::dropIfExists('gallery_likes');
        
        Schema::create('gallery_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
            $table->string('ip_address');
            $table->enum('type', ['like', 'dislike']);
            $table->timestamps();
            
            // Satu IP hanya bisa like/dislike sekali per foto
            $table->unique(['gallery_id', 'ip_address']);
        });
    }
};
