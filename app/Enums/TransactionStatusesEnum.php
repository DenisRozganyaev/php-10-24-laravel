<?php

namespace App\Enums;

enum TransactionStatusesEnum: string
{
    case Success = 'Success';
    case Cancelled = 'Cancelled';
    case Pending = 'Pending';
}
