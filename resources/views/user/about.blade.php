@extends('layouts.user')

@section('title', 'Tentang Kami')

@section('styles')
<style>
/* Reset default margins and paddings */
body {
    overflow-x: hidden;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    padding: 60px 0 40px !important;
    margin-bottom: 0 !important;
    box-shadow: 0 4px 20px rgba(78, 115, 223, 0.3);
}

.page-title {
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

.table-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
}

.table-card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    padding: 15px 20px;
}

.table-card-header h5 {
    margin: 0;
    font-weight: 600;
    color: #4e73df;
}

.table-card .p-4 {
    padding: 20px !important;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.75rem;
    }
    
    .page-header {
        padding: 30px 0 20px;
    }
}
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <i class="fas fa-info-circle me-3"></i>{{ $about->title }}
                </h1>
                <p class="page-subtitle">{{ $about->subtitle }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="row g-0">
        <!-- Sejarah Sekolah -->
        <div class="col-12 col-lg-8 px-4 py-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-history me-2"></i>Sejarah Sekolah</h5>
            </div>
            <div class="p-4">
                <div class="mb-4">
                    <!-- Foto Sekolah -->
                    <div class="text-center mb-4" style="max-width: 800px; margin: 0 auto;">
                        <img src="{{ asset('images/smk4 bogor 6.jpg') }}" alt="Gedung SMK Negeri 4 Bogor" 
                             class="img-fluid rounded shadow" style="max-height: 300px; width: 100%; object-fit: cover;">
                        <p class="text-muted mt-2 mb-0"><small>Gedung SMK Negeri 4 Bogor</small></p>
                    </div>

                    <h6 class="text-primary mb-2">{{ $about->history_title }}</h6>
                    <p class="text-justify mb-3">
                        {{ $about->history_content }}
                    </p>

                    <h6 class="text-primary mb-2 mt-3">{{ $about->development_title }}</h6>
                    <p class="text-justify mb-3">
                        {{ $about->development_content }}
                    </p>

                    <h6 class="text-primary mb-2 mt-4">{{ $about->vision_title }}</h6>
                    <p class="text-justify mb-3">
                        {{ $about->vision_content }}
                    </p>

                    <h6 class="text-primary mb-2 mt-3">{{ $about->mission_title }}</h6>
                    <ul class="list-group list-group-flush mb-0">
                        @foreach($about->mission_items as $item)
                        <li class="list-group-item py-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-12 col-lg-4 bg-light ps-lg-0 pe-lg-3 py-4">
        <!-- Profil Singkat -->
        <div class="table-card mb-4">
            <div class="table-card-header">
                <h5><i class="fas fa-school me-2"></i>Profil Singkat</h5>
            </div>
            <div class="p-4">
                <!-- Foto sekolah -->
                <div class="text-center mb-3" style="max-width: 600px; margin: 0 auto;">
                    <img src="{{ asset('images/smk4 bogor 3.webp') }}" alt="Profil SMK Negeri 4 Bogor" 
                         class="img-fluid rounded shadow" style="width: 100%; max-height: 200px; object-fit: cover;">
                    <p class="text-muted mt-2 mb-0"><small>SMK Negeri 4 Bogor</small></p>
                </div>

                <table class="table table-sm">
                    <tr>
                        <td class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Alamat</td>
                        <td>{{ $about->address }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-phone me-2"></i>Telepon</td>
                        <td>{{ $about->phone }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-envelope me-2"></i>Email</td>
                        <td>{{ $about->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><i class="fas fa-globe me-2"></i>Website</td>
                        <td>{{ $about->website }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Kompetensi Keahlian -->
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-graduation-cap me-2"></i>Kompetensi Keahlian</h5>
            </div>
            <div class="p-4">
                <div class="list-group list-group-flush">
                    @foreach($about->competencies as $competency)
                    <div class="list-group-item">
                        <i class="{{ $competency['icon'] }} me-2"></i>
                        <strong>{{ $competency['name'] }}</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
