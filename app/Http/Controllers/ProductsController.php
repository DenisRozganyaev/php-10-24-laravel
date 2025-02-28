<?php

namespace App\Http\Controllers;

use App\Enums\WishListEnum;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    public function index(Request $request, ProductsRepositoryContract $repository)
    {
        $per_page = $request->get('per_page', $repository::PER_PAGE);
        $selectedCategory = $request->get('category');

        $products = $repository->paginate($request);
        $categories = Cache::flexible('products_categories', [5, 3600], fn () => Category::whereHas('products')->get());


        return view('products.index', compact('products', 'per_page', 'categories', 'selectedCategory'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['categories', 'images']);

        $wishListInfo = [];
        $gallery = [
            $product->thumbnailUrl,
            ...$product->images->map(fn ($image) => $image->url)
        ];

        if (auth()->check()) {
            $user = auth()->user();

            $wishListInfo = [
                'in_stock' => $user->isWished($product->id, WishListEnum::InStock),
                'price' => $user->isWished($product->id)
            ];
        }

        return view('products.show', compact('product', 'gallery', 'wishListInfo'));
    }
}
