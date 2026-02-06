<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $query = User::with('roles');

    if ($request->has('search')) {
      $search = $request->search;
      $query->where('name', 'like', "%{$search}%")
        ->orWhere('email', 'like', "%{$search}%");
    }

    // Sort by ID Ascending so Admin (ID 1) is at the top
    $users = $query->oldest()->paginate(10);
    return view('backend.users.index', compact('users'));
  }

  public function create()
  {
    $roles = Role::pluck('name', 'name')->all();
    return view('backend.users.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|confirmed',
      'role' => 'required|exists:roles,name'
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $user->assignRole($request->role);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
  }

  public function edit(User $user)
  {
    $roles = Role::pluck('name', 'name')->all();
    return view('backend.users.edit', compact('user', 'roles'));
  }

  public function update(Request $request, User $user)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
      'password' => 'nullable|min:6|confirmed',
      'role' => 'required|exists:roles,name'
    ]);

    $userData = [
      'name' => $request->name,
      'email' => $request->email,
    ];

    if ($request->filled('password')) {
      $userData['password'] = Hash::make($request->password);
    }

    $user->update($userData);
    $user->syncRoles([$request->role]);

    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
  }

  public function destroy(User $user)
  {
    if (auth()->id() == $user->id) {
      return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
    }

    $user->delete();
    return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
  }
}
