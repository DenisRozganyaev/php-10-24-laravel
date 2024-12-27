<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriesAndProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();
        DB::table('products')->truncate();

        Storage::deleteDirectory('faker');

        Category::factory(2)->create();
        Category::factory(5)->hasProducts(3)->create();

        Category::factory(2)->withParent()->create();
        Category::factory(2)->withParent()->hasProducts(2)->create();
    }
}
