<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function edit()
  {
    $user = Auth::user();
    return view('backend.profile.edit', compact('user'));
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
      'password' => 'nullable|string|min:8|confirmed',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
      $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('photo')) {
      // Delete old photo if exists and not default
      if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
        Storage::disk('public')->delete($user->profile_photo_path);
      }

      $path = $request->file('photo')->store('profile-photos', 'public');
      $user->profile_photo_path = $path;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
  }
}
