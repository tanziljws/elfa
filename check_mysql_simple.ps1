# Script untuk mengecek status MySQL XAMPP

Write-Host "Cek Status MySQL XAMPP" -ForegroundColor Green

# Path ke MySQL XAMPP
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"

# Cek apakah MySQL XAMPP ada
if (Test-Path $mysqlPath) {
    Write-Host "MySQL XAMPP ditemukan" -ForegroundColor Green
} else {
    Write-Host "MySQL XAMPP tidak ditemukan" -ForegroundColor Red
    exit 1
}

# Cek apakah MySQL service berjalan
Write-Host "Mengecek koneksi MySQL..." -ForegroundColor Yellow

try {
    $result = & $mysqlPath -u root -e "SELECT 1;" 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "MySQL service berjalan dengan baik!" -ForegroundColor Green
        
        # Cek database
        Write-Host "Mengecek database galeri_sekolah_nafisa..." -ForegroundColor Yellow
        $dbCheck = & $mysqlPath -u root -e "SHOW DATABASES LIKE 'galeri_sekolah_nafisa';" 2>&1
        if ($dbCheck -match "galeri_sekolah_nafisa") {
            Write-Host "Database galeri_sekolah_nafisa sudah ada!" -ForegroundColor Green
        } else {
            Write-Host "Database galeri_sekolah_nafisa belum ada. Membuat database..." -ForegroundColor Yellow
            & $mysqlPath -u root -e "CREATE DATABASE IF NOT EXISTS galeri_sekolah_nafisa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
            Write-Host "Database berhasil dibuat!" -ForegroundColor Green
        }
        
        Write-Host "MySQL siap digunakan!" -ForegroundColor Green
        Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
        Write-Host "1. php artisan migrate:fresh --seed" -ForegroundColor Cyan
        Write-Host "2. php artisan serve" -ForegroundColor Cyan
        Write-Host "3. Akses http://localhost:8000/admin" -ForegroundColor Cyan
        
    } else {
        Write-Host "MySQL service tidak berjalan!" -ForegroundColor Red
        Write-Host "Solusi:" -ForegroundColor Yellow
        Write-Host "1. Buka XAMPP Control Panel sebagai Administrator" -ForegroundColor White
        Write-Host "2. Klik Start pada MySQL" -ForegroundColor White
        Write-Host "3. Pastikan status MySQL Running (hijau)" -ForegroundColor White
    }
} catch {
    Write-Host "Gagal mengecek MySQL" -ForegroundColor Red
    Write-Host "Pastikan XAMPP MySQL service aktif" -ForegroundColor Yellow
}
