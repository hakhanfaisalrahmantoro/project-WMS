# Warehouse Management System (WMS)

**Kelompok 2**

Aplikasi Warehouse Management System berbasis **PHP Native**, **MySQL**,
dan **Bootstrap 5** untuk membantu pengelolaan data serta aktivitas
persediaan barang di gudang.

## Anggota Kelompok

-   Daryoto
-   Hakhan Faisal Rahmantoro
-   Iyam Maryam
-   Maulana Isnan Ibarahim

## Teknologi

-   PHP Native
-   MySQL
-   Bootstrap 5 dan Bootstrap Icons
-   Laragon untuk server lokal
-   Composer
-   Google API Client (`google/apiclient`) untuk verifikasi Google Login

## Fitur Aplikasi

-   Login dan logout menggunakan username dan password.
-   Google Login menggunakan Google Identity Services.
-   Dashboard untuk menampilkan ringkasan informasi gudang.
-   Data Barang untuk mengelola data barang.
-   Barang Masuk untuk mencatat penambahan stok.
-   Barang Keluar untuk mencatat pengeluaran stok.
-   Riwayat untuk melihat catatan transaksi.
-   Manajemen Pengguna untuk mengelola akun.
-   Hak akses Admin dan User.

## Persyaratan

Pastikan perangkat sudah memiliki:

1.  Laragon atau web server lokal yang mendukung PHP dan MySQL.
2.  MySQL atau MariaDB.
3.  Composer.
4.  Browser dan koneksi internet untuk Google Login serta aset CDN
    Bootstrap.

## Cara Menjalankan Proyek

### 1. Letakkan folder proyek

Salin folder proyek ke direktori Laragon:

``` text
C:\laragon\www\warehouse
```

### 2. Jalankan Laragon

Aktifkan Apache dan MySQL melalui Laragon.

### 3. Siapkan database

Buka phpMyAdmin dan buat database:

``` sql
CREATE DATABASE warehouse;
```

Import file SQL proyek jika tersedia. Pastikan tabel `users` dan tabel
lain yang digunakan aplikasi sudah dibuat.

Contoh kolom tambahan untuk Google Login:

``` sql
ALTER TABLE users
ADD COLUMN email VARCHAR(150) DEFAULT NULL UNIQUE,
ADD COLUMN google_sub VARCHAR(255) DEFAULT NULL UNIQUE;
```

Jalankan perintah tersebut hanya jika kolom `email` dan `google_sub`
belum ada.

**Catatan penting:** Pada database proyek ini, nama kolom peran pengguna
ditulis `ROLE` (huruf kapital). Saat mengambil nilainya dari hasil query
PHP, gunakan `$user['ROLE']`.

### 4. Periksa koneksi database

Sesuaikan `koneksi.php` dengan konfigurasi MySQL lokal. Contoh
konfigurasi umum Laragon:

``` php
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "warehouse";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
```

Sesuaikan username dan password jika konfigurasi komputer berbeda.

### 5. Pasang dependensi Composer

Buka Command Prompt pada folder proyek:

``` cmd
cd C:\laragon\www\warehouse
```

Jika file `composer.lock` tersedia, jalankan:

``` cmd
composer install
```

Jika Google API Client belum dipasang, jalankan:

``` cmd
composer require google/apiclient
```

Pastikan folder `vendor` dan file `vendor/autoload.php` tersedia.

### 6. Konfigurasi Google Login

1.  Buat OAuth Client ID bertipe **Web application** melalui Google
    Cloud Console.
2.  Tambahkan Authorized JavaScript origin:

``` text
http://localhost
```

3.  Tambahkan Authorized redirect URI:

``` text
http://localhost/warehouse/google_login.php
```

4.  Masukkan Client ID ke `config/google.php`:

``` php
<?php
define('GOOGLE_CLIENT_ID', 'CLIENT_ID_KAMU.apps.googleusercontent.com');
?>
```

5.  Pastikan nilai `data-login_uri` pada halaman login sama persis:

``` text
http://localhost/warehouse/google_login.php
```

6.  Daftarkan email Google pengguna melalui Admin WMS. Google Login
    hanya mengizinkan email yang sudah terdaftar serta akun yang aktif
    dan belum dihapus.

**Penting:** - Gunakan `localhost` secara konsisten. Jangan mencampur
`localhost`, `127.0.0.1`, dan domain lokal lain. - Jangan membagikan
token, Client Secret, atau kredensial sensitif. - Jangan menghapus
validasi CSRF pada `google_login.php`. - Email Google harus sama dengan
email yang terdaftar di WMS.

### 7. Buka aplikasi

Akses melalui browser:

``` text
http://localhost/warehouse/
```

Login menggunakan akun yang sudah terdaftar di tabel `users`.

## Hak Akses Pengguna

  -----------------------------------------------------------------------
  Role                                Keterangan
  ----------------------------------- -----------------------------------
  `admin`                             Mengelola data dan pengguna serta
                                      mengakses fitur khusus Admin.

  `user`                              Mengakses fitur operasional sesuai
                                      pembatasan aplikasi.
  -----------------------------------------------------------------------

Akun baru dibuat melalui fitur manajemen pengguna oleh Admin. Pastikan
nilai `ROLE` dan `status` sesuai dengan kebutuhan akun.

## Gambaran CRUD

CRUD merupakan empat operasi dasar pengelolaan data:

  -----------------------------------------------------------------------
  Operasi                 Arti                    Contoh pada WMS
  ----------------------- ----------------------- -----------------------
  Create                  Menambahkan data        Menambahkan barang atau
                                                  pengguna.

  Read                    Membaca/menampilkan     Melihat daftar barang
                          data                    dan pengguna.

  Update                  Memperbarui data        Mengubah informasi
                                                  barang atau akun
                                                  pengguna.

  Delete                  Menghapus data          Menghapus atau menandai
                                                  data tidak aktif sesuai
                                                  mekanisme aplikasi.
  -----------------------------------------------------------------------

## Keamanan

-   Session untuk autentikasi halaman internal.
-   Pemeriksaan role untuk membatasi akses Admin.
-   Prepared statement untuk query dengan input pengguna.
-   `password_hash()` untuk menyimpan password dalam bentuk hash.
-   `password_verify()` untuk memeriksa password saat login.
-   Validasi input sebelum data disimpan atau diperbarui.
-   Verifikasi ID token Google dan validasi CSRF pada alur Google Login.
-   Pemeriksaan status akun dan `is_deleted` sebelum login.

## Struktur Folder (Gambaran Umum)

``` text
warehouse/
├── config/
│   └── google.php
├── vendor/
├── koneksi.php
├── auth.php
├── index.php
├── google_login.php
├── logout.php
├── dashboard.php
├── barang.php
├── barang_masuk.php
├── barang_keluar.php
├── riwayat.php
├── users.php
├── tambah_user.php
├── edit_user.php
└── ...
```

Struktur di atas merupakan gambaran file utama. Nama dan jumlah file
dapat berbeda mengikuti versi proyek.

## Pemecahan Masalah

### Database tidak terhubung

-   Pastikan MySQL aktif di Laragon.
-   Periksa konfigurasi `koneksi.php`.
-   Pastikan database `warehouse` dan tabel yang dibutuhkan sudah
    tersedia.

### Login username dan password gagal

-   Pastikan username tersedia di tabel `users`.
-   Pastikan akun memiliki `status = 1` dan `is_deleted = 0`.
-   Pastikan password disimpan menggunakan `password_hash()` jika login
    menggunakan `password_verify()`.

### Google Login gagal

-   Pastikan dependensi Composer sudah terpasang.
-   Periksa Client ID pada `config/google.php`.
-   Samakan origin, redirect URI, dan `data-login_uri` dengan alamat
    `localhost`.
-   Pastikan email Google sudah terdaftar dan akun aktif serta belum
    dihapus.
-   Jangan menghapus validasi CSRF untuk mengatasi kegagalan login.

### Menu Admin tidak muncul

-   Periksa nilai `ROLE` pada baris pengguna di database.
-   Pastikan akun memiliki nilai `admin`.
-   Logout lalu login kembali agar session baru dibuat.
-   Pada proses Google Login, pastikan session role diisi dari kolom
    database:

``` php
$_SESSION['role'] = $user['ROLE'];
```

## Catatan Pengembangan

README ini merangkum konfigurasi dan fitur berdasarkan implementasi WMS
Kelompok 2. Sesuaikan langkah database, struktur folder, dan daftar
fitur apabila file proyek atau skema database berubah.

------------------------------------------------------------------------

**Warehouse Management System --- Kelompok 2**
