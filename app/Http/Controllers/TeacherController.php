<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%");
        }

        $teachers = $query->latest()->paginate(10);
        return view('backend.master-data.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('backend.master-data.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'nullable|unique:teachers',
            'name' => 'required',
            'gender' => 'required|in:L,P',
            'position' => 'required',
            'email' => 'nullable|email|unique:teachers',
        ]);

        Teacher::create($request->all());

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        return view('backend.master-data.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'nip' => ['nullable', Rule::unique('teachers')->ignore($teacher->id)],
            'name' => 'required',
            'gender' => 'required|in:L,P',
            'position' => 'required',
            'email' => ['nullable', 'email', Rule::unique('teachers')->ignore($teacher->id)],
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\TeachersExport, 'teachers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new \App\Imports\TeachersImport, $request->file('file'));

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diimport.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\TeacherTemplateExport, 'template_guru.xlsx');
    }
}
