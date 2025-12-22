@echo off
cd /d "c:\laragon\www\hill_holding"
"c:\laragon\bin\php\php-8.2.4-Win32-vs16-x64\php.exe" artisan migrate
pause
