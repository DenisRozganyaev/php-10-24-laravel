<?php

namespace Database\Seeders;

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
        User::firstOrCreate([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '00033399922',
            'password' => Hash::make('test1234'),
        ]);
    }
}
