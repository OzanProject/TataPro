<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailCategory;

class MailCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MailCategory::all();
        return view('backend.master-data.mail-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:mail_categories,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        MailCategory::create($request->all());

        return redirect()->route('mail-categories.index')->with('success', 'Kategori surat berhasil ditambahkan.');
    }

    public function update(Request $request, MailCategory $mail_category)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:mail_categories,code,' . $mail_category->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $mail_category->update($request->all());

        return redirect()->route('mail-categories.index')->with('success', 'Kategori surat berhasil diperbarui.');
    }

    public function destroy(MailCategory $mail_category)
    {
        $mail_category->delete();
        return redirect()->route('mail-categories.index')->with('success', 'Kategori surat berhasil dihapus.');
    }
}
