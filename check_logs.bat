@echo off
echo Checking latest logs...
echo.
powershell -Command "Get-Content 'storage\logs\laravel.log' -Tail 30 | Select-String -Pattern 'profile' -Context 2"
pause
