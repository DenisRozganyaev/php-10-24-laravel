<?php

namespace Database\Seeders;

use App\Enums\Permissions\AccountEnum;
use App\Enums\Permissions\CategoryEnum;
use App\Enums\Permissions\OrderEnum;
use App\Enums\Permissions\ProductEnum;
use App\Enums\Permissions\UserEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ...AccountEnum::values(),
            ...CategoryEnum::values(),
            ...OrderEnum::values(),
            ...ProductEnum::values(),
            ...UserEnum::values(),
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        if (! Role::where('name', RoleEnum::CUSTOMER->value)->exists()) {
            Role::create(['name' => RoleEnum::CUSTOMER->value])
                ->givePermissionTo(AccountEnum::values());
        }

        if (! Role::where('name', RoleEnum::MODERATOR->value)->exists()) {
            Role::create(['name' => RoleEnum::MODERATOR->value])
                ->givePermissionTo([
                    ...CategoryEnum::values(),
                    ...ProductEnum::values(),
                ]);
        }

        if (! Role::where('name', RoleEnum::ADMIN->value)->exists()) {
            Role::create(['name' => RoleEnum::ADMIN->value])
                ->givePermissionTo(Permission::all());
        }
    }
}
