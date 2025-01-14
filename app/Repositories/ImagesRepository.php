<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ImagesRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ImagesRepository implements Contracts\ImagesRepositoryContract
{
    public function attach(Model $model, string $relation, array $images = [], ?string $path = null): void
    {
        if (!method_exists($model, $relation)) {
            throw new Exception("[ImagesRepository]: ($relation) does not have exists in " . $model::class);
        }

        if (!empty($images)) {
            foreach ($images as $image) {
                // $model === Product
                // $product->images()->create()
                call_user_func([$model, $relation])->create([
                    'path' => compact('path', 'image')
                ]);
            }
        }
    }
}
