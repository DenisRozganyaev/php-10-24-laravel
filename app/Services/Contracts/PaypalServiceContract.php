<?php

namespace App\Services\Contracts;

use App\Enums\TransactionStatusesEnum;

interface PaypalServiceContract
{
    public function create(): ?string;

    public function capture(string $vendorOrderId): TransactionStatusesEnum;
}
