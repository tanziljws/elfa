@extends('layouts.admin')

@section('title', 'Edit Agenda')
@section('page-title', 'Edit Agenda')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-edit me-2"></i>Form Edit Agenda</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.agendas.update', $agenda) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Agenda <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $agenda->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $agenda->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('time') is-invalid @enderror" 
                                   id="time" name="time" value="{{ old('time', $agenda->time) }}" 
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
                                   id="location" name="location" value="{{ old('location', $agenda->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Upacara" {{ old('category', $agenda->category) == 'Upacara' ? 'selected' : '' }}>Upacara</option>
                                <option value="Lomba" {{ old('category', $agenda->category) == 'Lomba' ? 'selected' : '' }}>Lomba</option>
                                <option value="Pelatihan" {{ old('category', $agenda->category) == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="Rapat" {{ old('category', $agenda->category) == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                                <option value="Kunjungan" {{ old('category', $agenda->category) == 'Kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                                <option value="Workshop" {{ old('category', $agenda->category) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="Umum" {{ old('category', $agenda->category) == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description', $agenda->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                   id="start_time" name="start_time" value="{{ old('start_time', $agenda->start_time ? date('H:i', strtotime($agenda->start_time)) : '') }}">
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                   id="end_time" name="end_time" value="{{ old('end_time', $agenda->end_time ? date('H:i', strtotime($agenda->end_time)) : '') }}">
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Agenda (Opsional)</label>
                        @if($agenda->image)
                            <div class="mb-2">
                                <img src="{{ asset($agenda->image) }}" alt="Current Image" style="max-width: 200px; border-radius: 8px;">
                                <p class="text-muted small mt-1">Gambar saat ini</p>
                            </div>
                        @endif
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
                            <p class="text-muted small mt-1">Preview gambar baru</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', $agenda->is_active) ? 'checked' : '' }}>
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
                            <i class="fas fa-save me-2"></i>Update Agenda
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Info Agenda</h5>
            </div>
            <div class="p-4">
                <p><strong>Dibuat:</strong><br>{{ $agenda->created_at->format('d M Y H:i') }}</p>
                <p><strong>Terakhir Diubah:</strong><br>{{ $agenda->updated_at->format('d M Y H:i') }}</p>
                <p><strong>Status:</strong><br>
                    <span class="badge bg-{{ $agenda->is_active ? 'success' : 'secondary' }}">
                        {{ $agenda->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </p>
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
