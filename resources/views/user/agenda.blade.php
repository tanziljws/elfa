@extends('layouts.user')

@section('title', 'Agenda Sekolah')

@section('styles')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    padding: 60px 0 40px;
    margin-bottom: 0;
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

.hover-shadow {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.card {
    border-radius: 0.75rem;
    overflow: hidden;
}

.card-title {
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2d3748;
}

.badge {
    font-weight: 500;
    padding: 0.4em 0.8em;
    border-radius: 0.5rem;
}

.btn-outline-primary {
    border-width: 2px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-subtitle {
        font-size: 1rem;
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
                    <i class="fas fa-calendar-check me-3"></i>Agenda Sekolah
                </h1>
                <p class="page-subtitle">Jadwal kegiatan dan acara terbaru SMK Negeri 4 Bogor</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Agenda Content -->
<div class="container py-5">
    <div class="row">
        @foreach($agendas as $agenda)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                @if(isset($agenda->image) && $agenda->image)
                <div class="card-img-top overflow-hidden" style="height: 180px;">
                    <img src="{{ asset($agenda->image) }}" alt="{{ $agenda->title }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary">{{ $agenda->category }}</span>
                        <div class="text-end">
                            <div class="text-muted small">{{ $agenda->date->translatedFormat('d F Y') }}</div>
                            <div class="text-muted small">{{ $agenda->time }}</div>
                        </div>
                    </div>
                    <h5 class="card-title">{{ $agenda->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($agenda->description, 100) }}</p>
                    <div class="d-flex align-items-center text-muted small">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>{{ $agenda->location }}</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('user.agenda.show', $agenda->id) }}" class="btn btn-outline-primary btn-sm w-100">
                        Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

