<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Models\Product;
use Illuminate\Http\Request;

interface ProductsRepositoryContract
{
    public function paginate(Request $request);

    public function store(CreateRequest $request): Product|false;

    public function update(Product $product, EditRequest $request): bool;
}
