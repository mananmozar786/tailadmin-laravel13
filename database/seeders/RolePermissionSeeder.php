<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Default Permissions
        $permissions = [
            'view.dashboard',
            'view.users',
            'create.users',
            'edit.users',
            'delete.users',
            'view.roles',
            'create.roles',
            'edit.roles',
            'delete.roles',
            'view.permissions',
            'create.permissions',
            'edit.permissions',
            'delete.permissions',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Roles and Assign Permissions
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);
        // Assign all permissions to super admin (though usually handled via a gate)
        $superAdminRole->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $managerRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $managerRole->syncPermissions(['view.dashboard', 'view.users', 'create.users', 'edit.users']);

        $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions(['view.dashboard', 'view.users']);

        // Assign Super Admin to the first user
        $firstUser = \App\Models\User::orderBy('id', 'asc')->first();
        if ($firstUser) {
            $firstUser->assignRole($superAdminRole);
        }

        // Create Initial Users and Assign Roles (Optional if they already exist, but good for demo)
        $superAdmin = \App\Models\User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status' => 'active',
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status' => 'active',
            ]
        );
        $admin->assignRole($adminRole);
    }
}
