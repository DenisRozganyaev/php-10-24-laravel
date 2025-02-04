<?php

namespace App\Repositories\Contracts;

use App\Enums\PaymentSystemEnum;
use App\Enums\TransactionStatusesEnum;
use App\Models\Order;

interface OrderRepositoryContract
{
    public function create(array $data): Order|false;

    public function setTransaction(
        string $vendorOrderId,
        PaymentSystemEnum $paymentSystem,
        TransactionStatusesEnum $status
    ): Order;
}
