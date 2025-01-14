<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions\CategoryEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\EditRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['parent'])
            ->withCount(['products'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();

        return view('admin/categories/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $category = Category::create([
            ...$request->validated(),
            'slug' => Str::slug($request->get('name'))
        ]);

        notify()->success("Category '$category->name' is created");

        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->load(['parent']);

        $categories = Category::select(['id', 'name'])->get();

        return view('admin/categories/edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Category $category)
    {
        $data = [
            ...$request->validated(),
            'slug' => Str::slug($request->get('name'))
        ];

        $category->updateOrFail($data);

        notify()->success("Category '$category->name' was updated");

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->middleware('permission:' . CategoryEnum::DELETE->value);

        $category->deleteOrFail();

        notify()->success("Category '$category->name' was deleted");

        return redirect()->route('admin.categories.index');
    }
}
