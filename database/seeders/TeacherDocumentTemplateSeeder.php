<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentTemplate;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

class TeacherDocumentTemplateSeeder extends Seeder
{
  public function run()
  {
    $templates = [
      [
        'name' => 'Surat Tugas Guru',
        'file_name' => 'surat_tugas_guru.docx',
        'description' => 'Surat penugasan untuk mengajar atau kepanitiaan.',
        'variables' => ['nomor_surat', 'dasar_surat', 'nama_guru', 'nip', 'jabatan', 'unit_kerja', 'tujuan_tugas', 'waktu_pelaksanaan', 'tempat_pelaksanaan'],
        'content' => 'SPECIAL_SURAT_TUGAS' // Special marker to handle custom logic
      ],
      [
        'name' => 'Surat Keputusan (SK) Guru',
        'file_name' => 'sk_guru.docx',
        'description' => 'SK Mengajar, Wali Kelas, atau Pembina Ekskul.',
        'variables' => ['nama_guru', 'nip', 'jabatan', 'jenis_sk', 'tahun_ajaran', 'ditetapkan_di', 'tanggal_sk'],
        'content' => 'MEMUTUSKAN\n\nMenetapkan:\n\nNama: ${nama_guru}\nNIP: ${nip}\nJabatan: ${jabatan}\n\nSebagai ${jenis_sk} pada Tahun Ajaran ${tahun_ajaran}.\n\nKeputusan ini berlaku sejak tanggal ditetapkan.'
      ],
      [
        'name' => 'Surat Undangan Rapat Guru',
        'file_name' => 'undangan_rapat_guru.docx',
        'description' => 'Undangan rapat rutin, evaluasi, atau kelulusan.',
        'variables' => ['nama_guru', 'hari_tanggal', 'waktu', 'agenda', 'ruangan'],
        'content' => 'Mengundang Bapak/Ibu Guru:\n\nNama: ${nama_guru}\n\nUntuk menghadiri rapat yang akan diselenggarakan pada:\n\nHari/Tanggal: ${hari_tanggal}\nPukul: ${waktu}\nTempat: ${ruangan}\nAgenda: ${agenda}\n\nDemikian undangan ini kami sampaikan.'
      ],
      [
        'name' => 'Surat Pemberitahuan Guru',
        'file_name' => 'pemberitahuan_guru.docx',
        'description' => 'Informasi perubahan jadwal atau kebijakan sekolah.',
        'variables' => ['perihal', 'isi_pemberitahuan'],
        'content' => 'Kepada Yth. Bapak/Ibu Guru\ndi Tempat\n\nPerihal: ${perihal}\n\nDengan hormat,\n\n${isi_pemberitahuan}\n\nDemikian pemberitahuan ini, atas perhatiannya diucapkan terima kasih.'
      ],
      [
        'name' => 'Surat Keterangan Aktif Mengajar',
        'file_name' => 'ket_aktif_mengajar.docx',
        'description' => 'Keterangan bahwa guru masih aktif mengajar.',
        'variables' => ['nama_guru', 'nip', 'pangkat_golongan', 'mata_pelajaran', 'semester'],
        'content' => 'Menerangkan dengan sesungguhnya bahwa:\n\nNama: ${nama_guru}\nNIP: ${nip}\nPangkat/Golongan: ${pangkat_golongan}\n\nAdalah benar-benar guru aktif mengajar mata pelajaran ${mata_pelajaran} pada semester ${semester} tahun ini.\n\nDemikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.'
      ]
    ];

    // Ensure directory exists
    if (!file_exists(storage_path('app/public/templates'))) {
      mkdir(storage_path('app/public/templates'), 0755, true);
    }

    foreach ($templates as $t) {
      $phpWord = new PhpWord();

      // Set Default Font
      $phpWord->setDefaultFontName('Times New Roman');
      $phpWord->setDefaultFontSize(12);

      // Section with Margins - A4 Standard
      $section = $phpWord->addSection([
        'paperSize' => 'A4',
        'marginTop' => 1134, // 2cm
        'marginLeft' => 1417, // 2.5cm
        'marginRight' => 1417, // 2.5cm
        'marginBottom' => 1134, // 2cm
      ]);

      // --- KOP SURAT (IN BODY) ---
      $tableStyle = [
        'borderSize' => 0,
        'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
        'alignment' => 'center'
      ];

      $tableKop = $section->addTable($tableStyle);
      $row = $tableKop->addRow(1200);

      // Left Logo Cell
      $cellLeft = $row->addCell(1500, ['valign' => 'center']);
      $cellLeft->addText('${dinas_logo}', [], ['alignment' => 'left']);

      // Center Text Cell
      $cellCenter = $row->addCell(6072, ['valign' => 'center']);
      $cellCenter->addText('${kop_line1}', ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
      $cellCenter->addText('${kop_line2}', ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
      $cellCenter->addText('${school_name}', ['bold' => true, 'size' => 18], ['alignment' => 'center', 'spaceAfter' => 50]);
      $cellCenter->addText('${kop_address}', ['size' => 9], ['alignment' => 'center', 'spaceAfter' => 0]);
      $cellCenter->addText('${kop_contact}', ['size' => 9], ['alignment' => 'center', 'spaceAfter' => 0]);

      // Right Logo Cell
      $cellRight = $row->addCell(1500, ['valign' => 'center']);
      $cellRight->addText('${school_logo}', [], ['alignment' => 'right']);

      $section->addTextBreak(1);
      $section->addText("__________________________________________________________________________", ['bold' => true], ['alignment' => 'center']);
      $section->addTextBreak(1);
      // --- END KOP SURAT ---

      if ($t['content'] === 'SPECIAL_SURAT_TUGAS') {
        // --- CUSTOM FORMAT FOR SURAT TUGAS ---

        // Title
        $section->addText('SURAT TUGAS', ['bold' => true, 'size' => 14, 'underline' => 'single'], ['alignment' => 'center']);
        $section->addText('Nomor: ${nomor_surat}', ['size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(1);

        // Dasar
        $tableDasar = $section->addTable(['borderSize' => 0]);
        $rowDasar = $tableDasar->addRow();
        $rowDasar->addCell(1500)->addText('Dasar', ['bold' => true]);
        $rowDasar->addCell(500)->addText(':', ['bold' => true]);
        $rowDasar->addCell(8000)->addText('${dasar_surat}', [], ['alignment' => 'both']); // Justified

        $section->addTextBreak(1);
        $section->addText('MEMERINTAHKAN', ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $section->addText('Kepada:', ['bold' => true]);

        // Table: No, Nama, Jabatan, Unit
        $styleTable = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50];
        $styleFirstRow = ['borderBottomSize' => 18, 'bgColor' => 'E0E0E0'];
        $phpWord->addTableStyle('TeacherListTable', $styleTable, $styleFirstRow);
        $table = $section->addTable('TeacherListTable');

        $table->addRow();
        $table->addCell(500)->addText('No.', ['bold' => true]);
        $table->addCell(3500)->addText('Nama', ['bold' => true]);
        $table->addCell(2500)->addText('Jabatan', ['bold' => true]);
        $table->addCell(3000)->addText('Unit Kerja', ['bold' => true]);

        // Row for the teacher
        $table->addRow();
        $table->addCell(500)->addText('1');
        $table->addCell(3500)->addText('${nama_guru}');
        $table->addCell(2500)->addText('${jabatan}');
        $table->addCell(3000)->addText('${unit_kerja}');

        $section->addTextBreak(1);

        // Untuk
        $tableUntuk = $section->addTable(['borderSize' => 0]);
        $rowUntuk = $tableUntuk->addRow();
        $rowUntuk->addCell(1500)->addText('Untuk', ['bold' => true]);
        $rowUntuk->addCell(500)->addText(':', ['bold' => true]);
        $rowUntuk->addCell(8000)->addText('${tujuan_tugas}', [], ['alignment' => 'both']);

        $section->addTextBreak(1);
        $section->addText('Pada:', ['bold' => true]);

        $tablePada = $section->addTable(['borderSize' => 0]);
        $rowPada = $tablePada->addRow();
        $rowPada->addCell(2500)->addText('Hari/Tanggal');
        $rowPada->addCell(500)->addText(':');
        $rowPada->addCell(6000)->addText('${waktu_pelaksanaan}');

        $rowPada = $tablePada->addRow();
        $rowPada->addCell(2500)->addText('Tempat');
        $rowPada->addCell(500)->addText(':');
        $rowPada->addCell(6000)->addText('${tempat_pelaksanaan}');

        $section->addTextBreak(1);
        $section->addText('Demikian surat tugas ini kami berikan untuk dilaksanakan dengan rasa penuh tanggung jawab.');
        $section->addTextBreak(2);

        // Footer (SPPD Style & Signature)
        // Use a table with 2 columns to separate "Tiba Di" (Left) and "Signature" (Right)
        $footerTable = $section->addTable(['borderSize' => 0, 'width' => 100 * 50, 'unit' => 'pct']);
        $footerRow = $footerTable->addRow();

        // Left Column (Tiba Di)
        $cellLeft = $footerRow->addCell(5000);
        $cellLeft->addText('Tiba di: _______________________');
        $cellLeft->addText('Pada Tanggal: ________________');
        $cellLeft->addText('Kepala _______________________');
        $cellLeft->addTextBreak(3);
        $cellLeft->addText('(_____________________________)');
        $cellLeft->addText('NIP. ');

        // Right Column (Signature)
        $cellRight = $footerRow->addCell(5000);
        $cellRight->addText('Ditetapkan di: ${school_address}'); // Assuming school address city
        $cellRight->addText('Pada Tanggal: ' . date('d F Y'));
        $cellRight->addText('Kepala Sekolah,');
        $cellRight->addTextBreak(3);
        $cellRight->addText('${principal_name}', ['bold' => true, 'underline' => 'single']);
        $cellRight->addText('NIP. ${principal_nip}');

      } else {
        // --- STANDARD TEMPLATES ---
        $section->addText(strtoupper($t['name']), ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $lines = explode('\n', $t['content']);
        foreach ($lines as $line) {
          $section->addText($line, ['size' => 11]);
        }

        $section->addTextBreak(2);

        // Simple Signature
        $section->addText('Ditetapkan di: ' . '${school_address}', null, ['alignment' => 'right']);
        $section->addText('Pada Tanggal: ' . date('d F Y'), null, ['alignment' => 'right']);
        $section->addTextBreak(3);
        $section->addText('${principal_name}', ['bold' => true, 'underline' => 'single'], ['alignment' => 'right']);
        $section->addText('NIP. ${principal_nip}', [], ['alignment' => 'right']);
      }

      $path = storage_path('app/public/templates/' . $t['file_name']);
      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
      $objWriter->save($path);

      DocumentTemplate::updateOrCreate(
        ['name' => $t['name']],
        [
          'description' => $t['description'],
          'file_path' => 'templates/' . $t['file_name'],
          'variables' => $t['variables'],
          'type' => 'teacher',
        ]
      );
    }
  }
}
