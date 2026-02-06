<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
  private $rowNumber = 0;

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Student::all();
  }

  public function headings(): array
  {
    return [
      'No',
      'NIS',
      'NISN',
      'Nama Lengkap',
      'Jenis Kelamin',
      'Kelas',
      'Tempat Lahir',
      'Tanggal Lahir',
      'Agama',
      'Nama Ayah',
      'Nama Ibu',
      'Telp Ortu',
      'Alamat Ortu',
      'Sekolah Asal',
      'Email',
      'No. HP',
      'Status'
    ];
  }

  public function map($student): array
  {
    return [
      ++$this->rowNumber,
      $student->nis,
      $student->nisn,
      $student->name,
      $student->gender == 'L' ? 'Laki-laki' : 'Perempuan',
      $student->class,
      $student->place_of_birth,
      $student->date_of_birth,
      $student->religion,
      $student->father_name,
      $student->mother_name,
      $student->parent_phone,
      $student->parent_address,
      $student->previous_school,
      $student->email,
      $student->phone,
      $student->status,
    ];
  }
}
