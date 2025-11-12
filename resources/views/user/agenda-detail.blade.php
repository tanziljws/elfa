@extends('layouts.user')

@section('title', 'Detail Agenda - ' . $agenda->title)

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <i class="fas fa-calendar-check me-3"></i>Detail Agenda
                </h1>
                <p class="page-subtitle">Informasi lengkap tentang kegiatan</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('user.agenda') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Agenda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Agenda Detail Content -->
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Main Card -->
            <div class="agenda-detail-card">
                <!-- Header Image -->
                @if($agenda->image)
                <div class="agenda-detail-header" style="background-image: url('{{ asset($agenda->image) }}');">
                    <div class="header-overlay">
                        <div class="header-content">
                            <span class="category-badge">{{ $agenda->category }}</span>
                            <h1 class="agenda-detail-title">{{ $agenda->title }}</h1>
                        </div>
                    </div>
                </div>
                @else
                <div class="agenda-detail-header no-image">
                    <div class="header-overlay">
                        <div class="header-content">
                            <span class="category-badge">{{ $agenda->category }}</span>
                            <h1 class="agenda-detail-title">{{ $agenda->title }}</h1>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Content Body -->
                <div class="agenda-detail-body">
                    <!-- Quick Info Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value">{{ $agenda->date->format('d M Y') }}</div>
                                    <div class="info-extra">{{ $agenda->date->format('l') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Waktu</div>
                                    @if($agenda->start_time && $agenda->end_time)
                                        <div class="info-value">{{ date('H:i', strtotime($agenda->start_time)) }} - {{ date('H:i', strtotime($agenda->end_time)) }}</div>
                                    @else
                                        <div class="info-value">{{ $agenda->time }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Lokasi</div>
                                    <div class="info-value">{{ $agenda->location }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Kategori</div>
                                    <div class="info-value">{{ $agenda->category }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Sections -->
                    <div class="detail-sections">
                        <!-- Deskripsi Kegiatan -->
                        <div class="detail-section">
                            <div class="section-header">
                                <i class="fas fa-file-alt"></i>
                                <h3>Deskripsi Kegiatan</h3>
                            </div>
                            <div class="section-content">
                                <p>{{ $agenda->description }}</p>
                            </div>
                        </div>

                        <!-- Jadwal Rinci -->
                        <div class="detail-section">
                            <div class="section-header">
                                <i class="fas fa-calendar-day"></i>
                                <h3>Jadwal Rinci</h3>
                            </div>
                            <div class="section-content">
                                <div class="schedule-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="schedule-label"><i class="fas fa-calendar"></i> Hari</td>
                                                <td class="schedule-value">{{ $agenda->date->format('l, d F Y') }}</td>
                                            </tr>
                                            @if($agenda->start_time)
                                            <tr>
                                                <td class="schedule-label"><i class="fas fa-clock"></i> Jam Mulai</td>
                                                <td class="schedule-value">{{ date('H:i', strtotime($agenda->start_time)) }} WIB</td>
                                            </tr>
                                            @endif
                                            @if($agenda->end_time)
                                            <tr>
                                                <td class="schedule-label"><i class="fas fa-clock"></i> Jam Selesai</td>
                                                <td class="schedule-value">{{ date('H:i', strtotime($agenda->end_time)) }} WIB</td>
                                            </tr>
                                            @endif
                                            @if($agenda->start_time && $agenda->end_time)
                                            <tr>
                                                <td class="schedule-label"><i class="fas fa-hourglass-half"></i> Durasi</td>
                                                <td class="schedule-value">
                                                    @php
                                                        $start = strtotime($agenda->start_time);
                                                        $end = strtotime($agenda->end_time);
                                                        $diff = $end - $start;
                                                        $hours = floor($diff / 3600);
                                                        $minutes = floor(($diff % 3600) / 60);
                                                    @endphp
                                                    {{ $hours > 0 ? $hours . ' jam ' : '' }}{{ $minutes > 0 ? $minutes . ' menit' : '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td class="schedule-label"><i class="fas fa-map-marker-alt"></i> Tempat</td>
                                                <td class="schedule-value">{{ $agenda->location }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons mt-4">
                        <a href="{{ route('user.agenda') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Agenda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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

/* Agenda Detail Card */
.agenda-detail-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Header Image */
.agenda-detail-header {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 400px;
    position: relative;
}

.agenda-detail-header.no-image {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.7));
    display: flex;
    align-items: flex-end;
    padding: 40px;
}

.header-content {
    width: 100%;
}

.category-badge {
    display: inline-block;
    background: rgba(78, 115, 223, 0.9);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.agenda-detail-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

/* Content Body */
.agenda-detail-body {
    padding: 40px;
}

/* Info Cards */
.info-card {
    background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    height: 100%;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(78, 115, 223, 0.15);
    border-color: #4e73df;
}

.info-icon {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.info-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 2px;
}

.info-extra {
    font-size: 0.85rem;
    color: #6c757d;
}

/* Detail Sections */
.detail-sections {
    margin-top: 30px;
}

.detail-section {
    background: white;
    border: 2px solid #e3e6f0;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 25px;
    transition: all 0.3s ease;
}

.detail-section:hover {
    border-color: #4e73df;
    box-shadow: 0 5px 15px rgba(78, 115, 223, 0.1);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e3e6f0;
}

.section-header i {
    color: #4e73df;
    font-size: 1.5rem;
}

.section-header h3 {
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.section-content {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.8;
}

.section-content p {
    margin: 0;
    white-space: pre-line;
}

/* Schedule Table */
.schedule-table {
    background: #f8f9fc;
    border-radius: 10px;
    padding: 20px;
}

.schedule-table .table {
    margin: 0;
}

.schedule-table .table tbody tr {
    border-bottom: 1px solid #e3e6f0;
}

.schedule-table .table tbody tr:last-child {
    border-bottom: none;
}

.schedule-table .table td {
    padding: 15px;
    border: none;
}

.schedule-label {
    font-weight: 600;
    color: #2c3e50;
    width: 200px;
}

.schedule-label i {
    color: #4e73df;
    margin-right: 10px;
}

.schedule-value {
    color: #6c757d;
    font-size: 1rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    padding-top: 30px;
    border-top: 2px solid #e3e6f0;
}

.btn-outline-primary {
    border: 2px solid #4e73df;
    color: #4e73df;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #4e73df;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .agenda-detail-title {
        font-size: 1.8rem;
    }
    
    .agenda-detail-body {
        padding: 25px;
    }
    
    .header-overlay {
        padding: 25px;
    }
    
    .detail-section {
        padding: 20px;
    }
    
    .schedule-label {
        width: auto;
        display: block;
        padding-bottom: 5px !important;
    }
    
    .schedule-value {
        display: block;
        padding-top: 0 !important;
    }
    
    .schedule-table .table td {
        padding: 10px;
    }
}
</style>
@endsection
