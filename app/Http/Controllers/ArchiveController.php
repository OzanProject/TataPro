<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;
use App\Models\OutgoingMail;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $results = collect();

        if ($query) {
            // Search Incoming
            $incoming = IncomingMail::where('subject', 'like', "%$query%")
                        ->orWhere('mail_number', 'like', "%$query%")
                        ->orWhere('sender_origin', 'like', "%$query%")
                        // ->orWhere('description', 'like', "%$query%") // Removed: Column does not exist
                        ->get()
                        ->map(function($item) {
                            $item->type = 'Surat Masuk';
                            $item->date = $item->mail_date;
                            $item->route_name = 'incoming.show';
                            return $item;
                        });

            // Search Outgoing
            $outgoing = OutgoingMail::where('subject', 'like', "%$query%")
                        ->orWhere('mail_number', 'like', "%$query%")
                        ->orWhere('recipient_destination', 'like', "%$query%")
                        ->orWhere('content', 'like', "%$query%") // Changed from description to content
                        ->get()
                        ->map(function($item) {
                            $item->type = 'Surat Keluar';
                            $item->date = $item->mail_date;
                            $item->route_name = 'outgoing.show';
                            return $item;
                        });

            $results = $incoming->merge($outgoing)->sortByDesc('date');
        }

        return view('backend.documents.archive.index', compact('results', 'query'));
    }
}
