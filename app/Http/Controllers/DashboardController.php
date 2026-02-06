<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingMail;
use App\Models\OutgoingMail;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $role = $user->getRoleNames()->first() ?? 'User';

    // Fetch stats only if needed (or fetch all and filter in view)
    // For simplicity and performance, we fetch basic counts.
    // In a very high traffic app, we might cache these.

    $stats = [
      'incoming_mail' => IncomingMail::count(),
      'outgoing_mail' => OutgoingMail::count(),
      'students' => Student::where('status', 'active')->count(),
      'teachers' => Teacher::where('status', 'active')->count(),
    ];

    return view('backend.dashboard.index', compact('role', 'stats'));
  }
  public function guide()
  {
    return view('backend.guide.index');
  }
}
