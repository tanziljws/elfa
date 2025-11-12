@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Berita Sekolah</h4>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Berita
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Judul</th>
                    <th width="15%">Kategori</th>
                    <th width="15%">Penulis</th>
                    <th width="15%">Tanggal Publish</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $item)
                <tr>
                    <td>{{ $news->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($item->image)
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" 
                                 class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                            @endif
                            <div>
                                <strong>{{ Str::limit($item->title, 50) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($item->description, 60) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
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
                                'kegiatan' => 'Kegiatan',
                                'pengumuman' => 'Pengumuman'
                            ];
                        @endphp
                        <span class="badge bg-{{ $categoryColors[$item->category] ?? 'secondary' }}">
                            {{ $categoryNames[$item->category] ?? $item->category }}
                        </span>
                    </td>
                    <td>{{ $item->author ?? '-' }}</td>
                    <td>{{ $item->published_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('admin.news.toggle-status', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-{{ $item->is_active ? 'success' : 'secondary' }}">
                                <i class="fas fa-{{ $item->is_active ? 'check' : 'times' }}"></i>
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada berita</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $news->links() }}
</div>
@endsection
