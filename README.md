# TataPro - Sistem Administrasi Tata Usaha Sekolah

TataPro adalah aplikasi berbasis web yang dirancang untuk mempermudah pengelolaan administrasi tata usaha di sekolah, mulai dari manajemen surat menyurat, disposisi, hingga pengelolaan data induk siswa dan guru.

Dibuat dengan framework **Laravel** yang handal dan aman.

## 🚀 Fitur Unggulan

*   **E-Correspondence (Surat Menyurat)**
    *   Pencatatan Surat Masuk & Surat Keluar.
    *   **Disposisi Digital**: Alur disposisi dari Kepala Sekolah ke staf secara real-time.
    *   Upload & Preview Scan Surat.
    *   Cetak Lembar Disposisi & Buku Agenda.
*   **Manajemen Data Induk**
    *   **Data Siswa**: Import data via Excel, pencarian cepat, dan profil detail.
    *   **Buku Induk**: Cetak lembar Buku Induk siswa (satuan atau massal/bulk print) sesuai standar.
    *   **Data Guru**: Manajemen data pendidik dan tenaga kependidikan.
*   **Layanan Cetak Otomatis (Document Generator)**
    *   Generate surat otomatis dengan format yang sudah standar (Surat Keterangan Siswa, Surat Tugas, dll).
    *   Template surat dinamis yang bisa diatur oleh Admin.
    *   Export ke Word/PDF.
*   **Manajemen Sistem & Akses (RBAC)**
    *   **Multi-Role**: Admin, Kepala Sekolah, Guru, Staff TU.
    *   Pengaturan Identitas Sekolah (Logo, Kop Surat, Pejabat).
    *   Manajemen User dan Hak Akses granular.
*   **Panduan Sistem**
    *   Halaman panduan visual (Timeline) untuk membantu pengguna baru memahami alur kerja aplikasi.

## 🛠️ Teknologi

*   **Backend**: Laravel 12 (PHP 8.2+)
*   **Frontend**: Blade Templating + AdminLTE 3 + Bootstrap 4
*   **Database**: MySQL / MariaDB
*   **Libraries**:
    *   `spatie/laravel-permission` (Role & Permission)
    *   `maatwebsite/excel` (Import/Export Excel)
    *   `phpoffice/phpword` (Word Generation)
    *   `barryvdh/laravel-dompdf` (PDF Generation)

## 📦 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal Anda:

### 1. Prasyarat
Pastikan komputer Anda sudah terinstall:
*   PHP >= 8.2
*   Composer
*   Web Server (Apache/Nginx/Laragon/XAMPP)
*   MySQL

### 2. Instalasi Project
```bash
# Clone repository
git clone https://github.com/username/tatapro.git

# Masuk ke direktori project
cd tatapro

# Install dependensi PHP
composer install

# Install dependensi Frontend (Optional jika ingin compile aset)
npm install && npm run build
```

### 3. Konfigurasi Environment
Salin file konfigurasi `.env.example` dan sesuaikan dengan database Anda.

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan atur koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tatapro_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database
Jalankan migrasi dan seeder untuk membuat tabel dan data awal (User Admin, Template, dll).

```bash
php artisan migrate --seed
```

### 5. Setup Storage
Buat symbolic link untuk folder storage agar file upload bisa diakses publik.

```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```
Akses aplikasi di browser: `http://localhost:8000`

## 🔑 Akun Default

Gunakan akun berikut untuk login pertama kali:

*   **Role**: Administrator
*   **Email**: `admin@admin.com`
*   **Password**: `password`

*(Catatan: Seeder mungkin juga membuat akun dummy untuk Kepala Sekolah dan Guru)*

## 📄 Struktur Folder Penting

*   `app/Http/Controllers` - Logika Aplikasi
*   `resources/views/backend` - Tampilan (Views) Dashboard & Admin
*   `routes/web.php` - Definisi Rute Aplikasi
*   `database/seeders` - Data Awal (Refer to `DatabaseSeeder.php`)

## 🤝 Kontribusi

Silakan buat **Pull Request** jika ingin berkontribusi pada pengembangan fitur baru atau perbaikan bug.

---
**TataPro** - *Simplifying School Administration*
