<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTemplateTypesSeeder extends Seeder
{
  public function run()
  {
    // Update Teacher Templates
    DB::table('document_templates')
      ->where('name', 'like', '%Guru%')
      ->orWhere('name', 'like', '%Mengajar%')
      ->update(['type' => 'teacher']);

    // Update Student Templates (Explicitly)
    DB::table('document_templates')
      ->where('name', 'like', '%Siswa%')
      ->orWhere('name', 'like', '%Panggilan%')
      ->orWhere('name', 'like', '%Kelakuan%')
      ->orWhere('name', 'like', '%Pindah%')
      ->update(['type' => 'student']);
  }
}
