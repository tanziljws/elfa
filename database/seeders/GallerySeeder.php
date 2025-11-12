<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleData = [
            [
                'title' => 'Upacara Bendera Senin',
                'description' => 'Upacara bendera rutin setiap hari Senin di lapangan sekolah',
                'image_path' => 'https://via.placeholder.com/400x300/667eea/ffffff?text=Upacara+Bendera',
                'category' => 'academic',
                'is_active' => true,
            ],
            [
                'title' => 'Kegiatan Pramuka',
                'description' => 'Latihan pramuka mingguan untuk siswa kelas 7-9',
                'image_path' => 'https://via.placeholder.com/400x300/764ba2/ffffff?text=Kegiatan+Pramuka',
                'category' => 'extracurricular',
                'is_active' => true,
            ],
            [
                'title' => 'Pentas Seni Tahunan',
                'description' => 'Pentas seni tahunan yang menampilkan berbagai bakat siswa',
                'image_path' => 'https://via.placeholder.com/400x300/ff6b6b/ffffff?text=Pentas+Seni',
                'category' => 'event',
                'is_active' => true,
            ],
            [
                'title' => 'Perpustakaan Sekolah',
                'description' => 'Area perpustakaan yang nyaman untuk membaca dan belajar',
                'image_path' => 'https://via.placeholder.com/400x300/4ecdc4/ffffff?text=Perpustakaan',
                'category' => 'general',
                'is_active' => true,
            ],
            [
                'title' => 'Laboratorium Komputer',
                'description' => 'Fasilitas laboratorium komputer untuk pembelajaran IT',
                'image_path' => 'https://via.placeholder.com/400x300/45b7d1/ffffff?text=Lab+Komputer',
                'category' => 'academic',
                'is_active' => true,
            ],
            [
                'title' => 'Ekstrakurikuler Basket',
                'description' => 'Latihan basket untuk mengembangkan bakat olahraga siswa',
                'image_path' => 'https://via.placeholder.com/400x300/96ceb4/ffffff?text=Basket',
                'category' => 'extracurricular',
                'is_active' => true,
            ],
            [
                'title' => 'Hari Kemerdekaan RI',
                'description' => 'Perayaan hari kemerdekaan dengan berbagai lomba dan kegiatan',
                'image_path' => 'https://via.placeholder.com/400x300/feca57/ffffff?text=17+Agustus',
                'category' => 'event',
                'is_active' => true,
            ],
            [
                'title' => 'Kantin Sekolah',
                'description' => 'Area kantin yang bersih dan nyaman untuk siswa',
                'image_path' => 'https://via.placeholder.com/400x300/ff9ff3/ffffff?text=Kantin',
                'category' => 'general',
                'is_active' => true,
            ],
        ];

        foreach ($sampleData as $data) {
            Gallery::create($data);
        }
    }
}
