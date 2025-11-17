@extends('layouts.user')

@section('title', 'Kategori: ' . $currentCategory)
@section('page-title', 'Kategori: ' . $currentCategory)
@section('page-description', 'Foto-foto dalam kategori ' . $currentCategory)

@section('styles')
<style>
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 20px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            padding: 60px 0 40px;
            margin-bottom: 0;
            box-shadow: 0 4px 20px rgba(78, 115, 223, 0.3);
        }

        .page-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 0;
        }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-folder me-3"></i>Kategori: {{ $currentCategory }}
                </h1>
                <p class="page-subtitle">Foto-foto dalam kategori {{ $currentCategory }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('galleries.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Galeri
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Flash Messages -->
@if(session('success'))
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
</div>
@endif


<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Total: {{ $galleries->total() }} foto</h5>
                </div>
                <div>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($galleries->count() > 0)
    <div class="row g-4">
        @foreach($galleries as $gallery)
        <div class="col-md-4 col-lg-3">
            <div class="gallery-item" onclick="viewPhoto({{ $gallery->id }}, '{{ $gallery->image_url }}', '{{ addslashes($gallery->title) }}', '{{ addslashes($gallery->description) }}', '{{ $categoryNames[$gallery->category] ?? $gallery->category }}', '{{ $gallery->created_at->format('d M Y') }}')">
                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
                <div class="category-badge">{{ $categoryNames[$gallery->category] ?? $gallery->category }}</div>
                <div class="gallery-overlay">
                    <h6 class="mb-1">{{ $gallery->title }}</h6>
                    <small>{{ Str::limit($gallery->description, 80) ?: 'Tidak ada deskripsi' }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $galleries->links() }}
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="p-5 text-center">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h5>Belum Ada Foto di Kategori {{ $currentCategory }}</h5>
                    <p class="text-muted mb-4">Belum ada foto yang diupload dalam kategori ini.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Photo View Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="photoTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <img id="photoImage" src="" alt="" class="img-fluid rounded">
                    </div>
                    <div class="col-lg-4">
                        <div class="p-3">
                            <div class="mb-3">
                                <span id="photoBadge" class="badge bg-primary"></span>
                            </div>
                            <p id="photoDescription" class="text-muted"></p>
                            <hr>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                <span id="photoDate"></span>
                            </small>
                            
                            <!-- Like/Dislike/Download Buttons in Modal -->
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-outline-success" id="modalLikeBtn" onclick="toggleLike('like')">
                                    <i class="fas fa-thumbs-up"></i> <span id="modalLikeCount">0</span>
                                </button>
                                <button class="btn btn-outline-danger" id="modalDislikeBtn" onclick="toggleLike('dislike')">
                                    <i class="fas fa-thumbs-down"></i> <span id="modalDislikeCount">0</span>
                                </button>
                                <button class="btn btn-outline-primary ms-auto" onclick="downloadPhoto()">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                            
                            <!-- Comment Section -->
                            <div class="mt-4">
                                <h6 class="mb-3">Komentar (<span id="commentsCount">0</span>)</h6>
                                
                                <!-- Comment Form -->
                                <form id="commentForm" class="mb-3">
                                    <div class="mb-2">
                                        <textarea class="form-control form-control-sm" id="commentText" rows="3" placeholder="Tulis komentar..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
                                </form>
                                
                                <!-- Comments List -->
                                <div id="commentsList" style="max-height: 300px; overflow-y: auto;">
                                    <!-- Comments will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentPhotoId = null;

function viewPhoto(id, imageUrl, title, description, category, date) {
    currentPhotoId = id;
    
    document.getElementById('photoTitle').textContent = title;
    document.getElementById('photoImage').src = imageUrl;
    document.getElementById('photoImage').alt = title;
    document.getElementById('photoDescription').textContent = description || 'Tidak ada deskripsi';
    document.getElementById('photoBadge').textContent = category;
    document.getElementById('photoDate').textContent = date;
    
    // Reset like/dislike buttons
    document.getElementById('modalLikeCount').textContent = '0';
    document.getElementById('modalDislikeCount').textContent = '0';
    document.getElementById('modalLikeBtn').className = 'btn btn-outline-success';
    document.getElementById('modalDislikeBtn').className = 'btn btn-outline-danger';
    
    // Reset comments
    document.getElementById('commentsCount').textContent = '0';
    document.getElementById('commentsList').innerHTML = '';
    document.getElementById('commentText').value = '';
    
    // Load comments and like status
    loadComments(id);
    loadLikeStatus(id);
    
    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
}

function toggleLike(type) {
    if (!currentPhotoId) return;
    
    // Cek apakah user sudah login
    @guest
    alert('Anda harus login terlebih dahulu agar bisa mengakses fitur like, dislike, komen dan unduh foto');
    window.location.href = '{{ route("login") }}';
    return;
    @endguest
    
    // Toggle like/dislike
    fetch(`/api/galleries/${currentPhotoId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadLikeStatus(currentPhotoId);
        } else {
            alert(data.message || 'Gagal memberikan like/dislike');
        }
    })
    .catch(error => {
        console.error('Error toggling like:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

function downloadPhoto() {
    // Cek apakah user sudah login
    @guest
    alert('Anda harus login terlebih dahulu agar bisa mengakses fitur like, dislike, komen dan unduh foto');
    window.location.href = '{{ route("login") }}';
    return;
    @endguest
    
    // Implement download functionality
    alert('Fitur download akan segera tersedia');
}

// Load like/dislike status
async function loadLikeStatus(galleryId) {
    try {
        const response = await fetch(`/api/galleries/${galleryId}/like-status`);
        const data = await response.json();

        if (data.success) {
            document.getElementById('modalLikeCount').textContent = data.likes_count;
            document.getElementById('modalDislikeCount').textContent = data.dislikes_count;
            
            // Update button states
            const likeBtn = document.getElementById('modalLikeBtn');
            const dislikeBtn = document.getElementById('modalDislikeBtn');
            
            likeBtn.classList.remove('btn-success');
            dislikeBtn.classList.remove('btn-danger');
            likeBtn.classList.add('btn-outline-success');
            dislikeBtn.classList.add('btn-outline-danger');
            
            if (data.user_type === 'like') {
                likeBtn.classList.remove('btn-outline-success');
                likeBtn.classList.add('btn-success');
            } else if (data.user_type === 'dislike') {
                dislikeBtn.classList.remove('btn-outline-danger');
                dislikeBtn.classList.add('btn-danger');
            }
        }
    } catch (error) {
        console.error('Error loading like status:', error);
    }
}

// Load comments
async function loadComments(galleryId) {
    try {
        const response = await fetch(`/api/galleries/${galleryId}/comments`);
        const data = await response.json();

        if (data.success) {
            const commentsList = document.getElementById('commentsList');
            const commentsCount = document.getElementById('commentsCount');
            
            commentsList.innerHTML = '';
            commentsCount.textContent = data.data.length;
            
            if (data.data.length === 0) {
                commentsList.innerHTML = '<p class="text-muted small">Belum ada komentar</p>';
                return;
            }
            
            data.data.forEach(comment => {
                const commentDiv = document.createElement('div');
                commentDiv.className = 'border-bottom pb-2 mb-2';
                commentDiv.dataset.commentId = comment.id;
                
                // Foto profil user
                let userPhoto = '';
                if (comment.user && comment.user.profile_photo) {
                    userPhoto = `<img src="/${comment.user.profile_photo}" alt="${comment.user.name}" 
                                     class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">`;
                } else {
                    userPhoto = `<div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                                     style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                </div>`;
                }
                
                commentDiv.innerHTML = `
                    <div class="d-flex align-items-start">
                        ${userPhoto}
                        <div class="flex-grow-1">
                            <strong class="d-block">${comment.user ? comment.user.name : 'Anonymous'}</strong>
                            <small class="text-muted">${new Date(comment.created_at).toLocaleDateString('id-ID')}</small>
                            <p class="mb-0 mt-1">${comment.comment}</p>
                        </div>
                    </div>
                `;
                commentsList.appendChild(commentDiv);
            });
        }
    } catch (error) {
        console.error('Error loading comments:', error);
    }
}

// Submit comment
document.getElementById('commentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Cek apakah user sudah login
    @guest
    alert('Anda harus login terlebih dahulu agar bisa mengakses fitur like, dislike, komen dan unduh foto');
    window.location.href = '{{ route("login") }}';
    return;
    @endguest
    
    if (!currentPhotoId) return;
    
    const comment = document.getElementById('commentText').value;
    
    try {
        const response = await fetch(`/api/galleries/${currentPhotoId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                comment: comment
            })
        });

        const data = await response.json();

        if (data.success) {
            this.reset();
            loadComments(currentPhotoId);
            
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>Komentar berhasil ditambahkan!<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.getElementById('commentForm').insertAdjacentElement('beforebegin', alertDiv);
            
            setTimeout(() => alertDiv.remove(), 3000);
        } else {
            alert(data.message || 'Gagal mengirim komentar');
        }
    } catch (error) {
        console.error('Error submitting comment:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
});
</script>
@endsection