<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions\ProductEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Throwable;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['categories'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin/products/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();

        return view('admin/products/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, ProductsRepositoryContract $repository)
    {
        if ($product = $repository->store($request)) {
            notify()->success("Product [$product->title] was created");

            return redirect()->route('admin.products.index');
        }
        notify()->error("Oops! Something went wrong");

        return redirect()->back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'images']);

        $categories = Category::select(['id', 'name'])->get();
        $productCategories = $product->categories->pluck('id')->toArray();

        return view('admin/products/edit', compact('product', 'categories', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Product $product, ProductsRepositoryContract $repository)
    {
        if ($repository->update($product, $request)) {
            notify()->success("Product [$product->title] was updated");

            return redirect()->route('admin.products.edit', $product);
        }
        notify()->error("Oops! Something went wrong");

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $this->middleware('permission:' . ProductEnum::DELETE->value);

            $product->deleteOrFail();

            notify()->success("Product '$product->title' was deleted");

            return redirect()->route('admin.categories.index');
        } catch (Throwable $th) {
            logs()->error($th->getMessage());
            notify()->error("Oops! Something went wrong");
            return redirect()->back()->withInput();
        }
    }
}
