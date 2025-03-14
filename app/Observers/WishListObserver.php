<?php

namespace App\Observers;

use App\Jobs\WishList\InStockJob;
use App\Jobs\WishList\PriceUpdatedJob;
use App\Models\Product;

class WishListObserver
{
    public function updated(Product $product): void
    {
        if ($product->finalPrice < $product->getOriginal('finalPrice')) {
            PriceUpdatedJob::dispatch($product, [
                'old_price' => $product->getOriginal('finalPrice'),
            ]);
        }

        if ($product->in_stock && ! $product->getOriginal('in_stock')) {
            InStockJob::dispatch($product);
        }
    }
}
