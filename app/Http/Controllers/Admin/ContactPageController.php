<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function edit()
    {
        $contact = ContactPage::first();
        
        // If no data exists, create default data
        if (!$contact) {
            $contact = ContactPage::create([
                'title' => 'Hubungi Kami',
                'subtitle' => 'Jangan ragu untuk menghubungi kami jika ada pertanyaan',
                'address' => 'Jl. Raya Tajur, Kp. Buntar RT.02/RW.08, Kel. Muara sari, Kec. Bogor Selatan, Kota Bogor, Jawa Barat 16137',
                'phone' => '(0251) 7547381',
                'phone_alt' => '0812-3456-7890',
                'email' => 'info@smkn4bogor.sch.id',
                'email_alt' => 'smkn4bogor@gmail.com',
                'instagram_url' => '#',
                'youtube_url' => '#',
                'whatsapp_url' => '#',
                'office_hours_weekday' => '07:00 - 16:00 WIB',
                'office_hours_saturday' => '07:00 - 12:00 WIB',
                'office_hours_sunday' => 'Tutup',
                'note' => 'Untuk kunjungan, harap membuat janji terlebih dahulu melalui telepon atau email.'
            ]);
        }
        
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'phone_alt' => 'nullable|string',
            'email' => 'required|email',
            'email_alt' => 'nullable|email',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'whatsapp_url' => 'nullable|url',
            'office_hours_weekday' => 'required|string',
            'office_hours_saturday' => 'required|string',
            'office_hours_sunday' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $contact = ContactPage::first();
        
        if (!$contact) {
            $contact = new ContactPage();
        }

        $contact->fill($request->all());
        $contact->save();

        return redirect()->route('admin.contact.edit')
            ->with('success', 'Halaman Kontak berhasil diperbarui!');
    }
}
