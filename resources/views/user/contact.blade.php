@extends('layouts.user')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <i class="fas fa-phone me-3"></i>{{ $contact->title }}
                </h1>
                <p class="page-subtitle">{{ $contact->subtitle }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<section class="contact-section py-5 bg-white">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="contact-card text-center">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="contact-title">Alamat</h5>
                            <p class="contact-text">{{ $contact->address }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-card text-center">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5 class="contact-title">Telepon</h5>
                            <p class="contact-text">{{ $contact->phone }}</p>
                            @if($contact->phone_alt)
                            <p class="contact-text">{{ $contact->phone_alt }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-card text-center">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="contact-title">Email</h5>
                            <p class="contact-text">{{ $contact->email }}</p>
                            @if($contact->email_alt)
                            <p class="contact-text">{{ $contact->email_alt }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="mb-4"><i class="fas fa-clock me-2"></i>Jam Operasional</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Senin - Jumat</strong></td>
                                                <td>: {{ $contact->office_hours_weekday }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Sabtu</strong></td>
                                                <td>: {{ $contact->office_hours_saturday }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Minggu & Libur</strong></td>
                                                <td>: {{ $contact->office_hours_sunday }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        @if($contact->note)
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Catatan:</strong> {{ $contact->note }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    padding: 60px 0 40px;
    margin-bottom: 40px;
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

/* Contact Card */
.contact-card {
    background: white;
    border-radius: 15px;
    padding: 40px 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 2px solid transparent;
    height: 100%;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(78, 115, 223, 0.15);
    border-color: #4e73df;
}

.contact-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 1.8rem;
    transition: transform 0.3s ease;
}

.contact-card:hover .contact-icon {
    transform: scale(1.1) rotate(5deg);
}

.contact-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
}

.contact-text {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 8px;
    line-height: 1.6;
}


/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-subtitle {
        font-size: 1rem;
    }
    
    .contact-card {
        padding: 30px 20px;
    }
}
</style>
@endsection
