<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Api\v1\ProductEditRequest;
use App\Models\Product;
use Illuminate\Http\Request;

interface ProductsRepositoryContract
{
    public function paginate(Request $request, bool $withCache = true);

    public function store(CreateRequest $request): Product|false;

    public function update(Product $product, EditRequest|ProductEditRequest $request): bool;
}
