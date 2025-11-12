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
        Schema::table('agendas', function (Blueprint $table) {
            $table->text('purpose')->nullable()->after('description'); // Tujuan kegiatan
            $table->text('participants')->nullable()->after('purpose'); // Peserta yang terlibat
            $table->time('start_time')->nullable()->after('time'); // Jam mulai
            $table->time('end_time')->nullable()->after('start_time'); // Jam selesai
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn(['purpose', 'participants', 'start_time', 'end_time']);
        });
    }
};
