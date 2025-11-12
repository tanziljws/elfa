@extends('layouts.admin')

@section('title', 'Laporan Galeri')
@section('page-title', 'Laporan & Statistik Galeri')

@section('content')
<!-- Filter Tanggal -->
<div class="row mb-4">
    <div class="col-12">
        <div class="table-card">
            <div class="p-3">
                <form method="GET" action="{{ route('admin.reports.gallery') }}" class="row g-3" id="filterForm">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger w-100" onclick="exportPDF()">
                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Utama -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="table-card text-center p-4">
            <i class="fas fa-images fa-3x text-primary mb-3"></i>
            <h3 class="mb-0">{{ $totalPhotos }}</h3>
            <p class="text-muted mb-0">Total Foto</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center p-4">
            <i class="fas fa-thumbs-up fa-3x text-success mb-3"></i>
            <h3 class="mb-0">{{ $totalLikes }}</h3>
            <p class="text-muted mb-0">Total Likes</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center p-4">
            <i class="fas fa-comments fa-3x text-info mb-3"></i>
            <h3 class="mb-0">{{ $totalComments }}</h3>
            <p class="text-muted mb-0">Total Komentar</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center p-4">
            <i class="fas fa-eye fa-3x text-warning mb-3"></i>
            <h3 class="mb-0">{{ $activePhotos }}</h3>
            <p class="text-muted mb-0">Foto Aktif</p>
        </div>
    </div>
</div>

<!-- Engagement Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="table-card p-4">
            <h6 class="mb-3">Status Foto</h6>
            <div class="d-flex justify-content-between mb-2">
                <span>Aktif:</span>
                <strong class="text-success">{{ $activePhotos }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Nonaktif:</span>
                <strong class="text-danger">{{ $inactivePhotos }}</strong>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-card p-4">
            <h6 class="mb-3">Interaksi</h6>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="fas fa-thumbs-up text-success"></i> Likes:</span>
                <strong>{{ $totalLikes }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-thumbs-down text-danger"></i> Dislikes:</span>
                <strong>{{ $totalDislikes }}</strong>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-card p-4">
            <h6 class="mb-3">Komentar</h6>
            <div class="d-flex justify-content-between mb-2">
                <span>Disetujui:</span>
                <strong class="text-success">{{ $approvedComments }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Pending:</span>
                <strong class="text-warning">{{ $pendingComments }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="table-card p-4">
            <h6 class="mb-3">Distribusi Kategori</h6>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-card p-4">
            <h6 class="mb-3">Upload 6 Bulan Terakhir</h6>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>

<!-- Category Details -->
<div class="row mb-4">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-th-large me-2"></i>Detail Per Kategori</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Jumlah Foto</th>
                            <th>Total Likes</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryStats as $key => $stat)
                        <tr>
                            <td><strong>{{ $stat['name'] }}</strong></td>
                            <td>{{ $stat['count'] }}</td>
                            <td><i class="fas fa-thumbs-up text-success"></i> {{ $stat['likes'] }}</td>
                            <td>
                                @php
                                    $percentage = $totalPhotos > 0 ? round(($stat['count'] / $totalPhotos) * 100, 1) : 0;
                                @endphp
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
                                        {{ $percentage }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Photos -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-fire me-2"></i>Top 10 Foto Terpopuler (Likes)</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="50%">Judul</th>
                            <th width="20%">Kategori</th>
                            <th width="20%">Likes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topLikedPhotos as $index => $photo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Str::limit($photo->title, 30) }}</td>
                            <td><span class="badge bg-primary">{{ $photo->category }}</span></td>
                            <td><i class="fas fa-thumbs-up text-success"></i> {{ $photo->likes_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-comment-dots me-2"></i>Top 10 Foto Paling Dikomentari</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th width="50%">Judul</th>
                            <th width="20%">Kategori</th>
                            <th width="20%">Komentar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCommentedPhotos as $index => $photo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Str::limit($photo->title, 30) }}</td>
                            <td><span class="badge bg-info">{{ $photo->category }}</span></td>
                            <td><i class="fas fa-comments text-info"></i> {{ $photo->comments_count }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Recent Photos -->
<div class="row">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-clock me-2"></i>10 Foto Terbaru</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="10%">Foto</th>
                            <th width="30%">Judul</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Tanggal Upload</th>
                            <th width="10%">Likes</th>
                            <th width="10%">Komentar</th>
                            <th width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPhotos as $photo)
                        <tr>
                            <td>
                                <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>{{ $photo->title }}</td>
                            <td><span class="badge bg-primary">{{ $photo->category }}</span></td>
                            <td>{{ $photo->created_at->format('d M Y') }}</td>
                            <td><i class="fas fa-thumbs-up text-success"></i> {{ $photo->likesCount() }}</td>
                            <td><i class="fas fa-comments text-info"></i> {{ $photo->approvedComments()->count() }}</td>
                            <td>
                                @if($photo->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Export PDF function
function exportPDF() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    const url = '{{ route("admin.reports.gallery.export-pdf") }}' + 
                '?start_date=' + startDate + 
                '&end_date=' + endDate;
    
    window.open(url, '_blank');
}
</script>
<script>
// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($categoryChartData['labels']) !!},
        datasets: [{
            data: {!! json_encode($categoryChartData['data']) !!},
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Monthly Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyChartData['labels']) !!},
        datasets: [{
            label: 'Jumlah Upload',
            data: {!! json_encode($monthlyChartData['data']) !!},
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection
