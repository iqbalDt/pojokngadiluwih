@echo OFF
TITLE PojokNgadiluwih - Laravel Dev Server
echo Starting Laravel server with PHP 8.5...
echo Open http://127.0.0.1:8000 in your browser
echo Press Ctrl+C to stop
echo.
"D:\laragon\bin\php\php-8.5.11-Win32-vs17-x64\php.exe" "%~dp0artisan" serve --host 127.0.0.1 --port 8000
pause
