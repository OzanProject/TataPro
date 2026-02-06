<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TeacherTemplateExport implements WithHeadings, ShouldAutoSize
{
  public function headings(): array
  {
    return [
      'nip',
      'name',
      'gender',
      'position',
      'email',
      'phone',
      'status'
    ];
  }
}
