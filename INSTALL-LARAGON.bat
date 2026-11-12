@echo off
echo ==========================================
echo ChordVerse - Laravel 10 - Laragon
echo ==========================================
echo.
echo Jalankan file ini dari folder source ChordVerse.
echo.
echo 1. Pastikan Composer dan Laragon sudah terpasang.
echo 2. Script ini membuat project Laravel 10 baru bernama chordverse.
echo.
cd /d C:\laragon\www
if exist chordverse (
    echo Folder C:\laragon\www\chordverse sudah ada.
    echo Hapus/rename folder tersebut jika ingin instalasi baru.
    pause
    exit /b 1
)

composer create-project laravel/laravel:^10.0 chordverse
if errorlevel 1 (
    echo Gagal membuat project Laravel.
    pause
    exit /b 1
)

echo.
echo Sekarang salin folder app, database, resources, routes dan public dari source ini
echo ke C:\laragon\www\chordverse.
echo Jangan menimpa folder vendor.
echo.
pause
