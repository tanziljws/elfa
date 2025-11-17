@extends('layouts.user')

@section('title', 'Upload Foto')
@section('page-title', 'Upload Foto')
@section('page-description', 'Upload foto kegiatan sekolah ke galeri')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-cloud-upload-alt me-3"></i>Upload Foto
                </h1>
                <p class="page-subtitle">Upload foto kegiatan sekolah ke galeri</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('galleries.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-cloud-upload-alt me-2"></i>Upload Foto Baru</h5>
                </div>
                <div class="p-4">
                    <!-- Tambahkan peringatan bahwa hanya admin yang bisa upload -->
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Hanya admin yang bisa mengupload foto ke galeri. 
                        Silakan hubungi admin jika Anda ingin menambahkan foto ke galeri.
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('galleries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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

@media (max-width: 768px) {
    .page-header {
        padding: 60px 0 30px !important;
    }
    
    .page-header h1 {
        font-size: 2rem !important;
    }
}
</style>
@endsection