<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TeachersImport implements ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    // Skip if name is missing
    if (!isset($row['name']) || !$row['name']) {
      return null;
    }

    $gender = $this->normalizeGender($row['gender'] ?? null);
    $status = $this->normalizeStatus($row['status'] ?? null);

    $birthDate = null;
    if (isset($row['birth_date'])) {
      try {
        if (is_numeric($row['birth_date'])) {
          $birthDate = Date::excelToDateTimeObject($row['birth_date']);
        } else {
          $birthDate = \Carbon\Carbon::parse($row['birth_date']);
        }
      } catch (\Exception $e) {
        $birthDate = null;
      }
    }

    return new Teacher([
      'nip' => $row['nip'] ?? null,
      'name' => $row['name'],
      'gender' => $gender,
      'position' => $row['position'] ?? 'Guru Mata Pelajaran',
      'email' => $row['email'] ?? null,
      'phone' => $row['phone'] ?? null,
      'address' => $row['address'] ?? null,
      'birth_place' => $row['birth_place'] ?? null,
      'birth_date' => $birthDate,
      'religion' => $row['religion'] ?? null,
      'status' => $status,
    ]);
  }

  private function normalizeGender($input)
  {
    if (!$input)
      return 'L'; // Default
    $input = strtoupper(trim($input));

    if (in_array($input, ['L', 'LAKI', 'LAKI-LAKI', 'PRIA', 'MALE', 'MAN']))
      return 'L';
    if (in_array($input, ['P', 'PEREMPUAN', 'WANITA', 'FEMALE', 'WOMAN']))
      return 'P';

    return 'L'; // Default fall back
  }

  private function normalizeStatus($input)
  {
    if (!$input)
      return 'active';
    $input = strtolower(trim($input));

    if (in_array($input, ['aktif', 'active', 'ok', 'yes']))
      return 'active';
    if (in_array($input, ['pensiun', 'retired']))
      return 'retired';
    if (in_array($input, ['tidak aktif', 'inactive', 'nonaktif', 'keluar']))
      return 'inactive';

    return 'active';
  }
}
