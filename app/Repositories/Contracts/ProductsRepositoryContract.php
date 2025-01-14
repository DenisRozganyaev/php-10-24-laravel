<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Models\Product;

interface ProductsRepositoryContract
{
    public function store(CreateRequest $request): Product|false;
}
