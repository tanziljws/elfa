<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EventTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Create past events
        for ($i = 1; $i <= 5; $i++) {
            $startDate = now()->subDays(rand(10, 30));
            
            Event::create([
                'title' => 'Acara ' . $faker->sentence(3),
                'description' => $faker->paragraph(5),
                'location' => $faker->address,
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addHours(rand(2, 8)),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Create upcoming events
        for ($i = 1; $i <= 10; $i++) {
            $startDate = now()->addDays(rand(1, 30));
            
            Event::create([
                'title' => 'Acara Mendatang ' . $faker->sentence(2),
                'description' => $faker->paragraph(4),
                'location' => $faker->address,
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addHours(rand(2, 8)),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('Sample events data has been added!');
    }
}
