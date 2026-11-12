# ChordVerse — Source Code Laravel 10 + PHP 8.1

Source code ini dibuat berdasarkan PRD ChordVerse Web Chord.

## Kompatibilitas

- Laragon 6.0
- PHP 8.1.x
- Laravel 10.x
- MySQL / MariaDB
- Blade
- Bootstrap 5.3 CDN

## Penting

Paket ini berisi **source code aplikasi ChordVerse**, bukan folder `vendor` Laravel dan bukan seluruh skeleton Laravel bawaan. Ini sengaja dibuat agar tidak membawa `vendor` yang besar.

Karena PHP kamu adalah 8.1.10, gunakan Laravel 10.

## Cara paling aman di Laragon

Buka terminal Laragon lalu:

```bash
cd C:\laragon\www
composer create-project laravel/laravel:^10.0 chordverse
cd chordverse
```

Setelah itu, **copy/replace file source dari paket ini** ke folder:

```text
C:\laragon\www\chordverse
```

Jangan menimpa `vendor`.

File/folder aplikasi yang disediakan paket ini antara lain:

```text
app/
database/
resources/
routes/
public/images/
.env.example
composer.json
```

`bootstrap/app.php` Laravel 10 yang dibuat oleh `create-project` tetap dipakai.

## Database

Buat database MySQL:

```sql
CREATE DATABASE chordverse
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Atur `.env`:

```env
APP_NAME=ChordVerse
APP_ENV=local
APP_DEBUG=true
APP_URL=http://chordverse.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chordverse
DB_USERNAME=root
DB_PASSWORD=
```

Lalu:

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

Jalankan:

```bash
php artisan serve
```

Atau jika memakai Laragon, setelah folder berada di:

```text
C:\laragon\www\chordverse
```

klik **Reload** pada Laragon dan buka:

```text
http://chordverse.test
```

## Akun demo

Admin:

```text
email    : admin@chordverse.test
username : admin
password : Admin12345!
```

User:

```text
email    : user@chordverse.test
username : demouser
password : User12345!
```

## Fitur

- Home
- Search semua genre
- Search khusus genre
- Genre Pop, Rock, K-Pop, Indie dan genre lain
- Lagu populer berdasarkan views
- Detail chord
- Copy chord
- Register
- Login dengan email atau username
- Logout
- Tambah chord
- Edit chord milik sendiri
- Hapus chord milik sendiri
- Admin dapat mengelola chord melalui Policy
- Bookmark
- Profil
- Lagu Saya
- Bookmark
- Pengaturan akun
- Ganti password
- Upload cover
- Default cover
- Validasi server-side
- Migration
- Seeder
- Relasi Eloquent
- OOP MVC
- Policy Laravel

## Struktur database

```text
users
  └── songs
       └── genres

users
  └── bookmarks
       └── songs
```

## Penerapan OOP

Model:

```text
User
Genre
Song
```

Controller:

```text
HomeController
AuthController
GenreController
SongController
BookmarkController
ProfileController
```

Validasi:

```text
RegisterRequest
SongRequest
ProfileUpdateRequest
```

Policy:

```text
SongPolicy
```

Relasi:

```text
User hasMany Song
Genre hasMany Song
Song belongsTo User
Song belongsTo Genre
User belongsToMany Song
```

Aturan kepemilikan chord diperiksa oleh Policy di server sehingga user tidak dapat mengedit/menghapus chord milik user lain hanya dengan mengubah ID URL.
