<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        // Create Roles (Use firstOrCreate to avoid duplication if PermissionSeeder ran first)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $kepsekRole = Role::firstOrCreate(['name' => 'kepalasekolah']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator']);

        // Create Default Users with Roles

        // 1. Admin TU
        $admin = User::firstOrCreate([
            'email' => 'ardiansyahdzan@gmail.com'
        ], [
            'name' => 'Ardiansyah',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // 2. Kepala Sekolah
        $kepsek = User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@sekolah.id',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $kepsek->assignRole($kepsekRole);

        // 3. Operator
        $operator = User::create([
            'name' => 'Operator TU',
            'email' => 'operator@sekolah.id',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $operator->assignRole($operatorRole);
    }
}
