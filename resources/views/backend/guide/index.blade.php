@extends('backend.layouts.app')

@section('title', 'Panduan Sistem')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><i class="fas fa-book-reader mr-2"></i> Panduan Alur Sistem</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Timeline -->
          <div class="timeline">

            <!-- Timeline Label: Start -->
            <div class="time-label">
              <span class="bg-primary px-3">Modul Surat Menyurat</span>
            </div>

            <!-- Item 1: Surat Masuk -->
            <div>
              <i class="fas fa-envelope-open-text bg-success"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> Langkah 1</span>
                <h3 class="timeline-header"><a href="#">Mencatat Surat Masuk</a></h3>
                <div class="timeline-body">
                  <p>Setiap surat fisik yang diterima sekolah harus dicatat ke dalam sistem:</p>
                  <ol>
                    <li>Buka menu <b>E-Correspondence > Surat Masuk</b>.</li>
                    <li>Klik tombol <b><i class="fas fa-plus-circle"></i> Tambah Surat (F1)</b>.</li>
                    <li>Isi data surat seperti Nomor Surat, Tanggal, Pengirim, dan Perihal.</li>
                    <li><b>Upload Scan Surat</b> (PDF/Gambar) agar bisa dilihat oleh Kepala Sekolah.</li>
                    <li>Klik <b>Simpan</b>.</li>
                  </ol>
                  <div class="alert alert-info py-1 px-3 mt-2">
                    <i class="fas fa-info-circle"></i> &nbsp; Surat yang sudah dicatat akan otomatis masuk ke daftar
                    antrian disposisi Kepala Sekolah.
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 2: Disposisi -->
            <div>
              <i class="fas fa-random bg-info"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> Langkah 2</span>
                <h3 class="timeline-header"><a href="#">Proses Disposisi (Kepala Sekolah)</a></h3>
                <div class="timeline-body">
                  <p>Setelah surat masuk dicatat, Kepala Sekolah atau Admin harus memproses disposisi:</p>
                  <ol>
                    <li>Buka menu <b>E-Correspondence > Alur Disposisi</b>.</li>
                    <li>Pilih surat yang statusnya masih <b>"Pending"</b>.</li>
                    <li>Klik tombol <b>Proses Disposisi</b>.</li>
                    <li>Tentukan <b>Penerima Disposisi</b> (Misal: Guru, Wakasek, atau TU) dan isi instruksi.</li>
                    <li>Status surat akan berubah menjadi <b>TERDISPOSISI</b>.</li>
                    <li>Anda bisa mencetak <b>Lembar Disposisi</b> untuk ditempel pada surat fisik.</li>
                  </ol>
                </div>
              </div>
            </div>

            <!-- Item 3: Surat Keluar -->
            <div>
              <i class="fas fa-paper-plane bg-warning"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> Langkah 3</span>
                <h3 class="timeline-header"><a href="#">Membuat Surat Keluar</a></h3>
                <div class="timeline-body">
                  <p>Untuk surat yang akan dikirimkan ke luar instansi:</p>
                  <ol>
                    <li>Buka menu <b>E-Correspondence > Surat Keluar</b>.</li>
                    <li>Klik <b>Tambah Surat</b>.</li>
                    <li>Sistem akan menyarankan <b>Nomor Agenda Baru</b> secara otomatis, namun Anda bisa mengubahnya jika
                      menulis nomor mundur (Backdate).</li>
                    <li>Isi Tujuan Surat dan lampiran file jika ada.</li>
                    <li>Gunakan fitur <b>Export PDF</b> untuk mencetak daftar agenda surat keluar.</li>
                  </ol>
                </div>
              </div>
            </div>


            <!-- Timeline Label: Data Induk -->
            <div class="time-label">
              <span class="bg-purple px-3">Modul Data Induk & Cetak</span>
            </div>

            <!-- Item 4: Data Siswa -->
            <div>
              <i class="fas fa-user-graduate bg-primary"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> Manajemen Data</span>
                <h3 class="timeline-header"><a href="#">Database Siswa & Buku Induk</a></h3>
                <div class="timeline-body">
                  <p>Manajemen data kesiswaan yang terintegrasi:</p>
                  <ul>
                    <li><b>Import Data:</b> Gunakan fitur Import Excel untuk memasukkan ratusan data siswa sekaligus.</li>
                    <li><b>Cetak Buku Induk:</b>
                      <ul>
                        <li>Buka menu <b>Data Siswa</b>.</li>
                        <li>Klik tombol ceklist pada siswa yang diinginkan.</li>
                        <li>Pilih <b>Cetak Massal</b> untuk mencetak lembar Buku Induk sekaligus.</li>
                      </ul>
                    </li>
                    <li><b>Filter & Pencarian:</b> Cari siswa berdasarkan Nama, NIS, atau Kelas dengan cepat.</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Item 5: Layanan Surat -->
            <div>
              <i class="fas fa-magic bg-danger"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> Generator</span>
                <h3 class="timeline-header"><a href="#">Layanan Cetak Surat Otomatis</a></h3>
                <div class="timeline-body">
                  <p>Butuh surat keterangan siswa atau surat tugas guru dengan cepat?</p>
                  <ol>
                    <li>Buka menu <b>Layanan Cetak</b>.</li>
                    <li>Pilih jenis surat (Siswa / Guru).</li>
                    <li>Sistem akan menampilkan form isian singkat.</li>
                    <li>Cari nama siswa/guru dari database, sisa data akan terisi otomatis.</li>
                    <li>Klik <b>Generate Word/PDF</b>. Surat siap dicetak dengan Kop Surat Sekolah.</li>
                  </ol>
                </div>
              </div>
            </div>

            <!-- Timeline Label: End -->
            <div class="time-label">
              <span class="bg-gray px-3">Selesai</span>
            </div>

            <div>
              <i class="fas fa-check bg-gray"></i>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection