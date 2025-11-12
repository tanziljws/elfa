@extends('layouts.admin')

@section('title', 'Detail Foto')
@section('page-title', 'Detail Foto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-eye me-2"></i>Detail Foto</h5>
            </div>
            <div class="p-3">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" 
                             class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-md-6">
                        <h4>{{ $gallery->title }}</h4>
                        
                        <div class="mb-3">
                            <strong>Kategori:</strong>
                            <span class="badge bg-primary ms-2">
                                @php
                                    $categoryNames = [
                                        'academic' => 'Akademik',
                                        'extracurricular' => 'Ekstrakurikuler',
                                        'event' => 'Acara & Event',
                                        'general' => 'Fasilitas Umum'
                                    ];
                                @endphp
                                {{ $categoryNames[$gallery->category] ?? $gallery->category }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <strong>Status:</strong>
                            @if($gallery->is_active)
                                <span class="badge bg-success ms-2">Aktif</span>
                            @else
                                <span class="badge bg-secondary ms-2">Tidak Aktif</span>
                            @endif
                        </div>

                        @if($gallery->description)
                        <div class="mb-3">
                            <strong>Deskripsi:</strong>
                            <p class="mt-2">{{ $gallery->description }}</p>
                        </div>
                        @endif

                        <div class="mb-3">
                            <strong>Tanggal Dibuat:</strong>
                            <p class="mt-1">{{ $gallery->created_at->format('d F Y, H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Terakhir Diupdate:</strong>
                            <p class="mt-1">{{ $gallery->updated_at->format('d F Y, H:i') }}</p>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form method="POST" action="{{ route('admin.galleries.toggle-status', $gallery->id) }}" 
                                  style="display: inline;" onsubmit="return confirm('Ubah status foto ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $gallery->is_active ? 'warning' : 'success' }}">
                                    <i class="fas fa-{{ $gallery->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                    {{ $gallery->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.galleries.destroy', $gallery->id) }}" 
                                  style="display: inline;" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-external-link-alt me-2"></i>Lihat di Galeri Publik
            </a>
        </div>
    </div>
</div>
@endsection
