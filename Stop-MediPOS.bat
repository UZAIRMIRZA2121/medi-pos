@echo off
echo Stopping MediPOS Servers...

:: Kill artisan serve and schedule:work (PHP processes)
taskkill /F /IM php.exe /T 2>NUL

:: Kill MySQL and Apache
taskkill /F /IM mysqld.exe /T 2>NUL
taskkill /F /IM httpd.exe /T 2>NUL

echo All servers stopped successfully.
timeout /t 3
