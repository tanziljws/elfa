<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class CompleteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Website Information
            [
                'key' => 'site_name',
                'value' => 'SMK NEGERI 4 BOGOR',
                'type' => 'string',
                'group' => 'website',
                'label' => 'Nama Website',
                'description' => 'Nama sekolah yang akan ditampilkan di website'
            ],
            [
                'key' => 'site_description',
                'value' => 'Koleksi foto kegiatan dan momen berharga di SMK NEGERI 4 BOGOR',
                'type' => 'string',
                'group' => 'website',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat tentang galeri sekolah'
            ],
            
            // Upload Settings
            [
                'key' => 'upload_max_file_size',
                'value' => '5120',
                'type' => 'number',
                'group' => 'upload',
                'label' => 'Ukuran File Maksimal',
                'description' => 'Ukuran maksimal file yang dapat diupload (dalam KB)'
            ],
            [
                'key' => 'upload_allowed_extensions',
                'value' => 'jpg, jpeg, png, gif',
                'type' => 'string',
                'group' => 'upload',
                'label' => 'Format File yang Diizinkan',
                'description' => 'Format file gambar yang dapat diupload (pisahkan dengan koma)'
            ],
            [
                'key' => 'upload_image_quality',
                'value' => '85',
                'type' => 'number',
                'group' => 'upload',
                'label' => 'Kualitas Gambar',
                'description' => 'Kualitas kompresi gambar (0-100, semakin tinggi semakin baik)'
            ],
            
            // Display Settings
            [
                'key' => 'items_per_page',
                'value' => '12',
                'type' => 'number',
                'group' => 'display',
                'label' => 'Jumlah Item Per Halaman',
                'description' => 'Jumlah foto yang ditampilkan per halaman'
            ],
            [
                'key' => 'enable_public_upload',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'display',
                'label' => 'Izinkan Upload Publik',
                'description' => 'Mengizinkan pengunjung untuk mengupload foto'
            ],
            [
                'key' => 'auto_approve_content',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'display',
                'label' => 'Otomatis Setujui Konten',
                'description' => 'Otomatis menyetujui foto yang diupload tanpa moderasi'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
