<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        // Data agenda contoh
        $agendas = [
            (object)[
                'id' => 1,
                'title' => 'Penerimaan Peserta Didik Baru',
                'date' => now()->addDays(5),
                'time' => '08:00 - 14:00 WIB',
                'location' => 'Aula SMKN 4 Bogor',
                'category' => 'Pendaftaran',
                'description' => 'Pendaftaran calon peserta didik baru tahun ajaran 2025/2026. Persyaratan: FC Akte Kelahiran, FC KK, FC Ijazah/SKL, Pas Foto 3x4',
                'image' => 'images/ppdb.jpg'
            ],
            (object)[
                'id' => 2,
                'title' => 'Lomba Kompetensi Siswa Tingkat Sekolah',
                'date' => now()->addDays(10),
                'time' => '07:30 - 15:00 WIB',
                'location' => 'Lab Komputer & Bengkel',
                'category' => 'Kompetisi',
                'description' => 'Seleksi peserta LKS tingkat sekolah untuk mewakili SMKN 4 Bogor di ajang LKS Kabupaten Bogor.',
                'image' => 'images/lks.jpg'
            ],
            (object)[
                'id' => 3,
                'title' => 'Kunjungan Industri ke PT. XYZ',
                'date' => now()->addDays(15),
                'time' => '07:00 - 16:00 WIB',
                'location' => 'PT. XYZ, Kawasan Industri Bogor',
                'category' => 'Kunjungan',
                'description' => 'Kunjungan industri untuk siswa kelas XI semua jurusan guna menambah wawasan tentang dunia kerja.',
                'image' => 'images/kunjungan.jpg'
            ],
            (object)[
                'id' => 4,
                'title' => 'Ujian Akhir Semester Ganjil',
                'date' => now()->addDays(25),
                'time' => '07:30 - 12:00 WIB',
                'location' => 'Ruang Kelas',
                'category' => 'Ujian',
                'description' => 'Pelaksanaan Ujian Akhir Semester Ganjil Tahun Ajaran 2025/2026 untuk seluruh kelas X, XI, dan XII.',
                'image' => 'images/uas.jpg'
            ]
        ];

        return view('user.agenda', compact('agendas'));
    }

    public function show($id)
    {
        // Ambil detail agenda berdasarkan ID
        $agenda = Agenda::where('is_active', true)->findOrFail($id);

        return view('user.agenda-detail', compact('agenda'));
    }
}
