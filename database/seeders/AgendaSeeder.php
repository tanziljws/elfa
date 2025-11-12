<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'title' => 'Upacara Hari Guru Nasional',
                'date' => '2025-10-15',
                'time' => '08:00 - 10:00 WIB',
                'location' => 'Lapangan Upacara',
                'description' => 'Upacara peringatan Hari Guru Nasional diikuti oleh seluruh siswa, guru, dan staff sekolah.',
                'category' => 'Upacara',
                'is_active' => true
            ],
            [
                'title' => 'Lomba Karya Ilmiah Remaja',
                'date' => '2025-10-20',
                'time' => '09:00 - 15:00 WIB',
                'location' => 'Aula Sekolah',
                'description' => 'Kompetisi karya ilmiah remaja tingkat sekolah untuk mengembangkan kreativitas dan inovasi siswa.',
                'category' => 'Lomba',
                'is_active' => true
            ],
            [
                'title' => 'Pelatihan Soft Skills',
                'date' => '2025-10-25',
                'time' => '13:00 - 16:00 WIB',
                'location' => 'Ruang Multimedia',
                'description' => 'Pelatihan soft skills untuk meningkatkan kemampuan komunikasi dan leadership siswa.',
                'category' => 'Pelatihan',
                'is_active' => true
            ],
            [
                'title' => 'Rapat Orang Tua Siswa',
                'date' => '2025-10-30',
                'time' => '10:00 - 12:00 WIB',
                'location' => 'Aula Sekolah',
                'description' => 'Rapat koordinasi antara pihak sekolah dengan orang tua siswa membahas perkembangan akademik.',
                'category' => 'Rapat',
                'is_active' => true
            ],
            [
                'title' => 'Study Tour ke Museum Nasional',
                'date' => '2025-11-05',
                'time' => '07:00 - 17:00 WIB',
                'location' => 'Museum Nasional Jakarta',
                'description' => 'Kunjungan edukatif ke Museum Nasional untuk menambah wawasan sejarah dan budaya.',
                'category' => 'Kunjungan',
                'is_active' => true
            ],
            [
                'title' => 'Workshop Digital Marketing',
                'date' => '2025-11-10',
                'time' => '09:00 - 15:00 WIB',
                'location' => 'Lab Komputer',
                'description' => 'Workshop digital marketing untuk siswa jurusan pemasaran bersama praktisi industri.',
                'category' => 'Workshop',
                'is_active' => true
            ]
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
}
