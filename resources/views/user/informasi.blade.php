@extends('layouts.user')

@section('title', 'Informasi Sekolah')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <i class="fas fa-info-circle me-3"></i>Informasi Terkini
                </h1>
                <p class="page-subtitle">Berita dan pengumuman penting SMK Negeri 4 Bogor</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Content -->
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row g-4">
                @foreach($informasis as $info)
                <div class="col-md-6">
                    <div class="info-card-full">
                        <div class="info-header">
                            <div class="info-badge-large badge-{{ $info['badge'] }}">
                                <i class="fas {{ $info['icon'] }}"></i>
                            </div>
                            <div class="info-meta-header">
                                <span class="badge bg-{{ $info['badge'] }}">{{ $info['category'] }}</span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($info['date'])->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="info-body">
                            <h4 class="info-title-full">{{ $info['title'] }}</h4>
                            <p class="info-content">{{ $info['content'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    padding: 60px 0 40px;
    margin-bottom: 40px;
    box-shadow: 0 4px 20px rgba(78, 115, 223, 0.3);
}

.page-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-bottom: 0;
}

/* Info Card Full */
.info-card-full {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 2px solid transparent;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.info-card-full:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(78, 115, 223, 0.15);
    border-color: #4e73df;
}

.info-header {
    background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    border-bottom: 2px solid #e3e6f0;
}

.info-badge-large {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    flex-shrink: 0;
}

.badge-success {
    background: linear-gradient(135deg, #1cc88a, #13855c);
}

.badge-info {
    background: linear-gradient(135deg, #36b9cc, #258391);
}

.badge-warning {
    background: linear-gradient(135deg, #f6c23e, #dda20a);
}

.badge-primary {
    background: linear-gradient(135deg, #4e73df, #224abe);
}

.info-meta-header {
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.info-body {
    padding: 25px;
    flex: 1;
}

.info-title-full {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
}

.info-content {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 0;
    text-align: justify;
}

/* Badge Colors */
.bg-success {
    background-color: #1cc88a !important;
}

.bg-info {
    background-color: #36b9cc !important;
}

.bg-warning {
    background-color: #f6c23e !important;
}

.bg-primary {
    background-color: #4e73df !important;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-subtitle {
        font-size: 1rem;
    }
    
    .info-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection

