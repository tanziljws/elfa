# Script untuk setup MySQL database untuk Galeri Sekolah Nafisa

Write-Host "=== Setup MySQL Database untuk Galeri Sekolah Nafisa ===" -ForegroundColor Green

# Path ke MySQL XAMPP
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"

# Cek apakah MySQL XAMPP ada
if (Test-Path $mysqlPath) {
    Write-Host "✓ MySQL XAMPP ditemukan di: $mysqlPath" -ForegroundColor Green
} else {
    Write-Host "✗ MySQL XAMPP tidak ditemukan di: $mysqlPath" -ForegroundColor Red
    Write-Host "Pastikan XAMPP sudah terinstall dan MySQL service berjalan." -ForegroundColor Yellow
    exit 1
}

# Buat database
Write-Host "`nMembuat database 'galeri_sekolah_nafisa'..." -ForegroundColor Yellow

$createDbSQL = @"
CREATE DATABASE IF NOT EXISTS \`galeri_sekolah_nafisa\` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
"@

try {
    $createDbSQL | & $mysqlPath -u root
    Write-Host "✓ Database 'galeri_sekolah_nafisa' berhasil dibuat!" -ForegroundColor Green
} catch {
    Write-Host "✗ Gagal membuat database: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

# Update file .env
Write-Host "`nMengupdate konfigurasi .env untuk MySQL..." -ForegroundColor Yellow

$envContent = @"
APP_NAME="Galeri Sekolah Nafisa"
APP_ENV=local
APP_KEY=base64:clp4FnW++y8UZj70jr7RcRTnbOOpcCFk2BHxmg/PG14=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# MySQL Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=galeri_sekolah_nafisa
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="`${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="`${APP_NAME}"
VITE_PUSHER_APP_KEY="`${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="`${PUSHER_HOST}"
VITE_PUSHER_PORT="`${PUSHER_PORT}"
VITE_PUSHER_SCHEME="`${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="`${PUSHER_APP_CLUSTER}"
"@

try {
    $envContent | Out-File -FilePath ".env" -Encoding UTF8
    Write-Host "✓ File .env berhasil diupdate untuk MySQL!" -ForegroundColor Green
} catch {
    Write-Host "✗ Gagal mengupdate file .env: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

Write-Host "`n=== Setup MySQL Selesai! ===" -ForegroundColor Green
Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
Write-Host "1. Jalankan: php artisan migrate:fresh --seed" -ForegroundColor Cyan
Write-Host "2. Jalankan: php artisan serve" -ForegroundColor Cyan
Write-Host "3. Akses: http://localhost:8000/admin" -ForegroundColor Cyan
