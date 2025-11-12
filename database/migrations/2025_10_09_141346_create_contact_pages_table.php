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
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Hubungi Kami');
            $table->string('subtitle')->default('Jangan ragu untuk menghubungi kami jika ada pertanyaan');
            $table->text('address');
            $table->string('phone');
            $table->string('phone_alt')->nullable();
            $table->string('email');
            $table->string('email_alt')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->string('office_hours_weekday')->default('07:00 - 16:00 WIB');
            $table->string('office_hours_saturday')->default('07:00 - 12:00 WIB');
            $table->string('office_hours_sunday')->default('Tutup');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_pages');
    }
};
