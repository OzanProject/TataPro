<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use Illuminate\Database\Seeder;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Storage;

class DocumentTemplateSeeder extends Seeder
{
  public function run()
  {
    $templates = [
      // 1. SURAT KETERANGAN AKTIF (Updated: Justified, Professional Phrasing)
      [
        'name' => 'Surat Keterangan Aktif Siswa',
        'description' => 'Surat resmi yang menyatakan status aktif siswa, untuk keperluan tunjangan, BPJS, atau lainnya.',
        'file_name' => 'surat_keterangan_aktif.docx',
        'variables' => ['nama', 'nis', 'kelas', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'peruntukan'],
        'content' => "SURAT KETERANGAN AKTIF SEKOLAH\n\nYang bertanda tangan di bawah ini Kepala Sekolah menerangkan dengan sesungguhnya bahwa:\n\nNama: \${nama}\nNIS/NISN: \${nis} / \${nisn}\nKelas: \${kelas}\nTempat, Tanggal Lahir: \${tempat_lahir}, \${tanggal_lahir}\nAlamat: \${alamat}\n\nAdalah benar-benar siswa yang terdaftar dan AKTIF mengikuti kegiatan pembelajaran di sekolah kami pada Tahun Pelajaran saat ini.\n\nDemikian surat keterangan ini kami buat dengan sebenarnya untuk dapat dipergunakan sebagai syarat: \${peruntukan}."
      ],
      // 2. SURAT PANGGILAN ORANG TUA (Updated: Formal)
      [
        'name' => 'Surat Panggilan Orang Tua',
        'description' => 'Undangan resmi sekolah kepada wali murid untuk koordinasi atau penyelesaian masalah.',
        'file_name' => 'surat_panggilan_orang_tua.docx',
        'variables' => ['nama_siswa', 'kelas', 'hari_tanggal', 'pukul', 'tempat', 'keperluan'],
        'content' => "SURAT PANGGILAN ORANG TUA/WALI\n\nKepada Yth.\nBapak/Ibu Orang Tua/Wali dari:\n\nNama Siswa: \${nama_siswa}\nKelas: \${kelas}\ndi Tempat\n\nDengan hormat,\nDemi terjalinnya komunikasi dan kerjasama yang baik antara sekolah dan orang tua, serta untuk kepentingan perkembangan putra/putri Bapak/Ibu, kami mengharap kehadiran Bapak/Ibu ke sekolah pada:\n\nHari/Tanggal: \${hari_tanggal}\nPukul: \${pukul}\nTempat: \${tempat}\nKeperluan: \${keperluan}\n\nMengingat pentingnya hal tersebut, kami sangat mengharapkan kehadiran Bapak/Ibu tepat pada waktunya. Atas perhatian dan kerjasamanya kami ucapkan terima kasih."
      ],
      // 3. SURAT KELAKUAN BAIK (Updated: Detailed)
      [
        'name' => 'Surat Keterangan Berkelakuan Baik',
        'description' => 'Bukti tertulis prilaku baik siswa untuk pendaftaran sekolah lanjutan atau beasiswa.',
        'file_name' => 'surat_kelakuan_baik.docx',
        'variables' => ['nama', 'nis', 'nisn', 'kelas', 'alamat', 'keperluan'],
        'content' => "SURAT KETERANGAN BERKELAKUAN BAIK\n\nYang bertanda tangan di bawah ini Kepala Sekolah, menerangkan bahwa:\n\nNama: \${nama}\nNIS/NISN: \${nis} / \${nisn}\nKelas: \${kelas}\nAlamat: \${alamat}\n\nBerdasarkan pengamatan kami selama menjadi siswa di sekolah ini, yang bersangkutan menunjukkan sikap disiplin, santun, dan BERKELAKUAN BAIK serta tidak pernah terlibat dalam pelanggaran tata tertib sekolah mapun tindak pidana.\n\nDemikian surat keterangan ini dibuat untuk keperluan: \${keperluan}, agar dapat dipergunakan sebagaimana mestinya."
      ],
      // 4. SURAT MUTASI/PINDAH (Standard)
      [
        'name' => 'Surat Rekomendasi Pindah Sekolah',
        'description' => 'Pengantar resmi untuk proses mutasi siswa ke sekolah baru.',
        'file_name' => 'surat_pindah.docx',
        'variables' => ['nama', 'nis', 'kelas', 'sekolah_tujuan', 'alasan_pindah'],
        'content' => "SURAT REKOMENDASI PINDAH SEKOLAH\n\nBerdasarkan permohonan orang tua/wali siswa, dengan ini kami memberikan rekomendasi pindah/mutasi kepada:\n\nNama: \${nama}\nNIS: \${nis}\nKelas: \${kelas}\n\nUntuk melanjutkan pendidikan ke sekolah baru:\nNama Sekolah Tujuan: \${sekolah_tujuan}\nAlasan Pindah: \${alasan_pindah}\n\nBersama ini kami lampirkan dokumen akademik yang bersangkutan. Kami mengucapkan terima kasih atas partisipasi siswa tersebut selama menempuh pendidikan di sekolah kami."
      ],
      // 5. [NEW] SURAT TEGURAN / PERINGATAN (SP)
      [
        'name' => 'Surat Teguran Siswa (SP)',
        'description' => 'Surat peringatan tertulis atas pelanggaran tata tertib sekolah.',
        'file_name' => 'surat_teguran_siswa.docx',
        'variables' => ['nama_siswa', 'kelas', 'hari_tanggal', 'jenis_pelanggaran', 'sanksi'],
        'content' => "SURAT TEGURAN / PERINGATAN\n\nDiberikan kepada siswa:\nNama: \${nama_siswa}\nKelas: \${kelas}\n\nBerdasarkan catatan Bagian Kedisiplinan Sekolah, siswa tersebut telah melakukan pelanggaran Tata Tertib Sekolah, yaitu:\n\nBentuk Pelanggaran: \${jenis_pelanggaran}\nWaktu Kejadian: \${hari_tanggal}\n\nSehubungan dengan hal tersebut, sekolah memberikan TEGURAN KERAS agar yang bersangkutan tidak mengulangi perbuatannya. Apabila di kemudian hari masih melakukan pelanggaran, maka akan diberikan sanksi lebih berat berupa: \${sanksi}.\n\nDemikian surat teguran ini dibuat untuk diperhatikan dan ditaati."
      ],
      // 6. [NEW] SURAT IZIN MENINGGALKAN PELAJARAN (DISPENSASI)
      [
        'name' => 'Surat Izin / Dispensasi Siswa',
        'description' => 'Izin resmi siswa meninggalkan kelas untuk kegiatan lomba atau urusan mendesak.',
        'file_name' => 'surat_dispensasi.docx',
        'variables' => ['nama', 'kelas', 'hari_tanggal', 'kegiatan', 'waktu_kegiatan'],
        'content' => "SURAT IZIN / DISPENSASI\n\nKepala Sekolah memberikan izin/dispensasi kepada siswa:\n\nNama: \${nama}\nKelas: \${kelas}\n\nUntuk TIDAK MENGIKUTI Kegiatan Belajar Mengajar (KBM) pada:\n\nHari/Tanggal: \${hari_tanggal}\nWaktu: \${waktu_kegiatan}\n\nDikarenakan mengikuti kegiatan/keperluan: \${kegiatan}.\n\nSetelah kegiatan selesai, siswa diwajibkan segera melaporkan diri kembali ke sekolah/kelas. Demikian surat izin ini diberikan untuk dipergunakan semestinya."
      ],
      // 7. [NEW] SURAT REKOMENDASI BEASISWA
      [
        'name' => 'Surat Rekomendasi Beasiswa',
        'description' => 'Rekomendasi kepala sekolah untuk pengajuan beasiswa prestasi atau kurang mampu.',
        'file_name' => 'surat_rekomendasi_beasiswa.docx',
        'variables' => ['nama', 'nis', 'kelas', 'nama_beasiswa', 'tahun_akademik'],
        'content' => "SURAT REKOMENDASI BEASISWA\n\nKepala Sekolah dengan ini memberikan rekomendasi penuh kepada:\n\nNama Siswa: \${nama}\nNIS: \${nis}\nKelas: \${kelas}\n\nUntuk mengajukan permohonan sebagai penerima Program \${nama_beasiswa} Tahun Akademik \${tahun_akademik}.\n\nKami menyatakan bahwa siswa tersebut adalah benar peserta didik yang berprestasi/layak mendapatkan bantuan pendidikan tersebut, dan datanya telah kami verifikasi sesuai kondisi sebenarnya.\n\nDemikian rekomendasi ini kami berikan untuk menunjang kelancaran proses seleksi."
      ]
    ];

    // Ensure directory exists
    if (!Storage::disk('public')->exists('templates')) {
      Storage::disk('public')->makeDirectory('templates');
    }

    foreach ($templates as $t) {
      $phpWord = new PhpWord();
      $phpWord->setDefaultFontName('Times New Roman');
      $phpWord->setDefaultFontSize(12);

      // Section - A4
      $section = $phpWord->addSection([
        'paperSize' => 'A4',
        'marginTop' => 1134, // 2cm
        'marginLeft' => 1417, // 2.5cm
        'marginRight' => 1417, // 2.5cm
        'marginBottom' => 1134, // 2cm
      ]);

      // --- KOP SURAT (FIXED LAYOUT) ---
      $tableStyle = ['borderSize' => 0, 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED, 'alignment' => 'center'];
      $tableKop = $section->addTable($tableStyle);
      $row = $tableKop->addRow(1200);

      // Logo Left
      $cellLeft = $row->addCell(1500, ['valign' => 'center']);
      $cellLeft->addText('${dinas_logo}', [], ['alignment' => 'left']);

      // Text Center
      $cellCenter = $row->addCell(6072, ['valign' => 'center']);
      $cellCenter->addText('${kop_line1}', ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
      $cellCenter->addText('${kop_line2}', ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
      $cellCenter->addText('${school_name}', ['bold' => true, 'size' => 18], ['alignment' => 'center', 'spaceAfter' => 50]);
      $cellCenter->addText('${kop_address}', ['size' => 10], ['alignment' => 'center', 'spaceAfter' => 0]); // Increased size slighly
      $cellCenter->addText('${kop_contact}', ['size' => 9], ['alignment' => 'center', 'spaceAfter' => 0]);

      // Logo Right
      $cellRight = $row->addCell(1500, ['valign' => 'center']);
      $cellRight->addText('${school_logo}', [], ['alignment' => 'right']);

      $section->addTextBreak(1);
      $section->addText("__________________________________________________________________________", ['bold' => true], ['alignment' => 'center']);
      $section->addTextBreak(1);
      // --- END KOP ---

      // --- CONTENT BODY ---
      // Title
      $title = strtoupper($t['name']);
      // If content has title in first line, use that instead
      $lines = explode("\n", $t['content']);
      $firstLine = trim($lines[0]);

      // Check if first line marks a title (all caps, short)
      if (strtoupper($firstLine) === $firstLine && strlen($firstLine) < 50) {
        $section->addText($firstLine, ['bold' => true, 'size' => 14, 'underline' => 'single'], ['alignment' => 'center']);

        // Add "Nomor: ..." below title if typical surat format
        $section->addText("Nomor: 421.3/     /SMP.04/" . date('Y'), ['size' => 12], ['alignment' => 'center']); // Generic placeholder numbering

        array_shift($lines); // Remove title from lines
      } else {
        $section->addText($title, ['bold' => true, 'size' => 14, 'underline' => 'single'], ['alignment' => 'center']);
      }

      $section->addTextBreak(1);

      // Process Lines
      foreach ($lines as $line) {
        $cleanLine = trim($line);
        if ($cleanLine === '') {
          $section->addTextBreak(1);
        } else {
          // Detect "Key: Value" lines to indent or format nicely
          if (preg_match('/^[\w\s,]+:/', $cleanLine)) {
            // It's a field line (e.g. "Nama: Budi") -> Use specific tabbing or just text
            // For simplicity, just standard text but maybe bold the label?
            // Let's keep it simple: Justified paragraph for long text, Left for list
            $section->addText($cleanLine, ['size' => 12], ['alignment' => 'both']);
          } else {
            // Standard paragraph -> Justified for professionalism
            $section->addText($cleanLine, ['size' => 12], ['alignment' => 'both']);
          }
        }
      }

      // --- FOOTER / SIGNATURE ---
      $section->addTextBreak(2);

      // Signature Table to ensure it stays on right
      $sigTable = $section->addTable(['borderSize' => 0, 'width' => 100 * 50, 'unit' => 'pct']);
      $sigRow = $sigTable->addRow();

      $sigLeft = $sigRow->addCell(5000); // Empty left side

      $sigRight = $sigRow->addCell(4000); // Right side for signature
      // City and Date
      // We can try to guess City from Kop Address or just use standard
      $sigRight->addText('Ditetapkan di: Cianjur', null, ['alignment' => 'left']);
      $sigRight->addText('Pada Tanggal: ' . date('d F Y'), null, ['alignment' => 'left']);
      $sigRight->addText('Kepala Sekolah,');
      $sigRight->addTextBreak(3);
      $sigRight->addText('${principal_name}', ['bold' => true, 'underline' => 'single'], ['alignment' => 'left']);
      $sigRight->addText('NIP. ${principal_nip}', [], ['alignment' => 'left']);

      // Save
      $path = storage_path('app/public/templates/' . $t['file_name']);
      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
      $objWriter->save($path);

      // DB Update
      DocumentTemplate::updateOrCreate(
        ['name' => $t['name']],
        [
          'description' => $t['description'],
          'file_path' => 'templates/' . $t['file_name'],
          'variables' => $t['variables'],
          'type' => 'student'
        ]
      );
    }
  }
}
