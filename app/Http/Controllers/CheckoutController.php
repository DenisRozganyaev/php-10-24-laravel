<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        $cart = Cart::instance('cart');
        $user = auth()->user();

        //        $cart->content()->each(function ($item) use (&$taxSum) {
        //            dump($item->tax());
        //        });
        ////        dd($cart->content(), $cart->total(), $cart->tax(), $cart->subtotal());

        return view('checkout/index', compact('cart', 'user'));
    }
}
