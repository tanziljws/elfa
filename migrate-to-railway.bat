@echo off
REM Script untuk Migrasi Database ke Railway
REM Usage: migrate-to-railway.bat

echo ========================================
echo   MIGRASI DATABASE KE RAILWAY
echo ========================================
echo.

REM Step 1: Backup XAMPP Database
echo [1/3] Backup database XAMPP...
mysqldump -u root -P 3307 -h 127.0.0.1 galeri-sekolah-elfa > backup_xampp.sql
if %errorlevel% neq 0 (
    echo ERROR: Backup gagal!
    pause
    exit /b 1
)
echo OK: Backup berhasil - backup_xampp.sql
echo.

REM Step 2: Test koneksi Railway
echo [2/3] Test koneksi ke Railway...
echo Pastikan .env sudah diupdate dengan Railway credentials!
php artisan config:clear
php artisan tinker --execute="echo 'Testing...'; DB::connection()->getPdo(); echo 'OK';"
if %errorlevel% neq 0 (
    echo ERROR: Koneksi Railway gagal!
    echo.
    echo Troubleshooting:
    echo 1. Update .env dengan Railway credentials
    echo 2. Pastikan Railway MySQL service running
    echo 3. Cek Railway Variables di Dashboard
    pause
    exit /b 1
)
echo.

REM Step 3: Import ke Railway
echo [3/3] Import database ke Railway...
echo PERINGATAN: Ini akan menimpa data di Railway!
set /p confirm="Lanjutkan? (yes/no): "
if /i not "%confirm%"=="yes" (
    echo Dibatalkan.
    pause
    exit /b 0
)

REM Get Railway credentials from .env
for /f "tokens=2 delims==" %%a in ('findstr "DB_HOST" .env') do set DB_HOST=%%a
for /f "tokens=2 delims==" %%a in ('findstr "DB_PORT" .env') do set DB_PORT=%%a
for /f "tokens=2 delims==" %%a in ('findstr "DB_DATABASE" .env') do set DB_DATABASE=%%a
for /f "tokens=2 delims==" %%a in ('findstr "DB_USERNAME" .env') do set DB_USERNAME=%%a
for /f "tokens=2 delims==" %%a in ('findstr "DB_PASSWORD" .env') do set DB_PASSWORD=%%a

mysql -u %DB_USERNAME% -p%DB_PASSWORD% -h %DB_HOST% -P %DB_PORT% %DB_DATABASE% < backup_xampp.sql
if %errorlevel% neq 0 (
    echo ERROR: Import gagal!
    pause
    exit /b 1
)

echo.
echo ========================================
echo   MIGRASI SELESAI!
echo ========================================
echo.
echo Next steps:
echo 1. Test aplikasi dengan Railway database
echo 2. Run migrations: php artisan migrate
echo 3. Deploy ke Railway
echo.
pause
