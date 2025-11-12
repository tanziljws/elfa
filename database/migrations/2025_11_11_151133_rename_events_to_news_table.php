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
        // Rename table
        Schema::rename('events', 'news');
        
        // Update columns
        Schema::table('news', function (Blueprint $table) {
            // Rename and drop columns
            $table->renameColumn('start_date', 'published_at');
            $table->dropColumn('end_date');
            
            // Add new columns for news
            $table->string('author')->nullable()->after('title');
            $table->string('image')->nullable()->after('description');
            $table->text('content')->nullable()->after('image');
            $table->string('category')->default('umum')->after('content'); // umum, prestasi, kegiatan, pengumuman
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['author', 'image', 'content', 'category']);
            $table->renameColumn('published_at', 'start_date');
            $table->dateTime('end_date')->nullable();
        });
        
        Schema::rename('news', 'events');
    }
};
