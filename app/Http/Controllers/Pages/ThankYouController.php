<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Throwable;

class ThankYouController extends Controller
{
    public function __invoke(string $vendorOrderId)
    {
        try {
            $order = Order::with(['transaction', 'products'])
                ->where('vendor_order_id', $vendorOrderId)
                ->firstOrFail();
            $showInvoiceBtn = (bool) $order->user_id;

            return view('orders/thank-you', compact('order', 'showInvoiceBtn'));
        } catch (Throwable $throwable) {
            logs()->error('[ThankYouController] '.$throwable->getMessage(), [
                'exception' => $throwable,
                'vendorOrderId' => $vendorOrderId,
            ]);

            return redirect()->route('home');
        }
    }
}
