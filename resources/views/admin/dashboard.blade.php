@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="stats-number">{{ $totalPhotos }}</h3>
            <p class="stats-label">Total Foto</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="stats-number">{{ $activePhotos }}</h3>
            <p class="stats-label">Foto Aktif</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);">
                <i class="fas fa-eye-slash"></i>
            </div>
            <h3 class="stats-number">{{ $inactivePhotos }}</h3>
            <p class="stats-label">Foto Tidak Aktif</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);">
                <i class="fas fa-calendar-day"></i>
            </div>
            <h3 class="stats-number">{{ $todayPhotos }}</h3>
            <p class="stats-label">Ditambah Hari Ini</p>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-clock me-2"></i>Foto Terbaru</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPhotos as $photo)
                        <tr>
                            <td>
                                <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            </td>
                            <td>
                                <strong>{{ $photo->title }}</strong>
                                @if($photo->description)
                                <br><small class="text-muted">{{ Str::limit($photo->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $categoryNames[$photo->category] ?? $photo->category }}</span>
                            </td>
                            <td>
                                @if($photo->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $photo->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.galleries.edit', $photo->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" onclick="deletePhoto({{ $photo->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-images fa-2x mb-2"></i><br>
                                Belum ada foto
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-chart-pie me-2"></i>Statistik Kategori</h5>
            </div>
            <div class="p-3">
                @foreach($categoryNames as $key => $name)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>{{ $name }}</strong>
                        <br><small class="text-muted">{{ $photosByCategory[$key] ?? 0 }} foto</small>
                    </div>
                    <div class="progress" style="width: 100px; height: 8px;">
                        @php
                            $percentage = $totalPhotos > 0 ? (($photosByCategory[$key] ?? 0) / $totalPhotos) * 100 : 0;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Tambah Foto
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list me-2"></i>Kelola Galeri
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.reports.gallery') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('home') }}" class="btn btn-outline-success w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-calendar-alt me-2"></i>Aktivitas Minggu Ini</h5>
            </div>
            <div class="p-3">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-primary mb-1">{{ $thisWeekPhotos }}</h4>
                        <small class="text-muted">Minggu Ini</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success mb-1">{{ $thisMonthPhotos }}</h4>
                        <small class="text-muted">Bulan Ini</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-info mb-1">{{ $totalPhotos }}</h4>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus foto ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deletePhoto(id) {
    document.getElementById('deleteForm').action = `/admin/galleries/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
