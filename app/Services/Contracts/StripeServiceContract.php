<?php

namespace App\Services\Contracts;

interface StripeServiceContract
{
    public function create(array $data): array;
}
