# Script untuk mengecek status MySQL XAMPP

Write-Host "=== Cek Status MySQL XAMPP ===" -ForegroundColor Green

# Path ke MySQL XAMPP
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"

# Cek apakah MySQL XAMPP ada
if (Test-Path $mysqlPath) {
    Write-Host "✓ MySQL XAMPP ditemukan di: $mysqlPath" -ForegroundColor Green
} else {
    Write-Host "✗ MySQL XAMPP tidak ditemukan di: $mysqlPath" -ForegroundColor Red
    Write-Host "Pastikan XAMPP sudah terinstall." -ForegroundColor Yellow
    exit 1
}

# Cek apakah MySQL service berjalan
Write-Host "`nMengecek koneksi MySQL..." -ForegroundColor Yellow

try {
    $result = & $mysqlPath -u root -e "SELECT 1;" 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ MySQL service berjalan dengan baik!" -ForegroundColor Green
        
        # Cek database
        Write-Host "`nMengecek database galeri_sekolah_nafisa..." -ForegroundColor Yellow
        $dbCheck = & $mysqlPath -u root -e "SHOW DATABASES LIKE 'galeri_sekolah_nafisa';" 2>&1
        if ($dbCheck -match "galeri_sekolah_nafisa") {
            Write-Host "✓ Database 'galeri_sekolah_nafisa' sudah ada!" -ForegroundColor Green
        } else {
            Write-Host "⚠ Database 'galeri_sekolah_nafisa' belum ada." -ForegroundColor Yellow
            Write-Host "Membuat database..." -ForegroundColor Yellow
            & $mysqlPath -u root -e "CREATE DATABASE IF NOT EXISTS galeri_sekolah_nafisa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
            Write-Host "✓ Database berhasil dibuat!" -ForegroundColor Green
        }
        
        Write-Host "`n=== MySQL siap digunakan! ===" -ForegroundColor Green
        Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
        Write-Host "1. Jalankan: php artisan migrate:fresh --seed" -ForegroundColor Cyan
        Write-Host "2. Jalankan: php artisan serve" -ForegroundColor Cyan
        Write-Host "3. Akses: http://localhost:8000/admin" -ForegroundColor Cyan
        
    } else {
        Write-Host "✗ MySQL service tidak berjalan!" -ForegroundColor Red
        Write-Host "`nSolusi:" -ForegroundColor Yellow
        Write-Host "1. Buka XAMPP Control Panel sebagai Administrator" -ForegroundColor White
        Write-Host "2. Klik 'Start' pada MySQL" -ForegroundColor White
        Write-Host "3. Pastikan status MySQL 'Running' (hijau)" -ForegroundColor White
        Write-Host "4. Jalankan script ini lagi" -ForegroundColor White
    }
} catch {
    Write-Host "✗ Gagal mengecek MySQL: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "`nPastikan:" -ForegroundColor Yellow
    Write-Host "1. XAMPP MySQL service aktif" -ForegroundColor White
    Write-Host "2. Port 3306 tidak digunakan aplikasi lain" -ForegroundColor White
    Write-Host "3. XAMPP Control Panel dibuka sebagai Administrator" -ForegroundColor White
}
