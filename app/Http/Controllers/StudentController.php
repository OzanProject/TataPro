<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('nis', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%")
                ->orWhere('class', 'like', "%{$search}%");
        }

        $students = $query->latest()->paginate(10);
        return view('backend.master-data.students.index', compact('students'));
    }

    public function create()
    {
        return view('backend.master-data.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:students,nis',
            'nisn' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'class' => 'required|string',
            'email' => 'nullable|email',
            'status' => 'required|in:active,graduated,moved,inactive',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function bukuInduk($id)
    {
        $student = Student::findOrFail($id);
        $settings = \App\Models\Setting::whereIn('key', [
            'school_name',
            'school_city',
            'principal_name',
            'principal_nip',
            'school_logo'
        ])->pluck('value', 'key');

        return view('backend.master-data.students.buku_induk', compact('student', 'settings'));
    }

    public function edit(Student $student)
    {
        return view('backend.master-data.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'nisn' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'class' => 'required|string',
            'email' => 'nullable|email',
            'status' => 'required|in:active,graduated,moved,inactive',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data siswa yang dipilih.');
        }

        Student::whereIn('id', $ids)->delete();
        return redirect()->route('students.index')->with('success', count($ids) . ' data siswa berhasil dihapus.');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StudentsExport, 'data_siswa-' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\StudentsImport, $request->file('file'));
            return redirect()->route('students.index')->with('success', 'Data siswa berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('students.index')->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = [
            'nis',
            'nisn',
            'nama_lengkap',
            'jenis_kelamin',
            'kelas',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'no_hp_ortu',
            'alamat_ortu',
            'sekolah_asal',
            'diterima_kelas',
            'diterima_tanggal',
            'email',
            'hp',
            'alamat',
            'status'
        ];
        $sheet->fromArray($headers, NULL, 'A1');

        // Sample Data
        $sample = ['2026001', '0012345678', 'John Doe', 'L', 'X IPA 1', 'john@example.com', '08123456789', 'Jl. Merdeka No. 1', 'active'];
        $sheet->fromArray($sample, NULL, 'A2');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $fileName = 'Template_Import_Siswa.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), 'Excel');
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function bulkPrint(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('students.index');
        }

        $ids = $request->input('ids');
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang dipilih.');
        }

        $students = Student::whereIn('id', $ids)->get();
        $settings = $this->getSchoolSettings();

        return view('backend.master-data.students.buku_induk', compact('students', 'settings'));
    }

    private function getSchoolSettings()
    {
        return \App\Models\Setting::whereIn('key', [
            'school_name',
            'school_city',
            'principal_name',
            'principal_nip',
            'school_logo'
        ])->pluck('value', 'key');
    }
}
