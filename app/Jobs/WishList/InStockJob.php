<?php

namespace App\Jobs\WishList;

use App\Enums\WishListEnum;
use App\Notifications\WishList\InStockNotification;

class InStockJob extends BaseJob
{
    public function handle(): void
    {
        $this->sendNotification(InStockNotification::class, WishListEnum::InStock);
    }
}
