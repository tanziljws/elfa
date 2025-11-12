<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Informasi;
use Carbon\Carbon;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $informasis = [
            [
                'title' => 'Pendaftaran Siswa Baru 2025/2026',
                'date' => '2025-10-05',
                'category' => 'Pengumuman',
                'badge' => 'success',
                'icon' => 'fa-bullhorn',
                'content' => 'Pendaftaran siswa baru tahun ajaran 2025/2026 akan dibuka mulai tanggal 1 November 2024. Informasi lengkap dapat diakses melalui website resmi sekolah atau datang langsung ke bagian TU sekolah. Persyaratan meliputi fotokopi ijazah, kartu keluarga, dan pas foto terbaru.',
                'is_active' => true
            ],
            [
                'title' => 'Prestasi Siswa di Lomba Nasional',
                'date' => '2025-10-03',
                'category' => 'Prestasi',
                'badge' => 'info',
                'icon' => 'fa-trophy',
                'content' => 'Selamat kepada tim robotika SMK Negeri 4 Bogor yang berhasil meraih juara 1 pada Kompetisi Robotika Nasional 2024 yang diselenggarakan di Jakarta. Tim yang terdiri dari 5 siswa berhasil mengalahkan 50 tim dari seluruh Indonesia dengan robot inovatif mereka.',
                'is_active' => true
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'date' => '2025-10-01',
                'category' => 'Pengumuman',
                'badge' => 'warning',
                'icon' => 'fa-exclamation-circle',
                'content' => 'Libur semester ganjil akan dilaksanakan mulai tanggal 20 Desember 2024 sampai dengan 5 Januari 2025. Masuk kembali pada tanggal 6 Januari 2025. Siswa diharapkan memanfaatkan waktu libur dengan baik untuk belajar dan beristirahat.',
                'is_active' => true
            ],
            [
                'title' => 'Pelaksanaan Ujian Tengah Semester',
                'date' => '2025-09-28',
                'category' => 'Akademik',
                'badge' => 'primary',
                'icon' => 'fa-book',
                'content' => 'Ujian Tengah Semester (UTS) akan dilaksanakan pada tanggal 15-22 November 2024. Siswa diharapkan mempersiapkan diri dengan baik dan mematuhi tata tertib ujian. Jadwal lengkap akan diumumkan melalui wali kelas masing-masing.',
                'is_active' => true
            ],
            [
                'title' => 'Program Magang Industri',
                'date' => '2025-09-25',
                'category' => 'Program',
                'badge' => 'success',
                'icon' => 'fa-briefcase',
                'content' => 'Program magang industri untuk siswa kelas 12 akan dimulai pada bulan Januari 2025. Siswa akan ditempatkan di berbagai perusahaan mitra sekolah sesuai dengan jurusan masing-masing. Pendaftaran dibuka mulai 1 November 2024.',
                'is_active' => true
            ],
            [
                'title' => 'Peningkatan Fasilitas Laboratorium',
                'date' => '2025-09-20',
                'category' => 'Fasilitas',
                'badge' => 'info',
                'icon' => 'fa-tools',
                'content' => 'Sekolah telah menyelesaikan renovasi dan peningkatan fasilitas laboratorium komputer dengan menambah 30 unit komputer baru dan perangkat jaringan terkini. Fasilitas ini dapat digunakan mulai minggu depan untuk mendukung pembelajaran praktik siswa.',
                'is_active' => true
            ]
        ];

        foreach ($informasis as $informasi) {
            Informasi::create($informasi);
        }
    }
}
