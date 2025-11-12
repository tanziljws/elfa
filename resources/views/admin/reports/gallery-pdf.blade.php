<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Galeri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4e73df;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #4e73df;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background: #f8f9fc;
        }
        .stats-cell h3 {
            margin: 0;
            font-size: 28px;
            color: #4e73df;
        }
        .stats-cell p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background: #4e73df;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background: #f8f9fc;
        }
        .section-title {
            background: #4e73df;
            color: white;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .engagement-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .engagement-row {
            display: table-row;
        }
        .engagement-cell {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .engagement-cell h4 {
            margin: 0 0 10px 0;
            color: #4e73df;
        }
        .engagement-item {
            margin: 5px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN GALERI FOTO</h1>
        <p>SMK Negeri 4 Bogor</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <!-- Statistik Utama -->
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <h3>{{ $totalPhotos }}</h3>
                <p>Total Foto</p>
            </div>
            <div class="stats-cell">
                <h3>{{ $totalLikes }}</h3>
                <p>Total Likes</p>
            </div>
            <div class="stats-cell">
                <h3>{{ $totalComments }}</h3>
                <p>Total Komentar</p>
            </div>
            <div class="stats-cell">
                <h3>{{ $activePhotos }}</h3>
                <p>Foto Aktif</p>
            </div>
        </div>
    </div>

    <!-- Engagement Statistics -->
    <div class="section-title">STATISTIK ENGAGEMENT</div>
    <div class="engagement-grid">
        <div class="engagement-row">
            <div class="engagement-cell">
                <h4>Status Foto</h4>
                <div class="engagement-item">Aktif: <strong>{{ $activePhotos }}</strong></div>
                <div class="engagement-item">Nonaktif: <strong>{{ $inactivePhotos }}</strong></div>
            </div>
            <div class="engagement-cell">
                <h4>Interaksi</h4>
                <div class="engagement-item">Likes: <strong>{{ $totalLikes }}</strong></div>
                <div class="engagement-item">Dislikes: <strong>{{ $totalDislikes }}</strong></div>
            </div>
            <div class="engagement-cell">
                <h4>Komentar</h4>
                <div class="engagement-item">Disetujui: <strong>{{ $approvedComments }}</strong></div>
                <div class="engagement-item">Pending: <strong>{{ $pendingComments }}</strong></div>
            </div>
        </div>
    </div>

    <!-- Detail Per Kategori -->
    <div class="section-title">DETAIL PER KATEGORI</div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah Foto</th>
                <th>Total Likes</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryStats as $key => $stat)
            <tr>
                <td>{{ $stat['name'] }}</td>
                <td>{{ $stat['count'] }}</td>
                <td>{{ $stat['likes'] }}</td>
                <td>
                    @php
                        $percentage = $totalPhotos > 0 ? round(($stat['count'] / $totalPhotos) * 100, 1) : 0;
                    @endphp
                    {{ $percentage }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Top 10 Foto Terpopuler -->
    <div class="section-title">TOP 10 FOTO TERPOPULER (LIKES)</div>
    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="60%">Judul</th>
                <th width="15%">Kategori</th>
                <th width="15%">Likes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topLikedPhotos as $index => $photo)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $photo->title }}</td>
                <td>{{ $photo->category }}</td>
                <td>{{ $photo->likes_count }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Top 10 Foto Paling Dikomentari -->
    <div class="section-title">TOP 10 FOTO PALING DIKOMENTARI</div>
    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="60%">Judul</th>
                <th width="15%">Kategori</th>
                <th width="15%">Komentar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topCommentedPhotos as $index => $photo)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $photo->title }}</td>
                <td>{{ $photo->category }}</td>
                <td>{{ $photo->comments_count }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini digenerate otomatis pada {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
        <p>© {{ date('Y') }} SMK Negeri 4 Bogor - Sistem Galeri Foto</p>
    </div>
</body>
</html>
