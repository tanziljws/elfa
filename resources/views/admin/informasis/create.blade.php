@extends('layouts.admin')

@section('title', 'Tambah Informasi')
@section('page-title', 'Tambah Informasi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-plus-circle me-2"></i>Form Tambah Informasi</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.informasis.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Informasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Pengumuman" {{ old('category') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="Prestasi" {{ old('category') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="Akademik" {{ old('category') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Program" {{ old('category') == 'Program' ? 'selected' : '' }}>Program</option>
                                <option value="Fasilitas" {{ old('category') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                <option value="Berita" {{ old('category') == 'Berita' ? 'selected' : '' }}>Berita</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="badge" class="form-label">Warna Badge <span class="text-danger">*</span></label>
                            <select class="form-select @error('badge') is-invalid @enderror" 
                                    id="badge" name="badge" required>
                                <option value="success" {{ old('badge') == 'success' ? 'selected' : '' }}>Hijau (Success)</option>
                                <option value="info" {{ old('badge') == 'info' ? 'selected' : '' }}>Biru (Info)</option>
                                <option value="warning" {{ old('badge') == 'warning' ? 'selected' : '' }}>Kuning (Warning)</option>
                                <option value="primary" {{ old('badge', 'primary') == 'primary' ? 'selected' : '' }}>Biru Tua (Primary)</option>
                                <option value="danger" {{ old('badge') == 'danger' ? 'selected' : '' }}>Merah (Danger)</option>
                            </select>
                            @error('badge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon FontAwesome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" name="icon" value="{{ old('icon', 'fa-info-circle') }}" 
                               placeholder="Contoh: fa-bullhorn, fa-trophy, fa-book" required>
                        <small class="text-muted">Gunakan class FontAwesome tanpa "fas". Contoh: fa-bullhorn</small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Informasi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
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
                            <i class="fas fa-save me-2"></i>Simpan Informasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-palette me-2"></i>Preview Badge</h5>
            </div>
            <div class="p-4">
                <p><span class="badge bg-success">Success</span> - Pengumuman positif</p>
                <p><span class="badge bg-info">Info</span> - Informasi umum</p>
                <p><span class="badge bg-warning">Warning</span> - Peringatan</p>
                <p><span class="badge bg-primary">Primary</span> - Akademik</p>
                <p><span class="badge bg-danger">Danger</span> - Urgent</p>
            </div>
        </div>

        <div class="table-card mt-3">
            <div class="table-card-header">
                <h5><i class="fas fa-icons me-2"></i>Icon Populer</h5>
            </div>
            <div class="p-4">
                <p><i class="fas fa-bullhorn"></i> fa-bullhorn - Pengumuman</p>
                <p><i class="fas fa-trophy"></i> fa-trophy - Prestasi</p>
                <p><i class="fas fa-book"></i> fa-book - Akademik</p>
                <p><i class="fas fa-briefcase"></i> fa-briefcase - Program</p>
                <p><i class="fas fa-tools"></i> fa-tools - Fasilitas</p>
                <p><i class="fas fa-newspaper"></i> fa-newspaper - Berita</p>
            </div>
        </div>
    </div>
</div>
@endsection
