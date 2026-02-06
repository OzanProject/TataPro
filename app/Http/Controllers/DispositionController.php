<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\IncomingMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispositionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Inbox: Disposisi yang ditujukan ke user ini
        $inbox = Disposition::with(['sender', 'incoming_mail.category'])
                    ->where('to_user_id', $userId)
                    ->latest()
                    ->get();

        // Outbox: Disposisi yang dibuat oleh user ini
        $outbox = Disposition::with(['receiver', 'incoming_mail.category'])
                    ->where('from_user_id', $userId)
                    ->latest()
                    ->get();
                    
        return view('backend.correspondence.disposition.index', compact('inbox', 'outbox'));
    }

    public function create(IncomingMail $incoming)
    {
        $users = User::where('id', '!=', Auth::id())->get(); // List users to dispose to
        return view('backend.correspondence.disposition.create', compact('incoming', 'users'));
    }

    public function store(Request $request, IncomingMail $incoming)
    {
        $validated = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'instruction' => 'required|string',
            'note' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|string'
        ]);

        $disposition = new Disposition($validated);
        $disposition->incoming_mail_id = $incoming->id;
        $disposition->from_user_id = Auth::id();
        $disposition->save();

        // Update status surat masuk jika belum didisposisi
        if ($incoming->status == 'received') {
            $incoming->update(['status' => 'dispositioned']);
        }

        return redirect()->route('incoming.show', $incoming->id)->with('success', 'Disposisi berhasil dibuat.');
    }

    public function destroy(Disposition $disposition)
    {
        $incomingId = $disposition->incoming_mail_id;
        $disposition->delete();
        return redirect()->route('incoming.show', $incomingId)->with('success', 'Disposisi berhasil dihapus.');
    }

    public function print(IncomingMail $incoming)
    {
        // Load relationships needed for the print view
        $incoming->load(['category', 'dispositions.sender', 'dispositions.receiver']);
        return view('backend.correspondence.disposition.print', compact('incoming'));
    }

    public function updateStatus(Request $request, Disposition $disposition)
    {
        // Pastikan hanya penerima yang bisa update status
        if ($disposition->to_user_id != Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengubah status disposisi ini.');
        }

        $validated = $request->validate([
            'status' => 'required|in:todo,completed,in_progress',
            'note' => 'nullable|string' // New note (reply)
        ]);

        // Logic: Jika ada note baru, append ke note lama atau overwrite?
        // Simpelnya: Append agar history terjaga
        if ($request->note) {
            $existingNote = $disposition->note ? $disposition->note . "\n\n" : "";
            $updaterName = Auth::user()->name;
            $timestamp = now()->format('d/m H:i');
            $validated['note'] = $existingNote . "[{$updaterName} - {$timestamp}]: " . $request->note;
        }

        $disposition->update([
            'status' => $validated['status'],
            'note' => $validated['note'] ?? $disposition->note
        ]);

        return back()->with('success', 'Status disposisi berhasil diperbarui.');
    }
}
