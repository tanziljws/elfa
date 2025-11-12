@extends('layouts.admin')

@section('title', 'Kelola Informasi')
@section('page-title', 'Kelola Informasi')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Informasi Sekolah</h4>
            <a href="{{ route('admin.informasis.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Informasi
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
                    <th width="10%">Tanggal</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Badge</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasis as $index => $info)
                <tr>
                    <td>{{ $informasis->firstItem() + $index }}</td>
                    <td>{{ Str::limit($info->title, 50) }}</td>
                    <td>{{ $info->date->format('d M Y') }}</td>
                    <td>{{ $info->category }}</td>
                    <td><span class="badge bg-{{ $info->badge }}">{{ ucfirst($info->badge) }}</span></td>
                    <td>
                        <form action="{{ route('admin.informasis.toggle-status', $info) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-{{ $info->is_active ? 'success' : 'secondary' }}">
                                <i class="fas fa-{{ $info->is_active ? 'check' : 'times' }}"></i>
                                {{ $info->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.informasis.edit', $info) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.informasis.destroy', $info) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">
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
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada informasi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($informasis->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $informasis->links() }}
    </div>
    @endif
</div>
@endsection
