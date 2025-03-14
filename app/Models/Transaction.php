<?php

namespace App\Models;

use App\Enums\PaymentSystemEnum;
use App\Enums\TransactionStatusesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => TransactionStatusesEnum::class,
        'payment_system' => PaymentSystemEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
