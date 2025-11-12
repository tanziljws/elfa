@extends('layouts.user')

@section('title', 'Tentang Kami')

@section('styles')
<style>
    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        padding: 80px 0 40px !important;
        margin-bottom: 0 !important;
        box-shadow: 0 4px 20px rgba(78, 115, 223, 0.3) !important;
    }

    .page-header h1 {
        color: white !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 10px !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.9) !important;
        font-size: 1.1rem !important;
        margin-bottom: 0 !important;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-info-circle me-3"></i>Tentang Kami
                </h1>
                <p class="page-subtitle">Profil dan informasi lengkap SMK Negeri 4 Bogor</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <p>
                Galeri ini dibuat untuk mendokumentasikan kegiatan, prestasi, dan momen terbaik
                SMK Negeri 4 Bogor. Melalui platform ini, siswa dan guru dapat berbagi hasil karya
                dan aktivitas sekolah kepada masyarakat.
            </p>
        </div>
    </div>
</div>
@endsection


