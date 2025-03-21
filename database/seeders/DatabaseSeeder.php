<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsAndRolesSeeder::class);
        $this->call(ProductionSeeder::class);
//        $this->call(UsersSeeder::class);
//        $this->call(CategoriesAndProductsSeeder::class);
    }
}
