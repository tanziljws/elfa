@extends('layouts.user')

@section('title', 'Foto Saya')
@section('page-title', 'Foto Saya')
@section('page-description', 'Kelola foto yang telah Anda upload')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Total: {{ $galleries->total() }} foto</h5>
            </div>
            <div>
                <a href="{{ route('user.galleries.upload') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Upload Foto Baru
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($galleries->count() > 0)
<div class="row">
    @foreach($galleries as $gallery)
    <div class="col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="position-relative">
                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" 
                     class="card-img-top" style="height: 250px; object-fit: cover;">
                <div class="position-absolute top-0 end-0 p-2">
                    <span class="badge bg-primary">{{ $categoryNames[$gallery->category] ?? $gallery->category }}</span>
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
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="viewPhoto('{{ $gallery->image_url }}', '{{ $gallery->title }}', '{{ $gallery->description }}')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
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
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h5>Belum Ada Foto</h5>
                <p class="text-muted mb-4">Anda belum mengupload foto apapun. Mulai berbagi momen berharga sekolah!</p>
                <a href="{{ route('user.galleries.upload') }}" class="btn btn-success">
                    <i class="fas fa-cloud-upload-alt me-2"></i>Upload Foto Pertama
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
