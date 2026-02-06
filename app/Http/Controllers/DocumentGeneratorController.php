<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentGeneratorController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'student');
        $title = $type == 'student' ? 'Template Surat Siswa' : 'Template Surat Guru';

        $templates = DocumentTemplate::where('type', $type)->latest()->get();
        return view('backend.documents.generator.index', compact('templates', 'type', 'title'));
    }

    public function create(DocumentTemplate $template)
    {
        return view('backend.documents.generator.create', compact('template'));
    }

    public function store(Request $request, DocumentTemplate $template)
    {
        // 1. Get the path
        $filePath = storage_path('app/public/' . $template->file_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File template tidak ditemukan di server.');
        }

        // 2. Load Template
        try {
            $templateProcessor = new TemplateProcessor($filePath);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat template: ' . $e->getMessage());
        }

        // 3. Set Values
        // Fetch Settings
        $settings = \App\Models\Setting::all()->pluck('value', 'key');

        // Inject Global Settings (School Name, Principal, etc)
        // Inject Global Settings (School Name, Principal, etc)
        // Inject Global Settings (School Name, Principal, etc)
        foreach ($settings as $key => $val) {
            // Check if it is an image key (ONLY logos now, not letterhead)
            if (in_array($key, ['school_logo', 'dinas_logo']) && $val && file_exists(storage_path('app/public/' . $val))) {
                $templateProcessor->setImageValue($key, [
                    'path' => storage_path('app/public/' . $val),
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            } else {
                // For letterhead, we are now just passing text variables which are already in $settings
                // kop_line1, kop_line2, etc. are treated as normal values.
                $templateProcessor->setValue($key, $val);
            }
        }

        // Variables stored in DB is array of names like ['nama', 'alamat']
        foreach ($template->variables ?? [] as $variable) {
            $value = $request->input($variable, '-');
            $templateProcessor->setValue($variable, $value);
        }

        // 4. Save to temporary file
        $fileName = 'Generated_' . str_replace(' ', '_', $template->name) . '_' . time() . '.docx';
        $tempPath = storage_path('app/public/temp/' . $fileName);

        // Ensure temp dir exists
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $templateProcessor->saveAs($tempPath);

        // 5. Download and delete temp file
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
    public function selectTemplateForStudent(\App\Models\Student $student)
    {
        $templates = \App\Models\DocumentTemplate::where('type', 'student')->latest()->get();
        return view('backend.documents.generator.select_student', compact('templates', 'student'));
    }

    public function createForStudent(\App\Models\DocumentTemplate $template, \App\Models\Student $student)
    {
        // Auto-fill Logic
        $data = [
            'nama' => $student->name,
            'nama_siswa' => $student->name,
            'name' => $student->name,
            'nis' => $student->nis,
            'nisn' => $student->nisn,
            'kelas' => $student->class,
            'email' => $student->email,
            'hp' => $student->phone,
            'status' => $student->status,
        ];

        return view('backend.documents.generator.create', compact('template', 'data'));
    }

    public function selectTemplateForTeacher(\App\Models\Teacher $teacher)
    {
        $templates = \App\Models\DocumentTemplate::where('type', 'teacher')->latest()->get();
        return view('backend.documents.generator.select_teacher', compact('templates', 'teacher'));
    }

    public function createForTeacher(\App\Models\DocumentTemplate $template, \App\Models\Teacher $teacher)
    {
        // Auto-fill Logic for Teacher
        $data = [
            'nama' => $teacher->name,
            'nama_guru' => $teacher->name,
            'nip' => $teacher->nip,
            'jabatan' => $teacher->position,
            'posisi' => $teacher->position,
            'email' => $teacher->email,
            'hp' => $teacher->phone, // generic
            'phone' => $teacher->phone,
            'alamat' => $teacher->address,
            'unit_kerja' => 'SMP Negeri 4 Kadupandak', // Default or fetch from settings?
            'pangkat_golongan' => '-', // Add to Teacher model if needed
            'mata_pelajaran' => '..................', // Add to Teacher model if needed
            'semester' => 'Genap', // Dynamic based on date?
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
            'tempat_lahir' => $teacher->birth_place,
            'tanggal_lahir' => $teacher->birth_date,
            'jenis_kelamin' => $teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'agama' => $teacher->religion ?? '-',
        ];

        return view('backend.documents.generator.create', compact('template', 'data'));
    }
}
