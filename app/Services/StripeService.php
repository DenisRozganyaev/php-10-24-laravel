<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

class StripeService implements Contracts\StripeServiceContract
{
    public function create(array $data): array
    {
        $price = str_replace('.', '', Cart::instance('cart')->total(2));

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        $payment = $stripe->paymentIntents->create([
            'amount' => $price,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'metadata' => [
                ...$data,
                'user_id' => auth()?->id(),
            ],
        ]);

        return [
            'payment_id' => $payment->id,
            'client_secret' => $payment->client_secret,
        ];
    }
}
