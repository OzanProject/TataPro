<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use DB;

class RoleController extends Controller
{
  public function index()
  {
    // Get all roles except super-admin if necessary, but here we show all
    $roles = Role::with('permissions')->orderBy('id', 'ASC')->paginate(10);
    return view('backend.roles.index', compact('roles'));
  }

  public function create()
  {
    $permissions = Permission::all();
    // Group permissions by their prefix for better UI (e.g., 'user-create' -> 'user')
    $permissionGroups = $permissions->groupBy(function ($item) {
      $parts = explode('-', $item->name);
      return $parts[0];
    });

    return view('backend.roles.create', compact('permissionGroups'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:roles,name',
      'permissions' => 'required|array'
    ]);

    $role = Role::create(['name' => $request->name]);
    $role->syncPermissions($request->permissions);

    return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
  }

  public function edit($id)
  {
    $role = Role::find($id);
    $permissions = Permission::all();
    $permissionGroups = $permissions->groupBy(function ($item) {
      $parts = explode('-', $item->name);
      return $parts[0];
    });

    $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
      ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
      ->all();

    return view('backend.roles.edit', compact('role', 'permissionGroups', 'rolePermissions'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required',
      'permissions' => 'required|array',
    ]);

    $role = Role::find($id);

    // Prevent renaming seeded critical roles to something else if needed, 
    // but generally we allow it or just sync permissions.
    $role->name = $request->name;
    $role->save();

    $role->syncPermissions($request->permissions);

    return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
  }

  public function destroy($id)
  {
    // Prevent deleting Admin role
    $role = Role::find($id);
    if ($role->name == 'admin') {
      return back()->with('error', 'Role Admin tidak dapat dihapus!');
    }

    DB::table("roles")->where('id', $id)->delete();
    return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
  }
}
