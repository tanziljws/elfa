<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class UploadSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'upload_max_file_size_mb',
                'value' => '10', // 10 MB
                'type' => 'number',
                'group' => 'upload',
                'label' => 'Ukuran Maksimal Upload (MB)',
                'description' => 'Ukuran maksimal file upload untuk seluruh konten (Agenda, Informasi, Galeri).'
            ],
            [
                'key' => 'upload_allowed_extensions',
                'value' => 'jpg,jpeg,png,gif',
                'type' => 'text',
                'group' => 'upload',
                'label' => 'Ekstensi File Diizinkan',
                'description' => 'Daftar ekstensi file yang diizinkan untuk semua upload, pisahkan dengan koma.'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
