@echo off
echo Mengaktifkan GD Extension...
echo.

REM Backup php.ini
copy "C:\xampp\php\php.ini" "C:\xampp\php\php.ini.backup" >nul 2>&1

REM Aktifkan extension gd
powershell -Command "(Get-Content 'C:\xampp\php\php.ini') -replace ';extension=gd', 'extension=gd' | Set-Content 'C:\xampp\php\php.ini'"

echo GD Extension telah diaktifkan!
echo Silakan restart Apache di XAMPP Control Panel
echo.
pause
