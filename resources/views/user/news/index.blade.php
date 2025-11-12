@extends('layouts.user')

@section('title', 'Berita Sekolah')

@section('styles')
<style>
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
    .news-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        height: 100%;
    }
    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .news-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .news-category {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        z-index: 1;
    }
    .news-content {
        padding: 20px;
    }
    .news-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #2c3e50;
    }
    .news-meta {
        color: #7f8c8d;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    .news-description {
        color: #5a6c7d;
        line-height: 1.6;
    }
    .filter-section {
        background: #f8f9fa;
        padding: 30px 0;
        margin-bottom: 40px;
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
                    <i class="fas fa-newspaper me-3"></i>Berita Sekolah
                </h1>
                <p class="page-subtitle">Informasi terkini dan kegiatan SMK NEGERI 4 BOGOR</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <div class="container">
        <form action="{{ route('news.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- News Grid -->
<div class="container mb-5">
    <div class="row g-4">
        @forelse($news as $item)
        <div class="col-md-4">
            <div class="card news-card">
                <div class="position-relative">
                    @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="news-image">
                    @else
                        <img src="{{ asset('images/default-news.jpg') }}" alt="{{ $item->title }}" class="news-image">
                    @endif
                    @php
                        $categoryColors = [
                            'umum' => 'bg-secondary',
                            'prestasi' => 'bg-success',
                            'kegiatan' => 'bg-primary',
                            'pengumuman' => 'bg-warning text-dark'
                        ];
                        $categoryNames = [
                            'umum' => 'Umum',
                            'prestasi' => 'Prestasi',
                            'kegiatan' => 'Kegiatan',
                            'pengumuman' => 'Pengumuman'
                        ];
                    @endphp
                    <span class="news-category {{ $categoryColors[$item->category] ?? 'bg-secondary' }}">
                        {{ $categoryNames[$item->category] ?? $item->category }}
                    </span>
                </div>
                <div class="news-content">
                    <h5 class="news-title">{{ Str::limit($item->title, 60) }}</h5>
                    <div class="news-meta">
                        <i class="fas fa-calendar-alt me-2"></i>{{ $item->published_at->format('d M Y') }}
                        @if($item->author)
                            <span class="ms-3"><i class="fas fa-user me-2"></i>{{ $item->author }}</span>
                        @endif
                    </div>
                    <p class="news-description">{{ Str::limit($item->description, 100) }}</p>
                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                        Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada berita</h4>
                <p class="text-muted">Berita akan segera ditampilkan di sini</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $news->links() }}
    </div>
</div>
@endsection
