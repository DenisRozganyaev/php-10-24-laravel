<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '00033399922',
            'password' => Hash::make('test1234'),
        ]);

        $user->assignRole(RoleEnum::ADMIN->value);
    }
}
