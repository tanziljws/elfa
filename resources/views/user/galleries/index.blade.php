@extends('layouts.user')

@section('title', 'Galeri Foto')
@section('page-title', 'Galeri Foto')
@section('page-description', 'Koleksi foto kegiatan dan momen berharga di SMK NEGERI 4 BOGOR')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="mb-0">Total: {{ $galleries->total() }} foto</h5>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <!-- Filter Kategori -->
                <div class="btn-group" role="group">
                    <a href="{{ route('galleries.index') }}" class="btn btn-sm btn-outline-primary {{ !request('category') ? 'active' : '' }}">
                        Semua
                    </a>
                    @foreach($categoryNames as $key => $name)
                        <a href="{{ route('galleries.category', $key) }}" class="btn btn-sm btn-outline-primary">
                            {{ $name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if($galleries->count() > 0)
<div class="row g-4">
    @foreach($galleries as $gallery)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="gallery-item-card" onclick="viewPhoto({{ $gallery->id }}, '{{ $gallery->image_url }}', '{{ addslashes($gallery->title) }}', '{{ addslashes($gallery->description) }}', '{{ $categoryNames[$gallery->category] ?? $gallery->category }}', '{{ $gallery->created_at->format('d M Y') }}')">
            <div class="gallery-item-image">
                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
                <div class="gallery-item-overlay">
                    <i class="fas fa-search-plus"></i>
                </div>
            </div>
            <div class="gallery-item-content">
                <span class="gallery-item-badge" style="background-color: {{ ['academic' => '#4e73df', 'extracurricular' => '#1cc88a', 'event' => '#36b9cc', 'common' => '#f6c23e'][$gallery->category] ?? '#6c757d' }};">
                    {{ $categoryNames[$gallery->category] ?? $gallery->category }}
                </span>
                <h6 class="gallery-item-title">{{ Str::limit($gallery->title, 40) }}</h6>
                <p class="gallery-item-date">
                    <i class="far fa-clock me-1"></i>{{ $gallery->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-5">
    {{ $galleries->links() }}
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h5>Belum Ada Foto</h5>
                <p class="text-muted mb-0">Belum ada foto yang tersedia saat ini.</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Photo View Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="photoTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <img id="photoImage" src="" alt="" class="img-fluid rounded">
                    </div>
                    <div class="col-lg-4">
                        <div class="p-3">
                            <div class="mb-3">
                                <span id="photoBadge" class="badge"></span>
                            </div>
                            <p id="photoDescription" class="text-muted"></p>
                            <hr>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                <span id="photoDate"></span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.gallery-item-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.gallery-item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.gallery-item-image {
    position: relative;
    width: 100%;
    padding-top: 75%; /* 4:3 aspect ratio */
    overflow: hidden;
    background: #f0f0f0;
}

.gallery-item-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item-card:hover .gallery-item-image img {
    transform: scale(1.1);
}

.gallery-item-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item-card:hover .gallery-item-overlay {
    opacity: 1;
}

.gallery-item-overlay i {
    color: white;
    font-size: 2rem;
}

.gallery-item-content {
    padding: 16px;
}

.gallery-item-badge {
    display: inline-block;
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.gallery-item-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.4;
}

.gallery-item-date {
    font-size: 0.8rem;
    color: #718096;
    margin-bottom: 0;
}

@media (max-width: 576px) {
    .gallery-item-image {
        padding-top: 80%;
    }
}
</style>
@endsection

@section('scripts')
<script>
function viewPhoto(id, imageUrl, title, description, category, date) {
    document.getElementById('photoTitle').textContent = title;
    document.getElementById('photoImage').src = imageUrl;
    document.getElementById('photoImage').alt = title;
    document.getElementById('photoDescription').textContent = description || 'Tidak ada deskripsi';
    document.getElementById('photoBadge').textContent = category;
    document.getElementById('photoDate').textContent = date;
    
    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
}
</script>
@endsection
