<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MailCategory;

class MailCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['code' => '005', 'name' => 'Undangan', 'description' => 'Surat undangan rapat/kegiatan'],
            ['code' => '420', 'name' => 'Pendidikan', 'description' => 'Umum tentang pendidikan'],
            ['code' => '421', 'name' => 'Sekolah', 'description' => 'Administrasi sekolah'],
            ['code' => '421.1', 'name' => 'Pra Sekolah', 'description' => 'Taman kanak-kanak'],
            ['code' => '421.2', 'name' => 'Sekolah Dasar', 'description' => 'SD/MI'],
            ['code' => '421.3', 'name' => 'Sekolah Menengah', 'description' => 'SMP/SMA/SMK'],
            ['code' => '422', 'name' => 'Administrasi Siswa', 'description' => 'Pendaftaran, mutasi, beasiswa'],
            ['code' => '800', 'name' => 'Kepegawaian', 'description' => 'Administrasi guru dan pegawai'],
        ];

        foreach ($categories as $cat) {
            MailCategory::create($cat);
        }
    }
}
