# Panduan Deployment ke Hosting (cPanel/Shared Hosting)

Berikut adalah checklist dan panduan untuk meminimalisir error saat upload aplikasi TataPro ke hosting.

## ✅ Checklist Pra-Upload

1.  **Versi PHP**: Pastikan hosting Anda mendukung minimal **PHP 8.2**.
2.  **Ekstensi PHP**: Pastikan ekstensi berikut aktif di cPanel (menu "Select PHP Version"):
    *   `fileinfo` (Untuk upload gambar/file)
    *   `gd` (Untuk pemrosesan gambar)
    *   `zip` (Untuk export/import Excel & Word)
    *   `xml` & `mbstring` (Standar Laravel)
3.  **Database**: Pastikan Anda sudah membuat Database & User di menu "MySQL Databases".

## 📂 Struktur Folder di Hosting

Ada dua metode umum untuk struktur folder di shared hosting:

### Metode 1: Folder Terpisah (Direkomendasikan - Lebih Aman)

Struktur yang disarankan adalah menaruh core Laravel **di luar** folder `public_html`.

```
/ (Root Directory)
├── tatapro_core/       <-- Upload semua file project KECUALI folder public
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── ...
│   └── .env            <-- File konfigurasi rahasia
│
└── public_html/        <-- Upload ISI folder public ke sini
    ├── css/
    ├── js/
    ├── index.php       <-- Perlu diedit sedikit
    └── .htaccess
```

**Langkah Edit `index.php` (di public_html):**
Ubah baris berikut untuk menunjuk ke folder `tatapro_core`:

```php
// Cari baris ini:
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
// Ubah menjadi (sesuaikan path):
if (file_exists($maintenance = __DIR__.'/../tatapro_core/storage/framework/maintenance.php')) {

// Cari baris ini:
require __DIR__.'/../vendor/autoload.php';
// Ubah menjadi:
require __DIR__.'/../tatapro_core/vendor/autoload.php';

// Cari baris ini:
$app = require_once __DIR__.'/../bootstrap/app.php';
// Ubah menjadi:
$app = require_once __DIR__.'/../tatapro_core/bootstrap/app.php';
```

## ⚠️ Potensi Masalah & Solusi (Troubleshooting)

### 1. Error 500 (Internal Server Error)
*   **Penyebab**: Biasanya karena permissions folder salah atau `.env` error.
*   **Solusi**:
    *   Pastikan folder `storage` dan `bootstrap/cache` memiliki permission **775** atau **755**.
    *   Cek file `.env`, pastikan `APP_DEBUG=true` sementara untuk melihat detail error, lalu kembalikan ke `false`.

### 2. Gambar Tidak Muncul (404 Not Found)
*   **Penyebab**: Symlink `public/storage` tidak bekerja di hosting.
*   **Solusi**:
    *   Hapus folder `storage` yang ada di dalam `public_html` (jika ada).
    *   Di cPanel, cari menu **Terminal** atau **Cron Job**, lalu jalankan perintah:
        ```bash
        ln -s /home/username/tatapro_core/storage/app/public /home/username/public_html/storage
        ```
    *   *Alternatif*: Jika tidak ada akses terminal, buat route khusus di `web.php` untuk menjalankan `Artisan::call('storage:link');` sekali saja.

### 3. Error "Vite Manifest Not Found"
*   **Penyebab**: Anda mendeploy file dev, tapi server mencari file build.
*   **Solusi**:
    *   Pastikan Anda sudah menjalankan `npm run build` di lokal **sebelum** upload.
    *   Pastikan folder `public/build` ikut terupload.

### 4. Halaman "403 Forbidden" atau "404 Not Found"
*   **Penyebab**: Masalah pada `.htaccess`.
*   **Solusi**: Pastikan file `.htaccess` bawaan Laravel ikut terupload ke `public_html`. File ini sering tersembunyi (hidden file).

## 🚀 Langkah Deploy
1.  **Lokal**: Jalankan `composer install --optimize-autoloader --no-dev`.
2.  **Lokal**: Jalankan `npm run build`.
3.  **Lokal**: Hapus folder `nodes_modules` (tidak perlu diupload).
4.  **Lokal**: Compress seluruh project menjadi `.zip`.
5.  **cPanel**: Upload `.zip` ke File Manager.
6.  **cPanel**: Ekstrak sesuai struktur (Metode 1).
7.  **cPanel**: Import database SQL Anda via phpMyAdmin.
8.  **cPanel**: Edit `.env` sesuaikan database hosting.
