@extends('layouts.admin')

@section('title', 'Edit Halaman Tentang')
@section('page-title', 'Edit Halaman Tentang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-edit me-2"></i>Form Edit Halaman Tentang</h5>
                <a href="{{ route('about') }}" target="_blank" class="btn btn-sm btn-info">
                    <i class="fas fa-eye me-1"></i>Lihat Halaman
                </a>
            </div>
            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
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

                <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Header Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-heading me-2"></i>Header Halaman</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $about->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subtitle" class="form-label">Subtitle <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                           id="subtitle" name="subtitle" value="{{ old('subtitle', $about->subtitle) }}" required>
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image_path" class="form-label">Gambar Header</label>
                                @if($about->image_path)
                                    <div class="mb-2">
                                        <img src="{{ $about->image_url }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image_path') is-invalid @enderror" 
                                       id="image_path" name="image_path" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, WEBP. Max: 2MB</small>
                                @error('image_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- History Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-history me-2"></i>Sejarah Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="history_title" class="form-label">Judul Sejarah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('history_title') is-invalid @enderror" 
                                       id="history_title" name="history_title" value="{{ old('history_title', $about->history_title) }}" required>
                                @error('history_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="history_content" class="form-label">Konten Sejarah <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('history_content') is-invalid @enderror" 
                                          id="history_content" name="history_content" rows="4" required>{{ old('history_content', $about->history_content) }}</textarea>
                                @error('history_content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="development_title" class="form-label">Judul Perkembangan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('development_title') is-invalid @enderror" 
                                       id="development_title" name="development_title" value="{{ old('development_title', $about->development_title) }}" required>
                                @error('development_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="development_content" class="form-label">Konten Perkembangan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('development_content') is-invalid @enderror" 
                                          id="development_content" name="development_content" rows="4" required>{{ old('development_content', $about->development_content) }}</textarea>
                                @error('development_content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Vision & Mission Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-bullseye me-2"></i>Visi & Misi</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="vision_title" class="form-label">Judul Visi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('vision_title') is-invalid @enderror" 
                                       id="vision_title" name="vision_title" value="{{ old('vision_title', $about->vision_title) }}" required>
                                @error('vision_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="vision_content" class="form-label">Konten Visi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('vision_content') is-invalid @enderror" 
                                          id="vision_content" name="vision_content" rows="3" required>{{ old('vision_content', $about->vision_content) }}</textarea>
                                @error('vision_content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mission_title" class="form-label">Judul Misi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('mission_title') is-invalid @enderror" 
                                       id="mission_title" name="mission_title" value="{{ old('mission_title', $about->mission_title) }}" required>
                                @error('mission_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Item Misi <span class="text-danger">*</span></label>
                                <div id="mission-items">
                                    @foreach(old('mission_items', $about->mission_items ?? []) as $index => $item)
                                    <div class="input-group mb-2 mission-item">
                                        <input type="text" class="form-control" name="mission_items[]" value="{{ $item }}" required>
                                        <button type="button" class="btn btn-danger remove-mission" onclick="removeMissionItem(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-success" onclick="addMissionItem()">
                                    <i class="fas fa-plus me-1"></i>Tambah Item Misi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fas fa-school me-2"></i>Profil Sekolah</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Gambar Profil</label>
                                @if($about->profile_image)
                                    <div class="mb-2">
                                        <img src="{{ $about->profile_image_url }}" alt="Profile Image" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                       id="profile_image" name="profile_image" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, WEBP. Max: 2MB</small>
                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="2" required>{{ old('address', $about->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $about->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $about->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="website" class="form-label">Website <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror" 
                                       id="website" name="website" value="{{ old('website', $about->website) }}" required>
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Competencies Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Kompetensi Keahlian</h6>
                        </div>
                        <div class="card-body">
                            <div id="competencies">
                                @foreach(old('competencies', $about->competencies ?? []) as $index => $competency)
                                <div class="card mb-2 competency-item">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Icon Class</label>
                                                <input type="text" class="form-control" name="competencies[{{ $index }}][icon]" 
                                                       value="{{ $competency['icon'] ?? '' }}" placeholder="fas fa-code text-primary" required>
                                                <small class="text-muted">Contoh: fas fa-code text-primary</small>
                                            </div>
                                            <div class="col-md-7 mb-2">
                                                <label class="form-label">Nama Kompetensi</label>
                                                <input type="text" class="form-control" name="competencies[{{ $index }}][name]" 
                                                       value="{{ $competency['name'] ?? '' }}" required>
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger w-100" onclick="removeCompetency(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="addCompetency()">
                                <i class="fas fa-plus me-1"></i>Tambah Kompetensi
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let missionIndex = {{ count(old('mission_items', $about->mission_items ?? [])) }};
let competencyIndex = {{ count(old('competencies', $about->competencies ?? [])) }};

function addMissionItem() {
    const html = `
        <div class="input-group mb-2 mission-item">
            <input type="text" class="form-control" name="mission_items[]" required>
            <button type="button" class="btn btn-danger remove-mission" onclick="removeMissionItem(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    document.getElementById('mission-items').insertAdjacentHTML('beforeend', html);
    missionIndex++;
}

function removeMissionItem(button) {
    if (document.querySelectorAll('.mission-item').length > 1) {
        button.closest('.mission-item').remove();
    } else {
        alert('Minimal harus ada 1 item misi!');
    }
}

function addCompetency() {
    const html = `
        <div class="card mb-2 competency-item">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Icon Class</label>
                        <input type="text" class="form-control" name="competencies[${competencyIndex}][icon]" 
                               placeholder="fas fa-code text-primary" required>
                        <small class="text-muted">Contoh: fas fa-code text-primary</small>
                    </div>
                    <div class="col-md-7 mb-2">
                        <label class="form-label">Nama Kompetensi</label>
                        <input type="text" class="form-control" name="competencies[${competencyIndex}][name]" required>
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger w-100" onclick="removeCompetency(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById('competencies').insertAdjacentHTML('beforeend', html);
    competencyIndex++;
}

function removeCompetency(button) {
    if (document.querySelectorAll('.competency-item').length > 1) {
        button.closest('.competency-item').remove();
    } else {
        alert('Minimal harus ada 1 kompetensi!');
    }
}
</script>
@endpush
@endsection
