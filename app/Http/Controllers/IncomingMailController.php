<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;
use App\Models\MailCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IncomingMailController extends Controller
{
    public function index()
    {
        $incomingMails = IncomingMail::with('category')->latest()->paginate(10);
        return view('backend.correspondence.incoming.index', compact('incomingMails'));
    }

    public function create()
    {
        $categories = MailCategory::all();
        // Auto-generate agenda number (simple logic for now)
        $lastMail = IncomingMail::latest('id')->first();
        $agendaNumber = $lastMail ? intval($lastMail->agenda_number) + 1 : 1;
        $agendaNumber = str_pad($agendaNumber, 4, '0', STR_PAD_LEFT);

        return view('backend.correspondence.incoming.create', compact('categories', 'agendaNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mail_number' => 'required|string|max:255',
            'sender_origin' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'received_date' => 'required|date',
            'mail_date' => 'required|date',
            'category_id' => 'required|exists:mail_categories,id',
            'agenda_number' => 'required|unique:incoming_mails,agenda_number',
            'file_path' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('incoming_mails', 'public');
            $validated['file_path'] = $path;
        }

        IncomingMail::create($validated);

        return redirect()->route('incoming.index')->with('success', 'Surat Masuk berhasil dicatat.');
    }

    public function show(IncomingMail $incoming)
    {
        // Route model binding uses 'incoming' parameter name from route
        // Route::resource uses {incoming} as placeholder
        return view('backend.correspondence.incoming.show', compact('incoming'));
    }

    public function edit(IncomingMail $incoming)
    {
        $categories = MailCategory::all();
        return view('backend.correspondence.incoming.edit', compact('incoming', 'categories'));
    }

    public function update(Request $request, IncomingMail $incoming)
    {
        $validated = $request->validate([
            'agenda_number' => 'required|unique:incoming_mails,agenda_number,' . $incoming->id,
            'mail_number' => 'required|string|max:255',
            'sender_origin' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'received_date' => 'required|date',
            'mail_date' => 'required|date',
            'category_id' => 'required|exists:mail_categories,id',
            'file_path' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($incoming->file_path && Storage::disk('public')->exists($incoming->file_path)) {
                Storage::disk('public')->delete($incoming->file_path);
            }
            $path = $request->file('file_path')->store('incoming_mails', 'public');
            $validated['file_path'] = $path;
        }

        $incoming->update($validated);

        return redirect()->route('incoming.index')->with('success', 'Surat Masuk berhasil diperbarui.');
    }

    public function destroy(IncomingMail $incoming)
    {
        if ($incoming->file_path && Storage::disk('public')->exists($incoming->file_path)) {
            Storage::disk('public')->delete($incoming->file_path);
        }
        
        $incoming->delete();
        
        return redirect()->route('incoming.index')->with('success', 'Surat Masuk berhasil dihapus.');
    }
}
