<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::orderByDesc('id')->take(5)->get();
        $products = Product::orderByDesc('id')->take(8)->get();

        return view('home', compact('categories', 'products'));
    }
}
