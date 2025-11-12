<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        // Ambil informasi aktif dan terbaru dari database
        $informasis = Informasi::active()
                              ->latest()
                              ->get();

        return view('user.informasi', compact('informasis'));
    }
}
