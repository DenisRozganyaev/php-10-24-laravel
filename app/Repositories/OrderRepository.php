<?php

namespace App\Repositories;

use App\Enums\PaymentSystemEnum;
use App\Enums\TransactionStatusesEnum;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryContract;

class OrderRepository implements Contracts\OrderRepositoryContract
{

    public function create(array $data): Order|false
    {
        return false;
    }

    public function setTransaction(string $vendorOrderId, PaymentSystemEnum $paymentSystem, TransactionStatusesEnum $status): Order
    {
        return new Order();
    }
}
