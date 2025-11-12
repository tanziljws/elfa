@extends('layouts.admin')

@section('title', 'Edit Foto')
@section('page-title', 'Edit Foto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-edit me-2"></i>Form Edit Foto</h5>
            </div>
            <div class="p-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.galleries.update', $gallery->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $gallery->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $key => $name)
                            <option value="{{ $key }}" {{ old('category', $gallery->category) == $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Saat Ini</label>
                        <div class="text-center">
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" 
                                 class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Ganti Foto</label>
                        
                        <!-- Drag & Drop Area -->
                        <div class="upload-area @error('image') is-invalid @enderror" id="uploadArea">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <h5>Drag & Drop foto baru di sini</h5>
                                <p class="text-muted">atau klik untuk memilih file</p>
                                <input type="file" class="form-control d-none @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                            </div>
                        </div>
                        
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Kosongkan jika tidak ingin mengganti foto. Format yang didukung: {{ strtoupper(implode(', ', $allowedFormats)) }}. Ukuran maksimal: {{ $maxFileSize }}MB
                        </div>
                        @error('image')
                            <div class="alert alert-danger mt-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan foto (tampilkan di galeri publik)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.upload-area:hover {
    border-color: #667eea;
    background-color: #f0f2ff;
}

.upload-area.dragover {
    border-color: #667eea;
    background-color: #e8f0ff;
    transform: scale(1.02);
}

.upload-content {
    pointer-events: none;
}

.upload-area.has-file {
    border-color: #28a745;
    background-color: #f0fff4;
}

.upload-area.has-file .upload-content {
    display: none;
}

.image-preview {
    max-width: 100%;
    max-height: 300px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('image');
    
    // Click to upload
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Drag and drop events
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });
    
    // File input change
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });
    
    function handleFileSelect(file) {
        // Remove existing error messages
        const existingError = document.getElementById('fileError');
        if (existingError) {
            existingError.remove();
        }
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showError('Silakan pilih file gambar yang valid.');
            return;
        }
        
        // Validate file size (from settings)
        const maxSize = {{ $maxFileSize }} * 1024 * 1024; // Convert MB to bytes
        if (file.size > maxSize) {
            showError(`File terlalu besar! Ukuran maksimal adalah {{ $maxFileSize }}MB. File Anda: ${(file.size / 1024 / 1024).toFixed(2)}MB`);
            return;
        }
        
        // Validate file type (from settings)
        const allowedTypes = [
            @foreach($allowedFormats as $format)
                'image/{{ $format }}',
            @endforeach
        ];
        if (!allowedTypes.includes(file.type)) {
            showError('Format file tidak didukung! Gunakan {{ strtoupper(implode(', ', $allowedFormats)) }}.');
            return;
        }
        
        // If validation passes, show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            uploadArea.classList.add('has-file');
            
            // Create preview container
            const previewContainer = document.createElement('div');
            previewContainer.className = 'text-center';
            previewContainer.innerHTML = `
                <img src="${e.target.result}" class="image-preview mb-3" alt="Preview">
                <h6 class="text-success">${file.name}</h6>
                <p class="text-muted small">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetUpload()">
                    <i class="fas fa-times me-1"></i>Hapus
                </button>
            `;
            
            // Clear upload area and add preview
            uploadArea.innerHTML = '';
            uploadArea.appendChild(previewContainer);
            
            // Re-add the file input (hidden)
            const hiddenFileInput = document.createElement('input');
            hiddenFileInput.type = 'file';
            hiddenFileInput.name = 'image';
            hiddenFileInput.accept = 'image/*';
            hiddenFileInput.style.display = 'none';
            hiddenFileInput.files = fileInput.files;
            uploadArea.appendChild(hiddenFileInput);
        };
        reader.readAsDataURL(file);
    }
    
    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.id = 'fileError';
        errorDiv.className = 'alert alert-danger mt-2';
        errorDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>${message}
        `;
        uploadArea.parentNode.appendChild(errorDiv);
        
        // Clear the file input
        fileInput.value = '';
    }
    
    // Reset upload function
    window.resetUpload = function() {
        uploadArea.classList.remove('has-file');
        fileInput.value = '';
        uploadArea.innerHTML = `
            <div class="upload-content">
                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                <h5>Drag & Drop foto baru di sini</h5>
                <p class="text-muted">atau klik untuk memilih file</p>
            </div>
        `;
        
        // Re-add the file input
        const newFileInput = document.createElement('input');
        newFileInput.type = 'file';
        newFileInput.id = 'image';
        newFileInput.name = 'image';
        newFileInput.accept = 'image/*';
        newFileInput.style.display = 'none';
        uploadArea.appendChild(newFileInput);
        
        // Re-attach event listeners
        newFileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });
        
        // Update fileInput reference
        fileInput = newFileInput;
    };
});
</script>
@endsection
