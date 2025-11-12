<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GalleryTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $categories = ['academic', 'extracurricular', 'event', 'general'];
        
        for ($i = 0; $i < 20; $i++) {
            $category = $categories[array_rand($categories)];
            $title = 'Galeri ' . ucfirst($category) . ' ' . ($i + 1);
            
            Gallery::create([
                'title' => $title,
                'description' => $faker->paragraph(3),
                'category' => $category,
                'image_path' => 'https://source.unsplash.com/random/800x600/?' . $category,
                'is_active' => true,
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('Sample galleries data has been added!');
    }
}
