# Setup MySQL Database untuk Galeri Sekolah Nafisa

Write-Host "Setup MySQL Database untuk Galeri Sekolah Nafisa" -ForegroundColor Green

# Path ke MySQL XAMPP
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"

# Cek apakah MySQL XAMPP ada
if (Test-Path $mysqlPath) {
    Write-Host "MySQL XAMPP ditemukan" -ForegroundColor Green
} else {
    Write-Host "MySQL XAMPP tidak ditemukan" -ForegroundColor Red
    exit 1
}

# Buat database
Write-Host "Membuat database galeri_sekolah_nafisa..." -ForegroundColor Yellow

$createDbSQL = "CREATE DATABASE IF NOT EXISTS galeri_sekolah_nafisa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

try {
    echo $createDbSQL | & $mysqlPath -u root
    Write-Host "Database berhasil dibuat!" -ForegroundColor Green
} catch {
    Write-Host "Gagal membuat database" -ForegroundColor Red
    exit 1
}

Write-Host "Setup MySQL selesai!" -ForegroundColor Green
