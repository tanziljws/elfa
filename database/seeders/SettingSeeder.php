<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Gallery Settings
            [
                'key' => 'gallery_max_file_size',
                'value' => '5120', // 5MB in KB
                'type' => 'number',
                'group' => 'gallery',
                'label' => 'Ukuran Maksimal File Galeri (KB)',
                'description' => 'Ukuran maksimal file yang dapat diupload untuk galeri dalam kilobyte (1MB = 1024KB)'
            ],
            [
                'key' => 'gallery_allowed_extensions',
                'value' => 'jpg,jpeg,png,gif',
                'type' => 'text',
                'group' => 'gallery',
                'label' => 'Format File Galeri yang Diizinkan',
                'description' => 'Format file yang diizinkan, pisahkan dengan koma'
            ],
            [
                'key' => 'gallery_image_quality',
                'value' => '85',
                'type' => 'number',
                'group' => 'gallery',
                'label' => 'Kualitas Kompresi Gambar (%)',
                'description' => 'Kualitas gambar setelah kompresi (1-100, semakin tinggi semakin bagus)'
            ],
            
            // Agenda Settings
            [
                'key' => 'agenda_max_file_size',
                'value' => '3072', // 3MB in KB
                'type' => 'number',
                'group' => 'agenda',
                'label' => 'Ukuran Maksimal File Agenda (KB)',
                'description' => 'Ukuran maksimal file yang dapat diupload untuk agenda dalam kilobyte'
            ],
            [
                'key' => 'agenda_allowed_extensions',
                'value' => 'jpg,jpeg,png,gif',
                'type' => 'text',
                'group' => 'agenda',
                'label' => 'Format File Agenda yang Diizinkan',
                'description' => 'Format file yang diizinkan, pisahkan dengan koma'
            ],
            [
                'key' => 'agenda_items_per_page',
                'value' => '10',
                'type' => 'number',
                'group' => 'agenda',
                'label' => 'Jumlah Agenda per Halaman',
                'description' => 'Jumlah agenda yang ditampilkan per halaman di admin'
            ],
            
            // Informasi Settings
            [
                'key' => 'informasi_max_file_size',
                'value' => '3072', // 3MB in KB
                'type' => 'number',
                'group' => 'informasi',
                'label' => 'Ukuran Maksimal File Informasi (KB)',
                'description' => 'Ukuran maksimal file yang dapat diupload untuk informasi dalam kilobyte'
            ],
            [
                'key' => 'informasi_allowed_extensions',
                'value' => 'jpg,jpeg,png,gif',
                'type' => 'text',
                'group' => 'informasi',
                'label' => 'Format File Informasi yang Diizinkan',
                'description' => 'Format file yang diizinkan, pisahkan dengan koma'
            ],
            [
                'key' => 'informasi_items_per_page',
                'value' => '10',
                'type' => 'number',
                'group' => 'informasi',
                'label' => 'Jumlah Informasi per Halaman',
                'description' => 'Jumlah informasi yang ditampilkan per halaman di admin'
            ],
            
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'SMK Negeri 4 Bogor',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama website yang akan ditampilkan'
            ],
            [
                'key' => 'site_description',
                'value' => 'Galeri Foto SMK Negeri 4 Bogor',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat website'
            ],
            [
                'key' => 'items_per_page',
                'value' => '12',
                'type' => 'number',
                'group' => 'general',
                'label' => 'Item per Halaman (Default)',
                'description' => 'Jumlah item yang ditampilkan per halaman secara default'
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
