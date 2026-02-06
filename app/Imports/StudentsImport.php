<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip if NIS is empty
        if (!isset($row['nis']) || empty($row['nis'])) {
            return null;
        }

        // Check if student with this NIS already exists
        if (Student::where('nis', $row['nis'])->exists()) {
            return null; // Skip duplicates
        }

        // Normalize Gender
        $rawGender = strtoupper(trim($row['jenis_kelamin'] ?? ''));
        $gender = 'L'; // Default
        if (in_array($rawGender, ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE', 'PR'])) {
            $gender = 'P';
        }

        return new Student([
            'nis' => $row['nis'],
            'nisn' => $row['nisn'] ?? null,
            'name' => $row['nama_lengkap'] ?? $row['nama'] ?? '-',
            'gender' => $gender,
            'class' => $row['kelas'] ?? '-',
            'place_of_birth' => $row['tempat_lahir'] ?? null,
            'date_of_birth' => isset($row['tanggal_lahir']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']) : null,
            'religion' => $row['agama'] ?? null,
            'father_name' => $row['nama_ayah'] ?? null,
            'mother_name' => $row['nama_ibu'] ?? null,
            'father_job' => $row['pekerjaan_ayah'] ?? null,
            'mother_job' => $row['pekerjaan_ibu'] ?? null,
            'parent_phone' => $row['no_hp_ortu'] ?? null,
            'parent_address' => $row['alamat_ortu'] ?? null,
            'previous_school' => $row['sekolah_asal'] ?? null,
            'accepted_grade' => $row['diterima_kelas'] ?? null,
            'accepted_date' => isset($row['diterima_tanggal']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['diterima_tanggal']) : null,
            'email' => $row['email'] ?? null,
            'phone' => $row['hp'] ?? $row['no_hp'] ?? null,
            'address' => $row['alamat'] ?? null,
            'status' => strtolower($row['status'] ?? 'active'),
        ]);
    }
}
