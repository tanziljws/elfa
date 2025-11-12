@extends('layouts.admin')

@section('title', 'Tambah Agenda')
@section('page-title', 'Tambah Agenda')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-calendar-plus me-2"></i>Form Tambah Agenda</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.agendas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Agenda <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('time') is-invalid @enderror" 
                                   id="time" name="time" value="{{ old('time') }}" 
                                   placeholder="Contoh: 08:00 - 10:00 WIB" required>
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Upacara" {{ old('category') == 'Upacara' ? 'selected' : '' }}>Upacara</option>
                                <option value="Lomba" {{ old('category') == 'Lomba' ? 'selected' : '' }}>Lomba</option>
                                <option value="Pelatihan" {{ old('category') == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="Rapat" {{ old('category') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                                <option value="Kunjungan" {{ old('category') == 'Kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                                <option value="Workshop" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="Umum" {{ old('category') == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                   id="start_time" name="start_time" value="{{ old('start_time') }}">
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                   id="end_time" name="end_time" value="{{ old('end_time') }}">
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Agenda (Opsional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        @php
                            $maxSize = \App\Models\Setting::get('upload_max_file_size', 10240);
                            $maxMB = round($maxSize / 1024, 1);
                            $allowedExt = \App\Models\Setting::get('upload_allowed_extensions', 'jpg,jpeg,png,gif');
                        @endphp
                        <small class="text-muted">Format: {{ strtoupper(str_replace(',', ', ', $allowedExt)) }}. Maksimal {{ $maxMB }}MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="preview" src="" alt="Preview" style="max-width: 200px; border-radius: 8px;">
                        </div>
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
                        <a href="{{ route('admin.agendas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Agenda
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Panduan</h5>
            </div>
            <div class="p-4">
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Isi semua field yang bertanda *</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Format waktu: HH:MM - HH:MM WIB</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pilih kategori yang sesuai</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Centang "Aktif" untuk menampilkan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewDiv.style.display = 'none';
    }
}
</script>
@endsection
