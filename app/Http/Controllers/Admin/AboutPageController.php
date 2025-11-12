<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller
{
    public function edit()
    {
        $about = AboutPage::first();
        
        // If no data exists, create default data
        if (!$about) {
            $about = AboutPage::create([
                'title' => 'Tentang Sekolah',
                'subtitle' => 'Sejarah dan profil SMK Negeri 4 Bogor',
                'history_title' => 'Awal Berdiri',
                'history_content' => 'SMK Negeri 4 Bogor didirikan pada tanggal 15 Juni 2009 sebagai salah satu lembaga pendidikan kejuruan yang bertujuan untuk menghasilkan lulusan yang kompeten dan siap kerja di bidang teknologi dan industri.',
                'development_title' => 'Perkembangan',
                'development_content' => 'Seiring berjalannya waktu, SMK Negeri 4 Bogor terus berkembang dan berinovasi dalam memberikan pendidikan berkualitas. Sekolah ini telah menghasilkan ribuan alumni yang sukses berkarir di berbagai bidang industri dan teknologi.',
                'vision_title' => 'Visi',
                'vision_content' => 'Menjadi SMK yang unggul, berkarakter, dan berwawasan lingkungan dalam menghasilkan lulusan yang kompeten di bidang teknologi dan industri.',
                'mission_title' => 'Misi',
                'mission_items' => [
                    'Menyelenggarakan pendidikan kejuruan yang berkualitas dan relevan dengan kebutuhan industri',
                    'Mengembangkan karakter siswa yang berakhlak mulia dan bertanggung jawab',
                    'Meningkatkan kompetensi guru dan tenaga kependidikan secara berkelanjutan',
                    'Membangun kemitraan dengan dunia usaha dan industri',
                    'Menerapkan pembelajaran berbasis teknologi dan ramah lingkungan'
                ],
                'address' => 'Jl. Raya Tajur, Kp. Buntar RT.02/RW.08, Kel. Muara sari, Kec. Bogor Selatan, Kota Bogor, Jawa Barat 16137',
                'phone' => '(0251) 7547381',
                'email' => 'smkn4@smkn4bogor.sch.id',
                'website' => 'www.smkn4bogor.sch.id',
                'competencies' => [
                    ['icon' => 'fas fa-code text-primary', 'name' => 'Pengembangan Perangkat Lunak dan Gim'],
                    ['icon' => 'fas fa-network-wired text-success', 'name' => 'Teknik Jaringan Komputer dan Telekomunikasi'],
                    ['icon' => 'fas fa-fire text-danger', 'name' => 'Teknik Pengelasan'],
                    ['icon' => 'fas fa-car text-warning', 'name' => 'Teknik Otomotif']
                ]
            ]);
        }
        
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'history_title' => 'required|string',
            'history_content' => 'required|string',
            'development_title' => 'required|string',
            'development_content' => 'required|string',
            'vision_title' => 'required|string',
            'vision_content' => 'required|string',
            'mission_title' => 'required|string',
            'mission_items' => 'required|array|min:1',
            'mission_items.*' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'website' => 'required|string',
            'competencies' => 'required|array|min:1',
            'competencies.*.icon' => 'required|string',
            'competencies.*.name' => 'required|string',
        ]);

        $about = AboutPage::first();
        
        if (!$about) {
            $about = new AboutPage();
        }

        $data = $request->except(['image_path', 'profile_image']);

        // Handle main image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($about->image_path && !str_starts_with($about->image_path, 'http')) {
                Storage::disk('public')->delete($about->image_path);
            }
            
            $path = $request->file('image_path')->store('about', 'public');
            $data['image_path'] = $path;
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($about->profile_image && !str_starts_with($about->profile_image, 'http')) {
                Storage::disk('public')->delete($about->profile_image);
            }
            
            $path = $request->file('profile_image')->store('about', 'public');
            $data['profile_image'] = $path;
        }

        $about->fill($data);
        $about->save();

        return redirect()->route('admin.about.edit')
            ->with('success', 'Halaman Tentang berhasil diperbarui!');
    }
}
