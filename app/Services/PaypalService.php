<?php

namespace App\Services;

use App\Enums\TransactionStatusesEnum;
use Gloudemans\Shoppingcart\Facades\Cart;
use Srmklive\PayPal\Services\PayPal;

class PaypalService implements Contracts\PaypalServiceContract
{
    protected Paypal $payPal;

    public function __construct()
    {
        $this->payPal = app(PayPal::class);
        $this->payPal->setApiCredentials(config('paypal'));
        $this->payPal->setAccessToken($this->payPal->getAccessToken());
    }

    public function create(): ?string
    {
        $paypalOrder = $this->payPal->createOrder(
            $this->buildOrderRequestData()
        );

        logs()->info('[PaypalService::create] Getting paypal order', [
            'response' => $paypalOrder
        ]);

        return $paypalOrder['id'] ?? null;
    }

    public function capture(string $vendorOrderId): TransactionStatusesEnum
    {
        return TransactionStatusesEnum::Pending;
    }

    protected function buildOrderRequestData(): array
    {
        $cart = Cart::instance('cart');
        $currencyCode = config('paypal.currency');
        $items = [];

        $cart->content()
            ->each(function ($item) use (&$items, $currencyCode) {
                $items[] = [
                    'name' => $item->name,
                    'quantity' => $item->qty,
                    'sku' => $item->model->sku,
                    'url' => url(route('products.show', $item->model)),
                    'category' => 'PHYSICAL_GOODS',
                    'unit_amount' => [
                        'currency_code' => $currencyCode,
                        'value' => $item->price,
                    ],
                    'tax' => [
                        'currency_code' => $currencyCode,
                        'value' => round($item->price / 100 * $item->taxRate, 2),
                    ]
                ];
            });

        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currencyCode,
                        'value' => $cart->total(),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $currencyCode,
                                'value' => $cart->subtotal(),
                            ],
                            'tax_total' => [
                                'currency_code' => $currencyCode,
                                'value' => $cart->tax(),
                            ]
                        ]
                    ],
                    'items' => $items
                ]
            ]
        ];
    }
}
