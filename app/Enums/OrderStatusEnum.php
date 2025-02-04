<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case InProcess = 'In Process';
    case Paid = 'Paid';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
