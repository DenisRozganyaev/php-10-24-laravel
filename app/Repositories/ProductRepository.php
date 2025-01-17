<?php

namespace App\Repositories;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Models\Product;
use App\Repositories\Contracts\ImagesRepositoryContract;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProductRepository implements Contracts\ProductsRepositoryContract
{
    public function __construct(protected ImagesRepositoryContract $imagesRepository)
    {
    }

    public function store(CreateRequest $request): Product|false
    {
        try {
            DB::beginTransaction();

            $data = $this->formRequestData($request);

            $product = Product::create($data['attributes']);
            $this->updateRelationData($product, $data);

            DB::commit();

            return $product;
        } catch (Throwable $th) {
            DB::rollBack();
            logs()->error('[ProductRepository::store] ' . $th->getMessage(), [
                'exception' => $th,
                'request' => $request->all()
            ]);

            return false;
        }
    }

    public function update(Product $product, EditRequest $request): bool
    {
        try {
            DB::beginTransaction();

            $data = $this->formRequestData($request);

            $product->update($data['attributes']);
            $this->updateRelationData($product, $data);

            DB::commit();

            return true;
        } catch (Throwable $th) {
            DB::rollBack();
            logs()->error('[ProductRepository::update] ' . $th->getMessage(), [
                'exception' => $th,
                'request' => $request->all()
            ]);

            return false;
        }
    }

    protected function formRequestData(CreateRequest|EditRequest $request): array
    {
        return [
            'attributes' => collect($request->validated())
                ->except(['categories', 'images'])
                ->prepend(Str::slug($request->get('title')), 'slug')
                ->toArray(),
            'categories' => $request->get('categories', []),
            'images' => $request->file('images', []),
        ];
    }

    protected function updateRelationData(Product $product, array $data): void
    {
        $product->categories()->sync($data['categories']);

        $this->imagesRepository->attach(
            $product,
            'images',
            $data['images'],
            $product->imagesFolderPath()
        );
    }
}
