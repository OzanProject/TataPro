<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Define Permissions
    $permissions = [
      // User Management
      'user-list',
      'user-create',
      'user-edit',
      'user-delete',

      // Role Management
      'role-list',
      'role-create',
      'role-edit',
      'role-delete',

      // Mail Management (Surat Masuk/Keluar)
      'mail-list',
      'mail-create',
      'mail-edit',
      'mail-delete',
      'disposition-list',
      'disposition-create',
      'disposition-edit',
      'disposition-delete',

      // Student Management
      'student-list',
      'student-create',
      'student-edit',
      'student-delete',

      // Teacher Management
      'teacher-list',
      'teacher-create',
      'teacher-edit',
      'teacher-delete',

      // Settings
      'setting-list',
      'setting-edit',
    ];

    foreach ($permissions as $permission) {
      Permission::firstOrCreate(['name' => $permission]);
    }

    // Get Roles
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $kepsek = Role::firstOrCreate(['name' => 'kepalasekolah']);
    $operator = Role::firstOrCreate(['name' => 'operator']);

    // Assign Permissions to Admin (All)
    $admin->syncPermissions(Permission::all());

    // Assign Permissions to Kepala Sekolah (View/List Only & Dispositions)
    $kepsek->syncPermissions([
      'mail-list',
      'disposition-list',
      'student-list',
      'teacher-list'
      // Kepsek can create disposition (usually) but maybe just view for now or as requested.
      // Let's add disposition-create as they usually disposisi surat.
      ,
      'disposition-create'
    ]);

    // Assign Permissions to Operator (All Operational Except User/Role/Settings)
    $operator->syncPermissions([
      'mail-list',
      'mail-create',
      'mail-edit',
      'mail-delete',
      'disposition-list',
      'disposition-create',
      'disposition-edit',
      'student-list',
      'student-create',
      'student-edit',
      'student-delete',
      'teacher-list',
      'teacher-create',
      'teacher-edit',
      'teacher-delete',
    ]);
  }
}
