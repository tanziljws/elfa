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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Tentang Sekolah');
            $table->string('subtitle')->default('Sejarah dan profil SMK Negeri 4 Bogor');
            $table->string('image_path')->nullable();
            $table->text('history_title')->default('Awal Berdiri');
            $table->text('history_content');
            $table->text('development_title')->default('Perkembangan');
            $table->text('development_content');
            $table->text('vision_title')->default('Visi');
            $table->text('vision_content');
            $table->text('mission_title')->default('Misi');
            $table->json('mission_items'); // Array of mission items
            $table->string('profile_image')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('website');
            $table->json('competencies'); // Array of competencies with icon and name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
