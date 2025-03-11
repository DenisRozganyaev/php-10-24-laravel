<?php

namespace App\Jobs\WishList;

use App\Enums\WishListEnum;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

abstract class BaseJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Product $product, public array $data = [])
    {
        $this->onQueue('wishlist');
    }

    abstract public function handle(): void;

    protected function sendNotification(string $notificationClass, WishListEnum $type): void
    {
        $this->product
            ->followers()
            ->wherePivot($type->value, true)
            ->chunk( // 300 => each all 300 => chunk [100, 100, 100]
                100,
                fn (Collection $users) => Notification::send(
                    $users,
                    app($notificationClass, [
                        'product' => $this->product,
                        'data' => $this->data,
                    ])
                )
            );
    }
}
