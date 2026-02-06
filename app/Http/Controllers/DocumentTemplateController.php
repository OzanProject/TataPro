<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class DocumentTemplateController extends Controller
{
    public function sample()
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        
        $styleFont = ['name' => 'Arial', 'size' => 12];
        $styleBold = ['name' => 'Arial', 'size' => 12, 'bold' => true];
        
        $section->addText('SURAT KETERANGAN', ['name' => 'Arial', 'size' => 14, 'bold' => true], ['alignment' => 'center']);
        $section->addTextBreak(2);
        
        $section->addText('Yang bertanda tangan di bawah ini Kepala Sekolah, menerangkan bahwa:', $styleFont);
        $section->addTextBreak(1);
        
        $section->addText('Nama    : ${nama_siswa}', $styleFont);
        $section->addText('NIS     : ${nis}', $styleFont);
        $section->addText('Kelas   : ${kelas}', $styleFont);
        $section->addTextBreak(1);
        
        $section->addText('Adalah benar-benar siswa aktif pada tahun ajaran ini. Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.', $styleFont);
        $section->addTextBreak(2);
        
        $section->addText('Jakarta, ${tanggal_surat}', $styleFont, ['alignment' => 'right']);
        $section->addTextBreak(3);
        $section->addText('Kepala Sekolah', $styleBold, ['alignment' => 'right']);

        $fileName = 'Contoh_Template_Surat.docx';
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function index()
    {
        $templates = DocumentTemplate::latest()->get();
        return view('backend.documents.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('backend.documents.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:docx|max:2048', // Only allow .docx
            'description' => 'nullable|string'
        ]);

        $path = $request->file('file')->store('templates', 'public');
        
        // Detect variables in the uploaded file
        $variables = $this->detectVariables(storage_path('app/public/' . $path));

        DocumentTemplate::create([
            'name' => $request->name,
            'description' => $request->description,
            'file_path' => $path,
            'variables' => $variables
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil ditambahkan. Variabel terdeteksi: ' . count($variables));
    }

    public function edit(DocumentTemplate $template)
    {
        return view('backend.documents.templates.edit', compact('template'));
    }

    public function update(Request $request, DocumentTemplate $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|mimes:docx|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }
            
            // Store new file
            $path = $request->file('file')->store('templates', 'public');
            $data['file_path'] = $path;
            
            // Detect variables again
            $data['variables'] = $this->detectVariables(storage_path('app/public/' . $path));
        }

        $template->update($data);

        return redirect()->route('templates.index')->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy(DocumentTemplate $template)
    {
        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus.');
    }

    // Helper to detect ${variable} in docx
    private function detectVariables($filePath)
    {
        $content = '';
        $zip = new ZipArchive;

        if ($zip->open($filePath) === TRUE) {
            // Read document.xml which contains the body text
            if ($zip->locateName('word/document.xml') !== false) {
                 $content = $zip->getFromName('word/document.xml');
            }
            $zip->close();
        }

        // Regex to find ${...} patterns
        // Note: This is basic regex. Complex Word formatting might break it.
        preg_match_all('/\$\{(.*?)\}/', $content, $matches);
        
        $variables = array_unique($matches[1] ?? []);
        return array_values($variables);
    }
}
