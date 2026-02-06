<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;
use App\Models\OutgoingMail;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'incoming');
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        if ($type == 'incoming') {
            $data = IncomingMail::with('category')
                ->whereBetween('received_date', [$startDate, $endDate])
                ->orderBy('received_date', 'asc')
                ->get();
        } else {
            $data = OutgoingMail::with('category', 'approver')
                ->whereBetween('mail_date', [$startDate, $endDate])
                ->orderBy('mail_date', 'asc')
                ->get();
        }

        return view('backend.correspondence.agenda.index', compact('data', 'type', 'startDate', 'endDate'));
    }

    public function print(Request $request)
    {
        $type = $request->input('type', 'incoming');
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        if ($type == 'incoming') {
            $data = IncomingMail::with('category')
                ->whereBetween('received_date', [$startDate, $endDate])
                ->orderBy('received_date', 'asc')
                ->get();
            $title = 'BUKU AGENDA SURAT MASUK';
        } else {
            $data = OutgoingMail::with('category', 'approver')
                ->whereBetween('mail_date', [$startDate, $endDate])
                ->orderBy('mail_date', 'asc')
                ->get();
            $title = 'BUKU AGENDA SURAT KELUAR';
        }

        return view('backend.correspondence.agenda.print', compact('data', 'type', 'startDate', 'endDate', 'title'));
    }
}
