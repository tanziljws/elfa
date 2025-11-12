@extends('layouts.user')

@section('title', 'Kategori: ' . $currentCategory)
@section('page-title', 'Kategori: ' . $currentCategory)
@section('page-description', 'Foto-foto dalam kategori ' . $currentCategory)

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Total: {{ $galleries->total() }} foto</h5>
            </div>
            <div>
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
                <a href="{{ route('user.galleries.upload') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Upload Foto
                </a>
            </div>
        </div>
    </div>
</div>

@if($galleries->count() > 0)
<div class="row">
    @foreach($galleries as $gallery)
    <div class="col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="position-relative">
                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" 
                     class="card-img-top" style="height: 250px; object-fit: cover;">
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-success">{{ $categoryNames[$gallery->category] ?? $gallery->category }}</span>
                </div>
            </div>
            <div class="card-body">
                <h6 class="card-title">{{ $gallery->title }}</h6>
                <p class="card-text text-muted small">
                    {{ Str::limit($gallery->description, 80) ?: 'Tidak ada deskripsi' }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $gallery->created_at->format('d M Y') }}
                    </small>
                    <button class="btn btn-sm btn-outline-success" onclick="viewPhoto('{{ $gallery->image_url }}', '{{ $gallery->title }}', '{{ $gallery->description }}')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $galleries->links() }}
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="table-card">
            <div class="p-5 text-center">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h5>Belum Ada Foto di Kategori {{ $currentCategory }}</h5>
                <p class="text-muted mb-4">Belum ada foto yang diupload dalam kategori ini.</p>
                <a href="{{ route('user.galleries.upload') }}" class="btn btn-success">
                    <i class="fas fa-cloud-upload-alt me-2"></i>Upload Foto {{ $currentCategory }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Photo View Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="photoImage" src="" alt="" class="img-fluid rounded">
                <p id="photoDescription" class="mt-3 text-muted"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewPhoto(imageUrl, title, description) {
    document.getElementById('photoTitle').textContent = title;
    document.getElementById('photoImage').src = imageUrl;
    document.getElementById('photoImage').alt = title;
    document.getElementById('photoDescription').textContent = description || 'Tidak ada deskripsi';
    
    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
}
</script>
@endsection
