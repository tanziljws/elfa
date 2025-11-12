@extends('layouts.admin')

@section('title', 'Kategori: ' . $currentCategory)
@section('page-title', 'Kategori: ' . $currentCategory)

@section('content')
<!-- Category Info -->
<div class="row mb-4">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-folder me-2"></i>{{ $currentCategory }}</h5>
            </div>
            <div class="p-3">
                <div class="row">
                    <div class="col-md-8">
                        <p class="mb-0">Menampilkan {{ $galleries->count() }} dari {{ $galleries->total() }} foto dalam kategori {{ $currentCategory }}.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Foto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="row">
    @forelse($galleries as $gallery)
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card h-100 gallery-card">
            <div class="position-relative">
                <img src="{{ $gallery->image_url }}" class="card-img-top" alt="{{ $gallery->title }}" 
                     style="height: 200px; object-fit: cover;">
                <div class="position-absolute top-0 end-0 m-2">
                    @if($gallery->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                </div>
            </div>
            <div class="card-body d-flex flex-column">
                <h6 class="card-title">{{ $gallery->title }}</h6>
                @if($gallery->description)
                <p class="card-text text-muted small flex-grow-1">
                    {{ Str::limit($gallery->description, 80) }}
                </p>
                @endif
                <div class="mt-auto">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $gallery->created_at->format('d M Y') }}
                    </small>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('admin.galleries.show', $gallery->id) }}" 
                       class="btn btn-outline-info btn-sm" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.galleries.edit', $gallery->id) }}" 
                       class="btn btn-outline-primary btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.galleries.toggle-status', $gallery->id) }}" 
                          style="display: inline;" onsubmit="return confirm('Ubah status foto ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-warning btn-sm" 
                                title="{{ $gallery->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                            <i class="fas fa-{{ $gallery->is_active ? 'eye-slash' : 'eye' }}"></i>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.galleries.destroy', $gallery->id) }}" 
                          style="display: inline;" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada foto dalam kategori {{ $currentCategory }}</h5>
            <p class="text-muted">Tambahkan foto pertama untuk kategori ini.</p>
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Foto
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($galleries->hasPages())
<div class="row">
    <div class="col-12">
        <nav aria-label="Gallery pagination">
            {{ $galleries->links() }}
        </nav>
    </div>
</div>
@endif

<!-- Category Stats -->
<div class="row mt-4">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-chart-bar me-2"></i>Statistik Kategori {{ $currentCategory }}</h5>
            </div>
            <div class="p-3">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h4 class="text-primary mb-1">{{ $galleries->total() }}</h4>
                        <small class="text-muted">Total Foto</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-success mb-1">{{ $galleries->where('is_active', true)->count() }}</h4>
                        <small class="text-muted">Foto Aktif</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning mb-1">{{ $galleries->where('is_active', false)->count() }}</h4>
                        <small class="text-muted">Foto Tidak Aktif</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-info mb-1">{{ $galleries->count() }}</h4>
                        <small class="text-muted">Ditampilkan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.gallery-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.gallery-card:hover .card-img-top {
    transform: scale(1.05);
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>
@endsection
