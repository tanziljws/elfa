@extends('layouts.user')

@section('title', $news->title)

@section('styles')
<style>
    .news-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        padding: 40px 0;
        margin-bottom: 40px;
    }
    .news-image-main {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 30px;
    }
    .news-content-area {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }
    .news-title-main {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        line-height: 1.3;
    }
    .news-meta-main {
        padding: 20px 0;
        border-top: 2px solid #e9ecef;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 30px;
    }
    .news-body {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #34495e;
    }
    .news-body p {
        margin-bottom: 20px;
    }
    .sidebar-widget {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .widget-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    .related-news-item {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    .related-news-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .related-news-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 15px;
    }
    .related-news-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    .related-news-date {
        font-size: 0.85rem;
        color: #7f8c8d;
    }
</style>
@endsection

@section('content')
<!-- News Header -->
<div class="news-header">
    <div class="container">
        <a href="{{ route('news.index') }}" class="btn btn-light mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Berita
        </a>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="news-content-area">
                @php
                    $categoryColors = [
                        'umum' => 'secondary',
                        'prestasi' => 'success',
                        'kegiatan' => 'primary',
                        'pengumuman' => 'warning'
                    ];
                    $categoryNames = [
                        'umum' => 'Umum',
                        'prestasi' => 'Prestasi',
                        'kegiatan' => 'Kegiatan Sekolah',
                        'pengumuman' => 'Pengumuman'
                    ];
                @endphp
                <span class="badge bg-{{ $categoryColors[$news->category] ?? 'secondary' }} mb-3">
                    {{ $categoryNames[$news->category] ?? $news->category }}
                </span>

                <h1 class="news-title-main">{{ $news->title }}</h1>

                <div class="news-meta-main">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong>Dipublikasikan:</strong> {{ $news->published_at->format('d F Y, H:i') }} WIB
                        </div>
                        @if($news->author)
                        <div class="col-md-6">
                            <i class="fas fa-user text-primary me-2"></i>
                            <strong>Penulis:</strong> {{ $news->author }}
                        </div>
                        @endif
                    </div>
                </div>

                @if($news->image)
                <img src="{{ asset($news->image) }}" alt="{{ $news->title }}" class="news-image-main">
                @endif

                <div class="news-body">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>

            <!-- Share Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <strong>Bagikan:</strong>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-primary ms-2">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" class="btn btn-sm btn-info ms-2">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-sm btn-success ms-2">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related News -->
            @if($relatedNews->count() > 0)
            <div class="sidebar-widget">
                <h5 class="widget-title">Berita Terkait</h5>
                @foreach($relatedNews as $related)
                <a href="{{ route('news.show', $related->id) }}" class="text-decoration-none">
                    <div class="related-news-item">
                        @if($related->image)
                        <img src="{{ asset($related->image) }}" alt="{{ $related->title }}" class="related-news-img">
                        @endif
                        <div>
                            <div class="related-news-title">{{ Str::limit($related->title, 50) }}</div>
                            <div class="related-news-date">
                                <i class="fas fa-calendar-alt me-1"></i>{{ $related->published_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            <!-- Latest News -->
            @if($latestNews->count() > 0)
            <div class="sidebar-widget">
                <h5 class="widget-title">Berita Terbaru</h5>
                @foreach($latestNews as $latest)
                <a href="{{ route('news.show', $latest->id) }}" class="text-decoration-none">
                    <div class="related-news-item">
                        @if($latest->image)
                        <img src="{{ asset($latest->image) }}" alt="{{ $latest->title }}" class="related-news-img">
                        @endif
                        <div>
                            <div class="related-news-title">{{ Str::limit($latest->title, 50) }}</div>
                            <div class="related-news-date">
                                <i class="fas fa-calendar-alt me-1"></i>{{ $latest->published_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
