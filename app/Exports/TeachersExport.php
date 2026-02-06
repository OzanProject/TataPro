<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Teacher::all();
  }

  public function headings(): array
  {
    return [
      'ID',
      'NIP',
      'Name',
      'Gender',
      'Position',
      'Email',
      'Phone',
      'Address',
      'Birth Place',
      'Birth Date',
      'Religion'
    ];
  }

  public function map($teacher): array
  {
    return [
      $teacher->id,
      $teacher->nip,
      $teacher->name,
      $teacher->gender,
      $teacher->position,
      $teacher->email,
      $teacher->phone,
      $teacher->address,
      $teacher->birth_place,
      $teacher->birth_date,
      $teacher->religion,
    ];
  }
}
