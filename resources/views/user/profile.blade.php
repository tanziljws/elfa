@extends('layouts.user')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-description', 'Kelola informasi profil Anda')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(!$user->student_id || !$user->class)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Profil Belum Lengkap!</strong> Anda harus melengkapi NISN, Nama Lengkap, dan Kelas untuk dapat menggunakan fitur like, dislike, komentar, dan download foto.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class="fas fa-user me-2"></i>Informasi Profil</h5>
            </div>
            <div class="p-4 text-center">
                <div class="mb-3">
                    @if($user->profile_photo)
                        <img src="{{ asset($user->profile_photo) }}" alt="Profile Photo" 
                             class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    @endif
                </div>
                <h5 class="mb-1">{{ $user->name ?? 'Belum diisi' }}</h5>
                <p class="text-muted mb-2">{{ $user->role }}</p>
                @if($user->student_id)
                    <p class="text-muted mb-1"><small>NISN: {{ $user->student_id }}</small></p>
                @endif
                @if($user->class)
                    <span class="badge bg-success">{{ $user->class }}</span>
                @else
                    <span class="badge bg-danger">Profil Belum Lengkap</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5>
                    <i class="fas fa-user-edit me-2"></i>
                    @if($user->student_id || $user->class || $user->profile_photo)
                        Edit Profil
                    @else
                        Lengkapi Profil
                    @endif
                </h5>
            </div>
            <div class="p-4">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">Foto Profil (Opsional)</label>
                        @if($user->profile_photo)
                            <div class="mb-2">
                                <img src="{{ asset($user->profile_photo) }}" alt="Current Photo" 
                                     class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                <p class="text-muted small mt-1 mb-0">Foto profil saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                               id="profile_photo" name="profile_photo" accept="image/*" onchange="previewPhoto(event)">
                        <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB</small>
                        @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="photoPreview" class="mt-2" style="display: none;">
                            <img id="preview" src="" alt="Preview" class="rounded-circle" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            <p class="text-muted small mt-1">Preview foto baru</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ $user->name }}" placeholder="Masukkan nama lengkap Anda" required>
                        <small class="text-muted">Nama yang akan ditampilkan di profil Anda</small>
                    </div>

                    <div class="mb-3">
                        <label for="student_id" class="form-label">NISN (Nomor Induk Siswa Nasional) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('student_id') is-invalid @enderror" 
                               id="student_id" name="student_id" 
                               value="{{ old('student_id', $user->student_id) }}" 
                               placeholder="Contoh: 0051234567" 
                               required>
                        <small class="text-muted">Masukkan 10 digit NISN Anda</small>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select class="form-select @error('class') is-invalid @enderror" 
                                id="class" name="class" required>
                            <option value="" {{ !$user->class ? 'selected' : '' }} disabled>Contoh: XII RPL 1</option>
                            <option value="X PPLG 1" {{ $user->class == 'X PPLG 1' ? 'selected' : '' }}>X PPLG 1</option>
                            <option value="X PPLG 2" {{ $user->class == 'X PPLG 2' ? 'selected' : '' }}>X PPLG 2</option>
                            <option value="X TJKT 1" {{ $user->class == 'X TJKT 1' ? 'selected' : '' }}>X TJKT 1</option>
                            <option value="X TJKT 2" {{ $user->class == 'X TJKT 2' ? 'selected' : '' }}>X TJKT 2</option>
                            <option value="X TJKT 3" {{ $user->class == 'X TJKT 3' ? 'selected' : '' }}>X TJKT 3</option>
                            <option value="X TP 1" {{ $user->class == 'X TP 1' ? 'selected' : '' }}>X TP 1</option>
                            <option value="X TP 2" {{ $user->class == 'X TP 2' ? 'selected' : '' }}>X TP 2</option>
                            <option value="X TP 3" {{ $user->class == 'X TP 3' ? 'selected' : '' }}>X TP 3</option>
                            <option value="X TO 1" {{ $user->class == 'X TO 1' ? 'selected' : '' }}>X TO 1</option>
                            <option value="X TO 2" {{ $user->class == 'X TO 2' ? 'selected' : '' }}>X TO 2</option>
                            <option value="XI PPLG 1" {{ $user->class == 'XI PPLG 1' ? 'selected' : '' }}>XI PPLG 1</option>
                            <option value="XI PPLG 2" {{ $user->class == 'XI PPLG 2' ? 'selected' : '' }}>XI PPLG 2</option>
                            <option value="XI TJKT 1" {{ $user->class == 'XI TJKT 1' ? 'selected' : '' }}>XI TJKT 1</option>
                            <option value="XI TJKT 2" {{ $user->class == 'XI TJKT 2' ? 'selected' : '' }}>XI TJKT 2</option>
                            <option value="XI TJKT 3" {{ $user->class == 'XI TJKT 3' ? 'selected' : '' }}>XI TJKT 3</option>
                            <option value="XI TP 1" {{ $user->class == 'XI TP 1' ? 'selected' : '' }}>XI TP 1</option>
                            <option value="XI TP 2" {{ $user->class == 'XI TP 2' ? 'selected' : '' }}>XI TP 2</option>
                            <option value="XI TP 3" {{ $user->class == 'XI TP 3' ? 'selected' : '' }}>XI TP 3</option>
                            <option value="XI TO 1" {{ $user->class == 'XI TO 1' ? 'selected' : '' }}>XI TO 1</option>
                            <option value="XI TO 2" {{ $user->class == 'XI TO 2' ? 'selected' : '' }}>XI TO 2</option>
                            <option value="XII PPLG 1" {{ $user->class == 'XII PPLG 1' ? 'selected' : '' }}>XII PPLG 1</option>
                            <option value="XII PPLG 2" {{ $user->class == 'XII PPLG 2' ? 'selected' : '' }}>XII PPLG 2</option>
                            <option value="XII PPLG 3" {{ $user->class == 'XII PPLG 3' ? 'selected' : '' }}>XII PPLG 3</option>
                            <option value="XII TJKT 1" {{ $user->class == 'XII TJKT 1' ? 'selected' : '' }}>XII TJKT 1</option>
                            <option value="XII TJKT 2" {{ $user->class == 'XII TJKT 2' ? 'selected' : '' }}>XII TJKT 2</option>
                            <option value="XII TJKT 3" {{ $user->class == 'XII TJKT 3' ? 'selected' : '' }}>XII TJKT 3</option>
                            <option value="XII TP 1" {{ $user->class == 'XII TP 1' ? 'selected' : '' }}>XII TP 1</option>
                            <option value="XII TP 2" {{ $user->class == 'XII TP 2' ? 'selected' : '' }}>XII TP 2</option>
                            <option value="XII TO 1" {{ $user->class == 'XII TO 1' ? 'selected' : '' }}>XII TO 1</option>
                            <option value="XII TO 2" {{ $user->class == 'XII TO 2' ? 'selected' : '' }}>XII TO 2</option>
                        </select>
                        <small class="text-muted">Pilih kelas Anda saat ini</small>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Ganti Password (Opsional)</h6>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" 
                               placeholder="Masukkan password lama">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" 
                               placeholder="Masukkan password baru">
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewPhoto(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('photoPreview');
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
