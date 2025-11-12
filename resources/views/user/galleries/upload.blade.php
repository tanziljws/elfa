@extends('layouts.user')

@section('title', 'Upload Foto')
@section('page-title', 'Upload Foto')
@section('page-description', 'Upload foto kegiatan sekolah ke galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-cloud-upload-alt me-2"></i>Upload Foto Baru</h5>
            </div>
            <div class="p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.galleries.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Pilih Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*" required>
                        <div class="form-text">
                            Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 5MB.
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3" id="imagePreview" style="display: none;">
                        <label class="form-label">Preview Foto</label>
                        <div class="text-center">
                            <img id="previewImg" src="" alt="Preview" 
                                 style="max-width: 100%; max-height: 300px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <i class="fas fa-cloud-upload-alt me-1"></i>Upload Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Upload Progress Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-success mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5>Mengupload Foto...</h5>
                <p class="text-muted mb-0">Mohon tunggu, foto sedang diupload</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadForm = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));

    // Image preview
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Check file size (5MB = 5 * 1024 * 1024 bytes)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                imageInput.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('File yang dipilih bukan gambar.');
                imageInput.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });

    // Form submission
    uploadForm.addEventListener('submit', function(e) {
        // Show loading modal
        uploadModal.show();
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';
    });

    // Auto-fill title from filename
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const titleInput = document.getElementById('title');
        
        if (file && !titleInput.value) {
            // Remove file extension and clean up filename
            let filename = file.name.replace(/\.[^/.]+$/, "");
            filename = filename.replace(/[_-]/g, ' ');
            filename = filename.replace(/\b\w/g, l => l.toUpperCase());
            titleInput.value = filename;
        }
    });
});
</script>
@endsection
