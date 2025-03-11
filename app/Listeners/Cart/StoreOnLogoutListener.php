<?php

namespace App\Listeners\Cart;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Events\Logout;

class StoreOnLogoutListener
{
    public function handle(Logout $event): void
    {
        if (Cart::instance('cart')->count() > 0) {
            Cart::instance('cart')->store('cart_'.$event->user->id);
        }
    }
}
