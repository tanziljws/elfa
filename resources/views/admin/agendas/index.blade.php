@extends('layouts.admin')

@section('title', 'Kelola Agenda')
@section('page-title', 'Kelola Agenda')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Agenda Sekolah</h4>
            <a href="{{ route('admin.agendas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Agenda
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
                    <th width="25%">Judul</th>
                    <th width="10%">Tanggal</th>
                    <th width="15%">Waktu</th>
                    <th width="15%">Lokasi</th>
                    <th width="10%">Kategori</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendas as $index => $agenda)
                <tr>
                    <td>{{ $agendas->firstItem() + $index }}</td>
                    <td>{{ $agenda->title }}</td>
                    <td>{{ $agenda->date->format('d M Y') }}</td>
                    <td>{{ $agenda->time }}</td>
                    <td>{{ $agenda->location }}</td>
                    <td><span class="badge bg-primary">{{ $agenda->category }}</span></td>
                    <td>
                        <form action="{{ route('admin.agendas.toggle-status', $agenda) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-{{ $agenda->is_active ? 'success' : 'secondary' }}">
                                <i class="fas fa-{{ $agenda->is_active ? 'check' : 'times' }}"></i>
                                {{ $agenda->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.agendas.edit', $agenda) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.agendas.destroy', $agenda) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
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
                    <td colspan="8" class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada agenda</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($agendas->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $agendas->links() }}
    </div>
    @endif
</div>
@endsection
