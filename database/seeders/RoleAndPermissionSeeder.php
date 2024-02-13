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

        $superAdminRole = Role::query()->updateOrCreate([
            'name' => 'super-admin'
        ]);

        $sindicoRole = Role::query()->updateOrCreate([
            'name' => 'Síndico'
        ]);
        $condominoRole = Role::query()->updateOrCreate([
            'name' => 'Condômino'
        ]);
        $porteiroRole = Role::query()->updateOrCreate([
            'name' => 'Porteiro'
        ]);

        // create or update permissions
        foreach ($this->getPermissionsName() as $permissionName => $permission) {

            $permissionModel = Permission::query()->updateOrCreate([
                'name' => $permissionName
            ]);

            if ($permission['super-admin']) {
                $superAdminRole->givePermissionTo($permissionModel);
            }
            if ($permission['sindico']) {
                $sindicoRole->givePermissionTo($permissionModel);
            }
            if ($permission['condomino']) {
                $condominoRole->givePermissionTo($permissionModel);
            }
            if ($permission['porteiro']) {
                $porteiroRole->givePermissionTo($permissionModel);
            }

        }

        if (env('CREATE_USERS_ON_SEED', true)){
            $superAdmin = User::create([
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password')
            ]);

            $superAdmin->assignRole($superAdminRole);
        }

    }

    protected function getPermissionsName(): array
    {
        return [
            //Users Permissions
            'users create' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'users edit' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => true,
            ],
            'users list' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'users delete' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'users restore' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],

            //Blocks Permissions
            'blocks create' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'blocks edit' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'blocks list' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'blocks delete' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'blocks restore' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],

            //Apartments Permissions
            'apartments create' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'apartments edit' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'apartments list' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'apartments delete' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'apartments restore' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],

            //Visitors Permissions
            'visitors create' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'visitors edit' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'visitors list' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'visitors delete' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'visitors restore' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],

            //Common Areas Permissions
            'common-areas create' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'common-areas edit' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'common-areas list' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => true,
                'porteiro' => true,
            ],
            'common-areas delete' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],
            'common-areas restore' => [
                'super-admin' => true,
                'sindico' => true,
                'condomino' => false,
                'porteiro' => false,
            ],

        ];
    }
}
