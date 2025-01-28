<?php

namespace App\Listeners\Cart;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Events\Login;

class RestoreOnLoginListener
{
    public function handle(Login $event): void
    {
        Cart::instance('cart')->restore('cart_' . $event->user->id);
    }
}
