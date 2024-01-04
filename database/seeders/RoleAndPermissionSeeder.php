<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        foreach ($this->getPermissionsName() as $permissionName => $permission) {
            Permission::create([
                'name' => $permissionName
            ]);
        }

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);

        // create roles and assign created permissions

        $role = Role::create([
            'name' => 'super-admin'
        ]);
        $role->givePermissionTo(Permission::all());

        $superAdmin->assignRole($role);
    }

    protected function getPermissionsName(): array
    {
        return [
            //Clients Permissions
            'roles create' => true,
            'roles edit' => true,
            'roles list' => true,
            'roles delete' => true,
            'roles restore' => true,
        ];
    }
}
