<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            [
                'key' => 'site_name',
                'value' => 'SMK NEGERI 4 BOGOR',
                'type' => 'string',
                'description' => 'Nama sekolah'
            ],
            [
                'key' => 'site_description',
                'value' => 'Koleksi foto kegiatan dan momen berharga di SMK NEGERI 4 BOGOR',
                'type' => 'string',
                'description' => 'Deskripsi galeri'
            ],
            [
                'key' => 'photos_per_page',
                'value' => '12',
                'type' => 'integer',
                'description' => 'Jumlah foto per halaman'
            ],
            [
                'key' => 'enable_public_upload',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Izinkan upload dari galeri publik'
            ],
            [
                'key' => 'auto_approve_photos',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Otomatis setujui foto yang diupload'
            ],
            [
                'key' => 'max_file_size',
                'value' => '2',
                'type' => 'integer',
                'description' => 'Ukuran file maksimal (MB)'
            ],
            [
                'key' => 'allowed_formats',
                'value' => '["jpeg","png","jpg","gif"]',
                'type' => 'array',
                'description' => 'Format file yang diizinkan'
            ],
            [
                'key' => 'image_quality',
                'value' => '80',
                'type' => 'integer',
                'description' => 'Kualitas kompresi gambar'
            ]
        ];

        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
