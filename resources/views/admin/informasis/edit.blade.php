@extends('layouts.admin')

@section('title', 'Edit Informasi')
@section('page-title', 'Edit Informasi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-edit me-2"></i>Form Edit Informasi</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.informasis.update', $informasi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Informasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $informasi->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $informasi->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Pengumuman" {{ old('category', $informasi->category) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="Prestasi" {{ old('category', $informasi->category) == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="Akademik" {{ old('category', $informasi->category) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Program" {{ old('category', $informasi->category) == 'Program' ? 'selected' : '' }}>Program</option>
                                <option value="Fasilitas" {{ old('category', $informasi->category) == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                <option value="Berita" {{ old('category', $informasi->category) == 'Berita' ? 'selected' : '' }}>Berita</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="badge" class="form-label">Warna Badge <span class="text-danger">*</span></label>
                            <select class="form-select @error('badge') is-invalid @enderror" 
                                    id="badge" name="badge" required>
                                <option value="success" {{ old('badge', $informasi->badge) == 'success' ? 'selected' : '' }}>Hijau (Success)</option>
                                <option value="info" {{ old('badge', $informasi->badge) == 'info' ? 'selected' : '' }}>Biru (Info)</option>
                                <option value="warning" {{ old('badge', $informasi->badge) == 'warning' ? 'selected' : '' }}>Kuning (Warning)</option>
                                <option value="primary" {{ old('badge', $informasi->badge) == 'primary' ? 'selected' : '' }}>Biru Tua (Primary)</option>
                                <option value="danger" {{ old('badge', $informasi->badge) == 'danger' ? 'selected' : '' }}>Merah (Danger)</option>
                            </select>
                            @error('badge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon FontAwesome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" name="icon" value="{{ old('icon', $informasi->icon) }}" 
                               placeholder="Contoh: fa-bullhorn, fa-trophy, fa-book" required>
                        <small class="text-muted">Gunakan class FontAwesome tanpa "fas". Contoh: fa-bullhorn</small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Informasi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="5" required>{{ old('content', $informasi->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', $informasi->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif (tampilkan di halaman user)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.informasis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Informasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Info</h5>
            </div>
            <div class="p-4">
                <p><strong>Dibuat:</strong><br>{{ $informasi->created_at->format('d M Y H:i') }}</p>
                <p><strong>Terakhir Diubah:</strong><br>{{ $informasi->updated_at->format('d M Y H:i') }}</p>
                <p><strong>Status:</strong><br>
                    <span class="badge bg-{{ $informasi->is_active ? 'success' : 'secondary' }}">
                        {{ $informasi->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </p>
                <p><strong>Badge Preview:</strong><br>
                    <span class="badge bg-{{ $informasi->badge }}">{{ ucfirst($informasi->badge) }}</span>
                </p>
                <p><strong>Icon Preview:</strong><br>
                    <i class="fas {{ $informasi->icon }} fa-2x"></i>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
