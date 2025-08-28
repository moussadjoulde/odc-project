<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Réinitialiser le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions 
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'manage products',
            'manage categories',
            'manage orders',
            'manage payments',
            'view orders',
            'place orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Rôles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $vendor = Role::firstOrCreate(['name' => 'vendor']);
        $customer = Role::firstOrCreate(['name' => 'customer']);

        // Attribution des permissions aux rôles
        $admin->givePermissionTo(Permission::all());

        $vendor->givePermissionTo([
            'manage products',
            'manage categories',
            'view orders',
        ]);

        $customer->givePermissionTo([
            'place orders',
            'view orders',
        ]);
    }
}
