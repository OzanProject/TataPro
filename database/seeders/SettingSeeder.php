<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
  public function run()
  {
    $settings = [
      // School Identity
      ['key' => 'school_name', 'value' => 'SMK Tata Kelola Profesional', 'group' => 'school'],
      ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 123, Kota Administrasi', 'group' => 'school'],
      ['key' => 'school_phone', 'value' => '(021) 12345678', 'group' => 'school'],
      ['key' => 'school_email', 'value' => 'info@smktatapro.sch.id', 'group' => 'school'],
      ['key' => 'school_website', 'value' => 'www.smktatapro.sch.id', 'group' => 'school'],

      // Principal Data
      ['key' => 'principal_name', 'value' => 'Dr. H. Ahmad Fauzi, M.Pd', 'group' => 'school'],
      ['key' => 'principal_nip', 'value' => '19800101 200501 1 001', 'group' => 'school'],

      // Logos & Kop (Placeholders)
      ['key' => 'school_logo', 'value' => 'settings/logo_default.png', 'type' => 'image', 'group' => 'school'],
      ['key' => 'dinas_logo', 'value' => 'settings/dinas_default.png', 'type' => 'image', 'group' => 'school'],
      ['key' => 'letterhead', 'value' => 'settings/kop_default.png', 'type' => 'image', 'group' => 'mail'],

      // Kop Text Defaults
      ['key' => 'kop_line1', 'value' => 'PEMERINTAH KABUPATEN CIANJUR', 'group' => 'school'],
      ['key' => 'kop_line2', 'value' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'group' => 'school'],
      ['key' => 'kop_address', 'value' => 'Jl. Pendidikan No. 123, Kadupandak', 'group' => 'school'],
      ['key' => 'kop_contact', 'value' => 'Telp: (0263) 1234567 | Email: info@smpn4kadupandak.sch.id', 'group' => 'school'],

      // Kop Text Defaults
      ['key' => 'kop_line1', 'value' => 'PEMERINTAH KABUPATEN CIANJUR', 'group' => 'school'],
      ['key' => 'kop_line2', 'value' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'group' => 'school'],
      ['key' => 'kop_address', 'value' => 'Jl. Pendidikan No. 123, Kadupandak', 'group' => 'school'],
      ['key' => 'kop_contact', 'value' => 'Telp: (0263) 1234567 | Email: info@smpn4kadupandak.sch.id', 'group' => 'school'],
    ];

    foreach ($settings as $setting) {
      Setting::updateOrCreate(['key' => $setting['key']], $setting);
    }
  }
}
