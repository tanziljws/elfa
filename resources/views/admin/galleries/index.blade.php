@extends('layouts.admin')

@section('title', 'Manajemen Galeri')
@section('page-title', 'Manajemen Galeri')

@section('content')
<!-- Action Bar -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0"><i class="fas fa-images me-2"></i>Manajemen Galeri</h4>
                <p class="text-muted mb-0">Kelola foto-foto galeri SMK NEGERI 4 BOGOR</p>
            </div>
            <div>
                <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Foto Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-filter me-2"></i>Filter & Pencarian</h5>
            </div>
            <div class="p-3">
                <form method="GET" action="{{ route('admin.galleries.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category">
                                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                                @foreach($categoryNames as $key => $name)
                                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search" class="form-label">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Cari berdasarkan judul...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
                <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-primary">{{ $categoryNames[$gallery->category] ?? $gallery->category }}</span>
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
            <h5 class="text-muted">Tidak ada foto ditemukan</h5>
            <p class="text-muted">Coba ubah filter atau tambah foto baru.</p>
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Foto Pertama
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
            {{ $galleries->appends(request()->query())->links() }}
        </nav>
    </div>
</div>
@endif

<!-- Quick Stats -->
<div class="row mt-4">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-chart-bar me-2"></i>Statistik Galeri</h5>
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
<!-- Floating Action Button -->
<a href="{{ route('admin.galleries.create') }}" 
   class="btn btn-primary btn-lg rounded-circle position-fixed" 
   style="bottom: 30px; right: 30px; z-index: 1000; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;"
   title="Tambah Foto Baru">
    <i class="fas fa-plus fa-lg"></i>
</a>
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
