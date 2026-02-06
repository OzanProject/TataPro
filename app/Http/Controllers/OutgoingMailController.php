<?php

namespace App\Http\Controllers;

use App\Models\OutgoingMail;
use App\Models\MailCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class OutgoingMailController extends Controller
{
    public function index(Request $request)
    {
        $query = OutgoingMail::with(['category', 'approver']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('mail_number', 'like', "%{$search}%")
                    ->orWhere('recipient_destination', 'like', "%{$search}%");
            });
        }

        $outgoing = $query->latest()->paginate(10);
        return view('backend.correspondence.outgoing.index', compact('outgoing'));
    }

    public function create()
    {
        $categories = MailCategory::all();
        // Simple auto-agenda logic for suggestion
        $lastMail = OutgoingMail::latest('id')->first();
        // Agenda number might be null if draft, so careful
        $lastAgenda = $lastMail ? intval($lastMail->agenda_number) : 0;
        $agendaNumber = str_pad($lastAgenda + 1, 4, '0', STR_PAD_LEFT);

        return view('backend.correspondence.outgoing.create', compact('categories', 'agendaNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mail_number' => 'nullable|string|max:255', // Bisa null dulu kalau draft
            'agenda_number' => 'nullable|unique:outgoing_mails,agenda_number',
            'recipient_destination' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'mail_date' => 'required|date',
            'category_id' => 'required|exists:mail_categories,id',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,pending_approval,sent'
        ]);

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('outgoing_mails', 'public');
            $validated['file_path'] = $path;
        }

        OutgoingMail::create($validated);

        return redirect()->route('outgoing.index')->with('success', 'Surat Keluar berhasil dicatat.');
    }

    public function show(OutgoingMail $outgoing)
    {
        return view('backend.correspondence.outgoing.show', compact('outgoing'));
    }

    public function edit(OutgoingMail $outgoing)
    {
        $categories = MailCategory::all();
        return view('backend.correspondence.outgoing.edit', compact('outgoing', 'categories'));
    }

    public function update(Request $request, OutgoingMail $outgoing)
    {
        $validated = $request->validate([
            'mail_number' => 'nullable|string|max:255',
            'agenda_number' => 'nullable|unique:outgoing_mails,agenda_number,' . $outgoing->id,
            'recipient_destination' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'mail_date' => 'required|date',
            'category_id' => 'required|exists:mail_categories,id',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:draft,pending_approval,sent,signed'
        ]);

        if ($request->hasFile('file_path')) {
            if ($outgoing->file_path && Storage::disk('public')->exists($outgoing->file_path)) {
                Storage::disk('public')->delete($outgoing->file_path);
            }
            $path = $request->file('file_path')->store('outgoing_mails', 'public');
            $validated['file_path'] = $path;
        }

        $outgoing->update($validated);

        return redirect()->route('outgoing.index')->with('success', 'Surat Keluar berhasil diperbarui.');
    }

    public function preview(OutgoingMail $outgoing)
    {
        return view('backend.correspondence.outgoing.preview', compact('outgoing'));
    }

    public function destroy(OutgoingMail $outgoing)
    {
        if ($outgoing->file_path && Storage::disk('public')->exists($outgoing->file_path)) {
            Storage::disk('public')->delete($outgoing->file_path);
        }

        $outgoing->delete();

        return redirect()->route('outgoing.index')->with('success', 'Surat Keluar berhasil dihapus.');
    }
}
